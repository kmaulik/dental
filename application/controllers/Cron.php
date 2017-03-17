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

	public function check_status(){

		$res_data = $this->Rfp_model->get_result('billing_schedule',['status'=>'0','transaction_id is not null'=>null]);

		if(!empty($res_data)){
			$return_arr = [];

			foreach($res_data as $res){

				$return_arr = GetTransactionDetails($res['transaction_id']);
				$return_json = json_encode($return_arr);
				$ack_transaction = strtoupper($return_arr['ACK']);				

				if($ack_transaction == "SUCCESS" || $ack_transaction == "SUCCESSWITHWARNING") {
					if($return_arr['PAYMENTSTATUS'] == 'Completed'){
						
						$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$res['rfp_id']],true);							

						if($rfp_data['status'] == '5'){
							$this->Rfp_model->update_record('rfp',['id'=>$res['rfp_id']],['status'=>'6']); // status : 6 - change waiting for doctor approval to close
						
						}else{

							// ------------------------------------------------------------------------
					    	$noti_data = [
					    					'from_id'=>$rfp_data['patient_id'],
					    					'to_id'=>$res['id'],
					    					'rfp_id'=>$res['rfp_id'],
					    					'noti_type'=>'confirm_payment',
					    					'noti_msg'=>'Congratulation..!! You\'re contract has been made with patient.',
					    					'noti_url'=>'dashboard'
					    				];
					    	$this->Notification_model->insert_rfp_notification($noti_data);
					    	// ------------------------------------------------------------------------

							$this->Rfp_model->update_record('rfp',['id'=>$res['rfp_id']],['status'=>'5']); // status : 5 - chnage pending  to waiting for doctor approval
						}							

						$this->Rfp_model->update_record('billing_schedule',['id'=>$res['id']],['status'=>'1']);

						$this->Rfp_model->update_record('payment_transaction',
														['paypal_token'=>$res['transaction_id']],
														['status'=>'1']);

					}
				} // END of IF condition				
			}
		}
	}

	public function check_agreement_status(){

		// get_detail_billing_agreement
		$res_data = $this->Rfp_model->get_result('billing_agreement',['status'=>'1']);		
		pr($res_data,1);

		if(!empty($res_data)){
			foreach($res_data as $res){
				
				$billing_detail = get_detail_billing_agreement($res['billing_id']);				
				$billing_detail_json = json_encode($billing_detail);
				$ack_billing = strtoupper($billing_detail['ACK']);				

				if($ack_billing == "SUCCESS" || $ack_billing == "SUCCESSWITHWARNING") {

					$billing_status = $billing_detail['BILLINGAGREEMENTSTATUS'];

					if($billing_status != 'Active'){
						$billing_detail_json;
						$this->Rfp_model->update_record('billing_agreement',['id'=>$res['id']],
																			['status'=>'0']);
					}					
				}

			} // End of Foreach Loop
		}
	}

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
		        							'created_at'=>date('Y-m-d H:i:s')
		        						);
		        			$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
		        			// ------------------------------------------------------------------------
						}
					}

				}else{
					// IF price is ZERO means there is only one due payment enter
					$this->Rfp_model->update_record('rfp',['id'=>$a_data['rfp_id']],['status'=>'6']); // Close RFP after 45 days
					$this->Rfp_model->update_record('billing_schedule',['rfp_id'=>$a_data['rfp_id'],'price'=>'0'],['status'=>'1']);
				}

			} // ForEACH ENs here
		}
	}

	/*----------------- For Send message according to search filter ----------------- */
	public function send_mail_alert_doctor(){

		//--------------------- Fetch Doctor User For rfp notofication --------
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

		        if($category_data != ''){
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
					$msg = "New RFP List <br/><br/>";
					$msg .="<table border='1' cellspacing='1' cellpadding='1' style='width:100%;'>
							<thead>
								<tr style='font-size:12px;font-weight:100;'>
									<th>RFP #</th>
									<th>RFP Title</th>
									<th>Patient Age</th>
									<th>Distance (Miles.)</th>
									<th>RFP Valid Days</th>
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
					//------------------ End Html Message format ------------
					//------------ Send Mail Config-----------------
			    	$html_content=mailer('contact_inquiry','AccountActivation'); 
			        $username= $notify_user['doctor_name'];
			        $html_content = str_replace("@USERNAME@",$username,$html_content);
			        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
			       
			        $email_config = mail_config();
			        $this->email->initialize($email_config);
			        $subject=config('site_name').' - New RFP Creation Notification';    
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
		pr($rfp_notify_data);
		die;
	}
	/* ------------------ End Send message according to search filter ---------------- */

}




/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */