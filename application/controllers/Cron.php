<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('paypal');
		$this->load->model(['Rfp_model','Notification_model']);
	}
	
	public function index(){
				
	}

	// first run before check status ( For Use Second Payment - 45 Days Only)
	public function get_payments(){

		$all_data = $this->Rfp_model->get_result('billing_schedule',['next_billing_date'=>date('Y-m-d'),'transaction_id is null'=>null,'status'=>'0']);
		
		// pr($all_data,1);

		if(!empty($all_data)){

			foreach($all_data as $a_data){

				pr($a_data);
				
				$due_amt = $a_data['price'];

				// make sure the price is greater than 0
				if($a_data['price'] > 0){

					//fetch agreement data for doctor (only active agreements)
					$res_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$a_data['doctor_id'],'status'=>'1'],true);

					// prev transaction data
					$last_transaction = $this->Rfp_model->get_result('payment_transaction',['user_id'=>$a_data['doctor_id'],'rfp_id'=>$a_data['rfp_id']],true);

					if(!empty($res_data)){

						$billing_id = $res_data['billing_id']; // Active Billing Agreement

						$ret_arr = DoReferenceTransaction($billing_id,$due_amt);

						$ret_arr_json = json_encode($ret_arr);
						$ack_reference = strtoupper($ret_arr['ACK']);

						//  v! IF Acknoledgement is success means payment has beed successed by doctor
						if($ack_reference == "SUCCESS" || $ack_reference == "SUCCESSWITHWARNING") {
							$payment_status = strtoupper($ret_arr['PAYMENTSTATUS']);
							
							$db_status = '0';
							if($payment_status == 'COMPLETED'){
								$db_status = '1';
							}

							//Check status update in billing schedule
							$this->Rfp_model->update_record('billing_schedule',['id'=>$a_data['id']],
																			   ['status'=>$db_status,
																			   'transaction_id'=>$ret_arr['TRANSACTIONID']]);

							// ------------------------------------------------------------------------
							// Insert datainto transaction for pending transaction
							// ------------------------------------------------------------------------
							$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$a_data['doctor_id'],'status'=>'1'],true);
				        	$paypal_email = '';
				        	if(!empty($agreement_data)){
				        		$agreement_data = json_decode($agreement_data['meta_arr']);
				        		$paypal_email= $agreement_data->EMAIL;
				        	}


							$transaction_arr =  array(
		        							'user_id'=>$a_data['doctor_id'],
		        							'rfp_id'=>$a_data['rfp_id'],
		        							'actual_price'=>$last_transaction['actual_price'],
		        							'payable_price'=>$due_amt,
		        							'discount'=>$last_transaction['discount'],
		        							'promotional_code_id'=>$last_transaction['promotional_code_id'],
		        							'paypal_token'=>$ret_arr['TRANSACTIONID'],
		        							'meta_arr'=>$ret_arr_json,
		        							'status'=>$db_status,
		        							'paypal_email'=>$paypal_email,
		        							'created_at'=>date('Y-m-d H:i:s')
		        						);
		        			$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
		        			// ------------------------------------------------------------------------		        			
						
						}else{

							// ### IF Agreemet was being cacelled by user
							$this->Rfp_model->update_record('billing_schedule',['id'=>$a_data['id']],
																				['status'=>'0','transaction_id'=>'DOCTOR_PAYMENT_ERROR']);

							// Check status update in billing schedule
							$this->Rfp_model->update_record('billing_agreement',['doctor_id'=>$a_data['doctor_id']],
																			  	['status'=>'0']);
													
							// ------------------------------------------------------------------------
							$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$a_data['doctor_id'],'status'=>'1'],true);
				        	$paypal_email = '';
				        	if(!empty($agreement_data)){
				        		$agreement_data = json_decode($agreement_data['meta_arr']);
				        		$paypal_email= $agreement_data->EMAIL;
				        	}

							$transaction_arr =  array(
		        							'user_id'=>$a_data['doctor_id'],
		        							'rfp_id'=>$a_data['rfp_id'],
		        							'actual_price'=>$last_transaction['actual_price'],
		        							'payable_price'=>$a_data['price'],
		        							'discount'=>$last_transaction['discount'],
		        							'promotional_code_id'=>$last_transaction['promotional_code_id'],
		        							'paypal_token'=>'DOCTOR_PAYMENT_ERROR',
		        							'meta_arr'=>$ret_arr_json,
		        							'status'=>'0',
		        							'paypal_email'=>$paypal_email,
		        							'created_at'=>date('Y-m-d H:i:s')
		        						);
		        			$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
		        			// ------------------------------------------------------------------------
						}
					}
				}else{
					// IF price is ZERO means there is only one due payment enter
					$return_data = $this->Rfp_model->check_if_close_rfp($a_data['rfp_id']);

					if($return_data['is_close'] == '1'){
						$this->Rfp_model->send_close_rfp_notification($a_data['doctor_id'],$a_data['rfp_id']);
						$this->Rfp_model->update_record('rfp',['id'=>$a_data['rfp_id']],['status'=>'7']); // Close RFP after 45 days
					}else{
						$this->Rfp_model->update_record('rfp',['id'=>$a_data['rfp_id']],['rfp_close_date'=>$return_data['next_date']]); // Close RFP after appointment date + 10 days
					}
					$this->Rfp_model->update_record('billing_schedule',['rfp_id'=>$a_data['rfp_id'],'price'=>'0'],['status'=>'1']);
				}

			} // ForEACH ENs here
		}
	}

	// second run ( after get_payments func )
	public function check_status(){

		$res_data = $this->Rfp_model->get_result('billing_schedule',['status'=>'0','transaction_id is not null'=>null,'next_billing_date'=>date('Y-m-d')]);

		if(!empty($res_data)){
			$return_arr = [];

			foreach($res_data as $res){

				if($res['transaction_id'] == 'MANUAL'){
					
					$return_arr['PAYMENTSTATUS'] = 'Completed';
					$ack_transaction = "SUCCESS";

					if($res['price'] > 0){
						$last_transaction = $this->Rfp_model->get_result('payment_transaction',['user_id'=>$res['doctor_id'],'rfp_id'=>$res['rfp_id']],true);
						//------------- Payment Transaction For Manual ------
						$transaction_arr =  array(
	        							'user_id'=>$res['doctor_id'],
	        							'rfp_id'=>$res['rfp_id'],
	        							'actual_price'=>$last_transaction['actual_price'],
	        							'payable_price'=>$res['price'],
	        							'discount'=>$last_transaction['discount'],
	        							'promotional_code_id'=>$last_transaction['promotional_code_id'],
	        							'payment_type' => 1, // 1 Means Manual Payment 
	        							'status' => 0,
	        							'created_at'=>date('Y-m-d H:i:s')
	        						);

						$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
						//------------- End Payment Transaction ------
					}	

				}
				else{
					$return_arr = GetTransactionDetails($res['transaction_id']);
					$ack_transaction = strtoupper($return_arr['ACK']);	
				}
							

				if($ack_transaction == "SUCCESS" || $ack_transaction == "SUCCESSWITHWARNING") {
					
					if($return_arr['PAYMENTSTATUS'] == 'Completed'){

						$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$res['rfp_id']],true);
						
						
						// v! IF RFP's both payment is completed
						if($rfp_data['status'] == '6'){
							
							$return_data = $this->Rfp_model->check_if_close_rfp($res['rfp_id']);
							pr($return_data);

							if($return_data['is_close'] == '1'){
								$this->Rfp_model->send_close_rfp_notification($res['doctor_id'],$res['rfp_id']);
								$this->Rfp_model->update_record('rfp',['id'=>$res['rfp_id']],['status'=>'7']); // status : 6 - change waiting for doctor approval to close
							}else{
								$this->Rfp_model->update_record('rfp',['id'=>$res['rfp_id']],['rfp_close_date'=>$return_data['next_date']]); // Close RFP after appointment date + 10 days
								qry();
							}
						}else if($rfp_data['status'] == '5'){
							
					    	$this->Rfp_model->send_close_rfp_notification($res['doctor_id'],$res['rfp_id']);
							$this->Rfp_model->update_record('rfp',['id'=>$res['rfp_id']],['status'=>'7']); // status : 5 - change appointment pending to close
						}elseif($rfp_data['status'] <= '4'){
							// v! IF RFP's first payment is completed
							// Update data into RFP_BID table change status to is_chat_started to 1 so messages can exchange on both end
							// ------------------------------------------------------------------------
							$doc_id = $res['doctor_id'];
							$patient_id = $rfp_data['patient_id'];
							$rfp_id = $res['rfp_id'];

							$this->Rfp_model->update_record('rfp_bid',['doctor_id'=>$doc_id,'status'=>'2','rfp_id'=>$rfp_id],['is_chat_started'=>'1']);
							// ------------------------------------------------------------------------
							// Insert default message sent it to doctor by the system							
							// ------------------------------------------------------------------------
							$ins_data = array(
												'rfp_id'=>$rfp_id,
												'from_id'=>$patient_id,
												'to_id'=>$doc_id,
												'message'=>'( Auto-generated message ) You have been selected for '.$rfp_data['title'].' RFP.',
												'created_at'=>date('Y-m-d H:i:s'),
											);
							$this->Rfp_model->insert_record('messages',$ins_data);
							// ------------------------------------------------------------------------

							// ----------------------------- Patient Notification -----------------------------
					    	$noti_data = [
					    					'from_id'=>$res['doctor_id'],
					    					'to_id'=>$rfp_data['patient_id'],
					    					'rfp_id'=>$res['rfp_id'],
					    					'noti_type'=>'confirm_payment',
					    					'noti_msg'=>'Congratulation..!! Doctor has confirmed the Request - <b>'.$rfp_data['title'].'</b>.Please contact doctor for appointment.',
					    					'noti_url'=>'dashboard'
					    				];
					    	$this->Notification_model->insert_rfp_notification($noti_data);
					    	// ------------------------------------------------------------------------

							// -----------------------------  Doctor Notification  -----------------------------
					    	$noti_data = [
					    					'from_id'=>$rfp_data['patient_id'],
					    					'to_id'=>$res['doctor_id'],
					    					'rfp_id'=>$res['rfp_id'],
					    					'noti_type'=>'confirm_payment',
					    					'noti_msg'=>'Congratulation..!! You\'re contract has been made with patient.',
					    					'noti_url'=>'dashboard'
					    				];
					    	$this->Notification_model->insert_rfp_notification($noti_data);
					    	// -----------------------------------------------------------------------

							$this->Rfp_model->update_record('rfp',['id'=>$res['rfp_id']],['status'=>'5']); 
						}

						$this->Rfp_model->update_record('billing_schedule',['id'=>$res['id']],['status'=>'1']);
						if($res['transaction_id'] != 'MANUAL'){
							$this->Rfp_model->update_record('payment_transaction',['paypal_token'=>$res['transaction_id']],['status'=>'1']);
						}

					}
				} // END of IF condition				
			}
		}
	}	

	// Close RFp based on Rfp_close_date from rfp table
	public function auto_close_rfp(){
	
		$this->db->select('rfp.id,rb.doctor_id');
		$this->db->from('rfp');
		$this->db->join('rfp_bid rb','rfp.id = rb.rfp_id and rb.status = 2','left');
		$this->db->where('rfp.rfp_close_date',date('Y-m-d'));
		$all_close_rfp = $this->db->get()->result_array();
		if(!empty($all_close_rfp)){
			foreach($all_close_rfp as $close_rfp){
				$this->Rfp_model->send_close_rfp_notification($close_rfp['doctor_id'],$close_rfp['id']);
				$this->Rfp_model->update_record('rfp',['id'=>$close_rfp['id']],['status'=>'7']);				
			}
		}
	}

	/*----------------- For Send message according to search filter ----------------- */
	public function send_mail_alert_doctor(){

		//--------------------- Fetch Doctor User For rfp notification --------
		$this->db->from('users');
		$this->db->where('role_id','4');
		$this->db->where('is_blocked','0');
		$this->db->where('is_deleted','0');
		$doctor_data = $this->db->get()->result_array();

		$rfp_notify_data=[];
		$up_filter_data =[];
		foreach ($doctor_data as $key => $doctor) {

			//------- For Fecth Filter data according to current date and userwise --------
			$this->db->from('custom_search_filter');
			$this->db->where('filter_cron_date',date("Y-m-d"));
			$this->db->where('user_id',$doctor['id']);
			$this->db->where('notification_status !=','0');
			$filter_data=$this->db->get()->result_array();
			$up_filter_data[$key] = $filter_data;
			//-------------------------------------------------------------------------
			//---------- For fetch category data and make a unique array --------------
			$category_data = [];
			$cat_data = [];
			if($filter_data){
				foreach($filter_data as $data){
					if(!empty($data['search_treatment_cat_id'])){
						$cat_data = explode(",",$data['search_treatment_cat_id']);
						$category_data=array_merge($category_data,$cat_data);
					}
				}
				$category_data=array_unique($category_data); 
			
				//--------------- For Check RFP exist or not based on treatment category ----
				$str='';
				foreach($category_data as $k=>$cat_id)
	            {
	                if($k == 0) {  
	                    $str .="FIND_IN_SET($cat_id,teeth_category)";
	                }else{
	                    $str .=" OR FIND_IN_SET($cat_id,teeth_category)";
	                }
	            }

	            $this->db->select('rfp.*,TIMESTAMPDIFF(YEAR, rfp.birth_date, CURDATE()) AS patient_age,TIMESTAMPDIFF(DAY,CURDATE(),rfp.rfp_valid_date) AS rfp_valid_days,u.id as user_id,( 3959 * acos( cos( radians(' . $doctor['latitude'] . ') ) * cos( radians( rfp.latitude ) ) * cos( radians( rfp.longitude ) - radians(' . $doctor['longitude'] . ') ) + sin( radians(' . $doctor['latitude'] . ') ) * sin( radians( rfp.latitude ) ) ) ) AS distance');
		        $this->db->from('rfp');
		        $this->db->join('users u','rfp.patient_id = u.id');

		        if(!empty($category_data)){
		            $this->db->where("(".$str.") != 0");
		        } 
		        $this->db->having('rfp.distance_travel >= distance'); // For check Patient travel distance or not
		        $this->db->where('rfp.status','3'); // For RFP Status Open (3)
		        $this->db->where('rfp.is_deleted','0');
		        $this->db->where('rfp.is_blocked','0');
		        $this->db->where('rfp.rfp_valid_date >= CURDATE()'); // For check rfp valid date >= curdate
		        $query = $this->db->get();
	        	$rfp_data=$query->result_array();
	        	$rfp_notify_data[$key]['rfp_data']=$rfp_data;
	        	$rfp_notify_data[$key]['doctor_id']=$doctor['id'];
	        	$rfp_notify_data[$key]['doctor_name']=$doctor['fname']." ".$doctor['lname'];
	        	$rfp_notify_data[$key]['doctor_email']=$doctor['email_id'];
		       //-----------------------------------------
	        }	
		}
		//--------------- Send Mail to user particualr RFP wise ------------------
		foreach($rfp_notify_data as $notify_user){
			if($notify_user['rfp_data']){
					//------------------ Html Message format ------------
					$msg = "New Request List <br/><br/>";
					$msg .="<table border='1' cellspacing='1' cellpadding='1' style='width:100%;'>
							<thead>
								<tr style='font-size:12px;font-weight:100;'>
									<th>Request #</th>
									<th>Request Title</th>
									<th>Patient Age</th>
									<th>Distance (Miles.)</th>
									<th>Request Remaining Days</th>
								</tr>
						</thead><tbody>";
					foreach($notify_user['rfp_data'] as $notify_rfp){
						$rfp_url = base_url('rfp/view_rfp/'.encode($notify_rfp['id']));
						$msg .= "<tr>
									<td>".$notify_rfp['id']."</td>
									<td><a href='".$rfp_url."'>".$notify_rfp['title']."</a></td>
									<td>".$notify_rfp['patient_age']."</td>
									<td>".round($notify_rfp['distance'],2)."</td>
									<td>".($notify_rfp['rfp_valid_days']+1)."</td>
								</tr>";	
					}
					$msg .= "</tbody></table>";
					$msg .= "<br><br>To update or change your notification preferences, please, go to your <a href='".base_url('dashboard')."'>Dashboard </a>";
					//------------------ End Html Message format ------------
					//------------ Send Mail Config-----------------
			    	$html_content=mailer('contact_inquiry','AccountActivation'); 
			        $username= $notify_user['doctor_name'];
			        $html_content = str_replace("@USERNAME@",$username,$html_content);
			        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
			       
			        $email_config = mail_config();
			        $this->email->initialize($email_config);
			        $subject=config('site_name').' - New Request Creation Notification';    
			        $this->email->from(config('contact_email'), config('sender_name'))
			                    ->to($notify_user['doctor_email'])
			                    ->subject($subject)
			                    ->message($html_content);
			        $this->email->send();
			        //------------ End Send Mail Config----------------- 
			}	
		}

		//------------- For Edit filter table cron date --------
		
		if($up_filter_data){
			$add_days = 0;
			foreach($up_filter_data as $filter_search_data){
				foreach($filter_search_data as $filter){
					if($filter['notification_status'] == 1){
						$add_days = 1; // status 1 means daily notification
					}
					else if($filter['notification_status'] == 2){
						$add_days = 7; // status 2 means weekly notification
					}
					else if($filter['notification_status'] == 3){
						$add_days = 15; // status 3 means bi-weekly notification
					}

					$condition = ['id'	=>	$filter['id']];
					$updateArray= [
							'filter_cron_date'	=>	date("Y-m-d", strtotime("+ ".$add_days." day")),
						];
					$this->Rfp_model->update_record('custom_search_filter',$condition,$updateArray); 
				}
			}
		}	
		// --------------- End Edit filter table cron date ------------
		//pr($rfp_notify_data);
		echo "Your cron - Alert notification for doctor execute successfully";
		die;
	}
	/* ------------------ End Send message according to search filter ---------------- */

	/*--------------- For Send Message Notification to Patient (12 Days) (Everydat run)------------------------ */
	public function patient_notification_12_days(){
		$this->db->select('r.*,CONCAT(u.fname," ",u.lname) as user_name,u.email_id,TIMESTAMPDIFF(DAY,r.rfp_approve_date,CURDATE()) AS rfp_create_days');
		$this->db->from('rfp r');
		$this->db->join('users u','r.patient_id = u.id');
		$this->db->where('u.is_deleted','0'); // 0 Means Not Deleted User
		$this->db->where('u.is_blocked','0'); // 0 Means Not Blocked User
		$this->db->where('r.is_deleted','0'); // 0 Means Not Deleted RFP
		$this->db->where('r.is_blocked','0'); // 0 Means Not Blocked RFP
		$this->db->where('r.is_extended','0'); // 0 Means Not Extend RFP
		$this->db->where('r.status','3'); // 3 Means status open
		$this->db->having('rfp_create_days','11'); // After 12 days from approve the rfp 
		$data = $this->db->get()->result_array();
		
		foreach($data as $record){

			$request_url = base_url('rfp/view_rfp_bid/'.encode($record['id']));
			$msg ="Your Request '".$record['title']."' is approved on 12 days ago so please <a href='".$request_url."''>click here</a> to extend request or select any winner from list";

			//------------ Send Mail Config-----------------
	    	$html_content=mailer('patient_notification_12_days','AccountActivation'); 
	        $username= $record['user_name'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $subject=config('site_name').' - Quote Request Received Day 12 Information';    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($record['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send();
	        //------------ End Send Mail Config----------------- 
		}
		pr($data,1);
	}
	/*--------------- End For Send Message Notification to Patient (12 Days)--------------------- */


	/*--------------- For Send Message Notification to Patient (14 Days) (Everydat run)------------------------ */
	public function patient_notification_14_days(){
		$this->db->select('r.*,CONCAT(u.fname," ",u.lname) as user_name,u.email_id,TIMESTAMPDIFF(DAY,r.rfp_approve_date,CURDATE()) AS rfp_create_days');
		$this->db->from('rfp r');
		$this->db->join('users u','r.patient_id = u.id');
		$this->db->where('u.is_deleted','0'); // 0 Means Not Deleted User
		$this->db->where('u.is_blocked','0'); // 0 Means Not Blocked User
		$this->db->where('r.is_deleted','0'); // 0 Means Not Deleted RFP
		$this->db->where('r.is_blocked','0'); // 0 Means Not Blocked RFP
		$this->db->where('r.is_extended','0'); // 0 Means Not Extend RFP
		$this->db->where('r.status','3'); // 3 Means status open
		$this->db->having('rfp_create_days','14'); // After 15 days from approve the rfp 
		$data = $this->db->get()->result_array();
	
		foreach($data as $record){

			$request_url = base_url('rfp/view_rfp_bid/'.encode($record['id']));
			$msg ="Your Request '".$record['title']."' is approved on 14 days ago and it's expire now.so please <a href='".$request_url."''>click here</a> to select any winner from list";

			//------------ Send Mail Config-----------------
	    	$html_content=mailer('patient_notification_14_days','AccountActivation'); 
	        $username= $record['user_name'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $subject=config('site_name').' - Quote Request "'.$record['title'].'" is Expired';    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($record['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send();
	        //------------ End Send Mail Config----------------- 
		}
		pr($data,1);
	}
	/*--------------- End For Send Message Notification to Patient (14 Days)--------------------- */

	/*--------------- For Send Message Notification to Patient (21 Days) (Everydat run)------------------------ */
	public function patient_notification_21_days(){
		$this->db->select('r.*,CONCAT(u.fname," ",u.lname) as user_name,u.email_id,TIMESTAMPDIFF(DAY,r.rfp_approve_date,CURDATE()) AS rfp_create_days');
		$this->db->from('rfp r');
		$this->db->join('users u','r.patient_id = u.id');
		$this->db->where('u.is_deleted','0'); // 0 Means Not Deleted User
		$this->db->where('u.is_blocked','0'); // 0 Means Not Blocked User
		$this->db->where('r.is_deleted','0'); // 0 Means Not Deleted RFP
		$this->db->where('r.is_blocked','0'); // 0 Means Not Blocked RFP
		$this->db->where('r.is_extended','1'); // 1 Means Extend RFP
		$this->db->where('r.status','3'); // 3 Means status open
		$this->db->having('rfp_create_days','21'); // After 22 days from approve the rfp 
		$data = $this->db->get()->result_array();
	
		foreach($data as $record){

			$request_url = base_url('rfp/view_rfp_bid/'.encode($record['id']));
			$msg ="Your Request '".$record['title']."' is approved on 21 days ago and it's expire now.so please <a href='".$request_url."''>click here</a> to select any winner from list";

			//------------ Send Mail Config-----------------
	    	$html_content=mailer('patient_notification_21_days','AccountActivation'); 
	        $username= $record['user_name'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $subject=config('site_name').' - Quote Request "'.$record['title'].'" is Expired';    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($record['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send();
	        //------------ End Send Mail Config----------------- 
		}
		pr($data,1);
	}
	/*--------------- End For Send Message Notification to Patient (21 Days)--------------------- */


	/*--------------- For Send Message Notification to Patient (27 Days) (Everydat run)------------------------ */
	public function patient_notification_27_days(){
		$this->db->select('r.*,CONCAT(u.fname," ",u.lname) as user_name,u.email_id,TIMESTAMPDIFF(DAY,r.rfp_approve_date,CURDATE()) AS rfp_create_days');
		$this->db->from('rfp r');
		$this->db->join('users u','r.patient_id = u.id');
		$this->db->where('u.is_deleted','0'); // 0 Means Not Deleted User
		$this->db->where('u.is_blocked','0'); // 0 Means Not Blocked User
		$this->db->where('r.is_deleted','0'); // 0 Means Not Deleted RFP
		$this->db->where('r.is_blocked','0'); // 0 Means Not Blocked RFP
		$this->db->where('r.status','3'); // 3 Means status open
		$this->db->having('rfp_create_days','27'); // After 28 days from approve the rfp 
		$data = $this->db->get()->result_array();
	
		foreach($data as $record){

			$request_url = base_url('rfp/view_rfp_bid/'.encode($record['id']));
			$msg ="Your Request '".$record['title']."' is approved on 27 days ago and it's expire now.so please <a href='".$request_url."''>click here</a> to select any winner from list because you have last 3 days to choose winner";

			//------------ Send Mail Config-----------------
	    	$html_content=mailer('patient_notification_27_days','AccountActivation'); 
	        $username= $record['user_name'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $subject=config('site_name').' - Quote Request "'.$record['title'].'" is Last 3 days to choose winner.';    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($record['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send();
	        //------------ End Send Mail Config----------------- 
		}
		pr($data,1);
	}
	/*--------------- End For Send Message Notification to Patient (27 Days)--------------------- */


	/*--------------- For Send Message Notification to Doctor for request not confirm (Every Monday)------------------------ */
	/* 
	/* This cron job execute when doctor confirmation pending for particular request (only winner doctor)
	*/
	public function doctor_notification_no_confirm_request(){
		$this->db->select('r.*,CONCAT(u.fname," ",u.lname) as user_name,u.email_id');
		$this->db->from('rfp r');
		$this->db->join('rfp_bid rb','r.id = rb.rfp_id and status = 2');
		$this->db->join('users u','rb.doctor_id = u.id');
		$this->db->where('u.is_deleted','0'); // 0 Means Not Deleted User
		$this->db->where('u.is_blocked','0'); // 0 Means Not Blocked User
		$this->db->where('r.is_deleted','0'); // 0 Means Not Deleted RFP
		$this->db->where('r.is_blocked','0'); // 0 Means Not Blocked RFP
		$this->db->where('r.status','4'); // 4 Means status (Doctor Confirmation Pending) 
		$data = $this->db->get()->result_array();
	
		foreach($data as $record){

			$request_url = base_url('rfp/dashboard');
			$msg ="Your Request <a href=".$request_url.">'".$record['title']."'</a> is still not confirm, please confirm request.";

			//------------ Send Mail Config-----------------
	    	$html_content=mailer('doctor_notification_no_confirm_request','AccountActivation'); 
	        $username= $record['user_name'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $subject=config('site_name').' - Quote Request "'.$record['title'].'" is still not confirm';    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($record['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send();
	        //------------ End Send Mail Config----------------- 
		}
		pr($data,1);
	}
	/*--------------- End For Send Message Notification to Doctor for request not confirm (Every Monday) --------------------- */


	/*--------------- For Send Message Notification to Doctor for appointment not schedule (Every Monday) ------------------------ */
	/* 
	/* This cron job execute when doctor confirmation request and not schedule appointment (only winner doctor)
	*/
	public function doctor_notification_no_appointment(){
		$this->db->select('r.*,CONCAT(u.fname," ",u.lname) as user_name,u.email_id,rb.doctor_id,a.id as appointment_id');
		$this->db->from('rfp r');
		$this->db->join('rfp_bid rb','r.id = rb.rfp_id and rb.status = 2');
		$this->db->join('users u','rb.doctor_id = u.id');
		$this->db->join('appointments a','rb.doctor_id = a.doc_id and rb.rfp_id = a.rfp_id','left');
		$this->db->where('u.is_deleted','0'); // 0 Means Not Deleted User
		$this->db->where('u.is_blocked','0'); // 0 Means Not Blocked User
		$this->db->where('r.is_deleted','0'); // 0 Means Not Deleted RFP
		$this->db->where('r.is_blocked','0'); // 0 Means Not Blocked RFP
		$this->db->where('r.status','5'); // 5 Means status (Appointment Pending) 
		$this->db->having('appointment_id is null');
		$data = $this->db->get()->result_array();
		//pr($data,1);
		foreach($data as $record){

			$request_url = base_url('rfp/dashboard');
			$msg ="Your Appointment is not been created for Request <a href=".$request_url.">'".$record['title']."'</a>";

			//------------ Send Mail Config-----------------
	    	$html_content=mailer('doctor_notification_no_appointment','AccountActivation'); 
	        $username= $record['user_name'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $subject=config('site_name')." - Your Appointment is not been created for Request '".$record['title']."'";    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($record['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send();
	        //------------ End Send Mail Config----------------- 
		}
		pr($data,1);
	}
	/*--------------- End For Send Message Notification to Doctor for appointment not schedule (Every Monday) ---------------- */


}




/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */