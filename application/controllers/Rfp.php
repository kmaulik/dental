<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
		$this->load->model(['Treatment_category_model','Rfp_model','Messageboard_model','Notification_model']);		
	}	

	public function index(){
		
		$this->load->library('pagination');
		$where = ['is_deleted' => 0 , 'is_blocked' => 0, 'patient_id' => $this->session->userdata['client']['id']];
		$config['base_url'] = base_url().'rfp/index';
		$config['total_rows'] = $this->Rfp_model->get_rfp_front_count('rfp',$where);
		$config['per_page'] = 10;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());       
		$this->pagination->initialize($config);
		$data['rfp_list']=$this->Rfp_model->get_rfp_front_result('rfp',$where,$config['per_page'],$offset); 

		$data['subview']="front/rfp/patient/rfp_list";
		$this->load->view('front/layouts/layout_main',$data);
	}

	/* ---------------- For Create a RFP --------------- */
	public function add($step='0'){

		if($step == 0) // For First Page Of RFP
		{
			$this->session->unset_userdata('rfp_data');
			$this->form_validation->set_rules('fname', 'first name', 'required');  
			$this->form_validation->set_rules('lname', 'last name', 'required'); 
			$this->form_validation->set_rules('birth_date', 'birth date', 'required|callback_validate_birthdate',
											 ['validate_birthdate'=>'Date should be in YYYY-MM-DD Format.']);
			$this->form_validation->set_rules('title', 'RFP title', 'required'); 
			$this->form_validation->set_rules('dentition_type', 'dentition type', 'required');
			$this->form_validation->set_rules('allergies', 'allergies', 'required');
			$this->form_validation->set_rules('medication_list', 'Medication List', 'required');
			$this->form_validation->set_rules('heart_problem', 'Heart Problem', 'required');
			$this->form_validation->set_rules('chemo_radiation', 'History', 'required');
			$this->form_validation->set_rules('surgery', 'Surgery', 'required');
		   
		   
			if($this->form_validation->run() == FALSE){
			   $data['subview']="front/rfp/patient/rfp-1";
			   $this->load->view('front/layouts/layout_main',$data);
			}else{
				$this->session->set_userdata('rfp_data',$_POST); // Store Page 1 Data into Session
				redirect('rfp/add/1');
			}
		} else {
			//--------- For Check Step 1 is Success or not  ---------
			if(!isset($this->session->userdata['rfp_data'])){
				redirect('rfp/add');
			}
			// If Type other than skip this validation 
			if($this->session->userdata['rfp_data']['dentition_type'] != 'other') {
				$this->form_validation->set_rules('teeth[]', 'teeth', 'required');
			} else {
				$this->form_validation->set_rules('other_description', 'Description', 'required');
			}

			$this->form_validation->set_rules('treatment_cat_id[]', 'Treatment Category', 'required');
			$this->form_validation->set_rules('message', 'message', 'required|max_length[500]');

			if($this->form_validation->run() == FALSE){  
				$where = 'is_deleted !=  1 and is_blocked != 1';
				$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);   
				$data['subview']="front/rfp/patient/rfp-2";
				$this->load->view('front/layouts/layout_main',$data);
			} else {
				$treatment_cat_id='';
				if($this->input->post('treatment_cat_id')){
					$treatment_cat_id=implode(",",$this->input->post('treatment_cat_id')); // Convert Array into string
				} 
				$teeth='';
				if($this->input->post('teeth')){
					$teeth=implode(",",$this->input->post('teeth')); // Convert Array into string
				} 

				//-------------- For Multiple File Upload  ----------
			    
			    
			    $all_extensions = [];
			    $all_size = [];
			    $all_file_names = [];

			    $error_cnt = 0;
			    $img_path='';
			    if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL){
					$location='uploads/rfp/';					
					foreach($_FILES['img_path']['name'] as $key=>$data){

						$res=$this->filestorage->FileArrayUpload($location,'img_path',$key);
						
						$size = $_FILES['img_path']['size'][$key];
						$ext = pathinfo($data, PATHINFO_EXTENSION);

						array_push($all_extensions, $ext);
						array_push($all_size, $size);
						array_push($all_file_names, $res);

						if($res != ''){
							if($img_path == ''){
								$img_path=$res;
							}else{
								$img_path=$img_path."|".$res;
							}
						}
					} // END of foreach Loop

					$total_size = byteFormat(array_sum($all_size),'MB');

					// v! Check if size is larger than 10 MB
					if($total_size > 10){						
						foreach($all_file_names as $fname){
							$path = $_SERVER['DOCUMENT_ROOT'].'/dental/uploads/rfp/'.$fname;							
							if(file_exists($path)){
								unlink($path);
							}									
						}
						$error_cnt++;
					} // END of If condition

					// v! check if file extension is correct
					$allowed_ext = ['jpg','jpeg','png','pdf'];
					$all_extensions = array_unique($all_extensions);

					foreach($all_extensions as $ext){
						$ext = strtolower($ext);
						if(in_array($ext,$allowed_ext) == false){
							foreach($all_file_names as $fname){
								$path = $_SERVER['DOCUMENT_ROOT'].'/dental/uploads/rfp/'.$fname;
								if(file_exists($path)){
									unlink($path);
								}		
							}
							$error_cnt++;
						}
					} // END of Foreach Loop

					if($error_cnt != 0){
						$this->session->set_flashdata('error', 'Error in file uploads. Please check total file size or file extensions.');
						redirect('rfp/add/1');
					}

			    }				    
			    //-----------------------
		
				$rfp_data=array();
				$rfp_data=$this->session->userdata('rfp_data');
				$rfp_data['treatment_cat_id']=$treatment_cat_id;
				$rfp_data['teeth']=$teeth;
				$rfp_data['other_description']=$this->input->post('other_description');
				$rfp_data['message']=$this->input->post('message');
				$rfp_data['img_path']=$img_path;
				$rfp_data['patient_id'] =$this->session->userdata['client']['id'];
				$rfp_data['created_at'] = date("Y-m-d H:i:s a");
				$res=$this->Rfp_model->insert_record('rfp',$rfp_data);
				
				if($res){
					$this->session->set_flashdata('success', 'RFP Created Successfully');
				} else {
					$this->session->set_flashdata('error', 'Error Into Create RFP');
				}				
				$this->session->unset_userdata('rfp_data');
				redirect('rfp');
			}
		}    	 
	}


	/* ---------------- For Update a RFP --------------- */
	public function edit($id='',$step='0'){
		$rfp_arr=$this->Rfp_model->get_result('rfp',['id' => decode($id)],'1');
		
		if($rfp_arr)
		{
			if($step == 0) // For First Page Of RFP
			{
				$this->session->unset_userdata('rfp_data');
				$this->form_validation->set_rules('fname', 'first name', 'required');  
				$this->form_validation->set_rules('lname', 'last name', 'required'); 
				$this->form_validation->set_rules('birth_date', 'birth date', 'required|callback_validate_birthdate',
												 ['validate_birthdate'=>'Date should be in YYYY-MM-DD Format.']);
				$this->form_validation->set_rules('title', 'RFP title', 'required'); 
				$this->form_validation->set_rules('dentition_type', 'dentition type', 'required');
				$this->form_validation->set_rules('allergies', 'allergies', 'required');
				$this->form_validation->set_rules('medication_list', 'Medication List', 'required');
				$this->form_validation->set_rules('heart_problem', 'Heart Problem', 'required');
				$this->form_validation->set_rules('chemo_radiation', 'History', 'required');
				$this->form_validation->set_rules('surgery', 'Surgery', 'required');
			   
			   
				if($this->form_validation->run() == FALSE){    
				   $data['record']=$rfp_arr;          
				   $data['subview']="front/rfp/patient/edit_rfp-1";
				   $this->load->view('front/layouts/layout_main',$data);
				}else{
					$this->session->set_userdata('rfp_data',$_POST); // Store Page 1 Data into Session
					redirect('rfp/edit/'.$id.'/1');
				}
			}
			else{				
				//--------- For Check Step 1 is Success or not  ---------
				if(!isset($this->session->userdata['rfp_data'])){
					redirect('rfp/edit/'.$id);
				}
				if($this->session->userdata['rfp_data']['dentition_type'] != 'other') // If Type other than skip this validation 
				{
					$this->form_validation->set_rules('teeth[]', 'teeth', 'required');
				} 
				else{
					$this->form_validation->set_rules('other_description', 'Description', 'required');
				}
				$this->form_validation->set_rules('treatment_cat_id[]', 'Treatment Category', 'required');
				$this->form_validation->set_rules('message', 'message', 'required|max_length[500]');
				

				if($this->form_validation->run() == FALSE){  
					$data['record']=$rfp_arr;
					$where = 'is_deleted !=  1 and is_blocked != 1';
					$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);   
					$data['subview']="front/rfp/patient/edit_rfp-2";
					$this->load->view('front/layouts/layout_main',$data);
				}else{
					//pr($_FILES,1);
					$treatment_cat_id='';
					if($this->input->post('treatment_cat_id')){
						$treatment_cat_id=implode(",",$this->input->post('treatment_cat_id')); // Convert Array into string
					} 
					$teeth='';
					if($this->input->post('teeth')){
						$teeth=implode(",",$this->input->post('teeth')); // Convert Array into string
					}

					// ------------------------------------------------------------------------
					$final_str = '';										
					$rfp_data_qry = $this->Rfp_model->get_result('rfp',['id'=>decode($id)],true);					
					// ------------------------------------------------------------------------
					
				   //-------------- For Multiple File Upload  ----------
				    
				    
				    
				    $all_extensions = [];
				    $all_size = [];
				    $all_file_names = [];

				    $error_cnt = 0;
				    $total_file = explode("|",$rfp_data_qry['img_path']);
				    $img_path='';
				    if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL){
				    	//----- Check For Max 5 file upload ----
				    	if(count($total_file) >= 5){
				    		$this->session->set_flashdata('error', 'Allowed Only 5 Attachments');
							redirect('rfp/edit/'.$id.'/1');
						}
						//--------------
						$location='uploads/rfp/';					
						foreach($_FILES['img_path']['name'] as $key=>$data){

							$res=$this->filestorage->FileArrayUpload($location,'img_path',$key);
							
							$size = $_FILES['img_path']['size'][$key];
							$ext = pathinfo($data, PATHINFO_EXTENSION);

							array_push($all_extensions, $ext);
							array_push($all_size, $size);
							array_push($all_file_names, $res);

							if($res != ''){
								if($img_path == ''){
									$img_path=$res;
								}else{
									$img_path=$img_path."|".$res;
								}
							}
						} // END of foreach Loop

						$total_new_size = byteFormat(array_sum($all_size),'MB');

						//----- Fetch Old File Size ----
						$total_old_size=0;
						if($rfp_data_qry['img_path'] != ''){
							$old_img=explode("|",$rfp_data_qry['img_path']);
							foreach($old_img as $img){
								$file_name = FCPATH.'uploads/rfp/'.$img;
								if(file_exists($file_name)) {
								    $total_old_size= $total_old_size + filesize($file_name);	
								}
							}
							$total_old_size= byteFormat($total_old_size,'MB');
						}
						
						$total_size=$total_old_size+$total_new_size;
						//----- Fetch Old File Size ----

						


						// v! Check if size is larger than 10 MB
						if($total_size > 10){						
							foreach($all_file_names as $fname){
								$path = $_SERVER['DOCUMENT_ROOT'].'/dental/uploads/rfp/'.$fname;
								if(file_exists($path)){
									unlink($path);
								}															
							}
							$error_cnt++;
						} // END of If condition

						
						// v! check if file extension is correct
						$allowed_ext = ['jpg','jpeg','png','pdf'];
						$all_extensions = array_unique($all_extensions);

						foreach($all_extensions as $ext){
							$ext = strtolower($ext);
							if(in_array($ext,$allowed_ext) == false){
								foreach($all_file_names as $fname){
									$path = $_SERVER['DOCUMENT_ROOT'].'/dental/uploads/rfp/'.$fname;
									if(file_exists($path)){
										unlink($path);
									}		
								}
								$error_cnt++;
							}
						} // END of Foreach Loop
						
						if($error_cnt != 0){
							$this->session->set_flashdata('error', 'Error in file uploads. Please check total file size or file extensions.');
							redirect('rfp/edit/'.$id.'/1');
						}

				    }				    
				   
				    //-----------------------
				    $rfp_data=$this->session->userdata('rfp_data');

					$rfp_data['img_path']=$img_path;

					// Check new file select if not then assign old value
					if($rfp_data['img_path'] == '') {
						$rfp_data['img_path'] = $rfp_data_qry['img_path'];
					}else{
						
						$old_arr = [];
						$new_arr = [];

						$new_str = $rfp_data['img_path'];
						$old_str = $rfp_data_qry['img_path'];

						if($old_str != ''){ $old_arr = explode('|',$old_str); }
						if($new_str != ''){ $new_arr = explode('|',$new_str); }

						if(!empty($new_arr) || !empty($old_arr)){
							$final_arr = array_merge($new_arr,$old_arr);
							$final_str = implode('|',$final_arr);
						}

						$rfp_data['img_path'] = $final_str;						 
					}									

					$rfp_data['treatment_cat_id']=$treatment_cat_id;
					$rfp_data['teeth']=$teeth;
					$rfp_data['other_description']=$this->input->post('other_description');
					$rfp_data['message']=$this->input->post('message');


					$res=$this->Rfp_model->update_record('rfp',['id' => decode($id)],$rfp_data);

					if($res){
						$this->session->set_flashdata('success', 'RFP Updated Successfully');
					}
					else{
						$this->session->set_flashdata('error', 'Error Into Update RFP');
					}
					$this->session->unset_userdata('rfp_data');
					redirect('rfp');
				}
			}  
		}else{
			show_404();
		}   
	}

	/**
	 * Function is used to perform action (Delete)
	*/
	public function action($action, $record_id) {

		$where = 'id = ' . decode($this->db->escape($record_id));
		$check_data = $this->Rfp_model->get_result('rfp', $where);
		if ($check_data) {
			if ($action == 'delete') {
				$update_array = array(
					'is_deleted' => 1
					);
				$this->session->set_flashdata('success', 'RFP successfully deleted!');
			} 
			$this->Rfp_model->update_record('rfp', $where, $update_array);
		} else {
			$this->session->set_flashdata('error', 'Invalid request. Please try again!');
		}
		redirect('rfp');
	}

	/* --------------- For Delete RFP Attachment ------------- */
	public function delete_img_rfp(){
		$img_name = $this->input->post('img_name');
		$rfp_id = $this->input->post('rfp_id');

		$res_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_id],'1');	
		if(!empty($res_data)){
			$rfp_img = $res_data['img_path'];
			if($rfp_img != ''){
				$all_img_arr =explode('|',$rfp_img);
			}
		}
		$final_arr='';
		if(!empty($all_img_arr)){
			$location='uploads/rfp/';
			// For Delete the file from folder 
			$this->filestorage->DeleteImage($location,$img_name);
			// For Make a new array with old and new image 
			$final_arr = array_diff($all_img_arr, [$img_name]);
		}
		$final_str='';
		if(!empty($final_arr)){
			$final_str = implode('|',$final_arr);
		}
		$this->Rfp_model->update_record('rfp',['id'=>$rfp_id],['img_path'=>$final_str]);
		echo json_encode(['success'=>true]);
	}
	
	/* 
	*	View RFP Bid (Proposal) particular rfp wise (Patient Side)
	*/
	public function view_rfp_bid($rfp_id){

		$data['rfp_bid_list']=$this->Rfp_model->get_rfp_bid_data(decode($rfp_id));	
		//pr($data['rfp_bid_list'],1);
		$data['subview']="front/rfp/patient/rfp_bid";
		$this->load->view('front/layouts/layout_main',$data);
	}

	/*------------------ For Send Message To Bidder ------------ */
    public function send_message(){
    	$data=array(
    		'rfp_id' => $this->input->post('rfp_id'),
    		'from_id' => $this->session->userdata('client')['id'],
    		'to_id' => $this->input->post('to_id'),
    		'message' => $this->input->post('message'),
    		'created_at'	=> date("Y-m-d H:i:s")
    	);
    	$this->Messageboard_model->insert_record('messages',$data);
    	// ------------------------------------------------------------------------
    	// v! insert data notifications table
		$noti_data = [
						'from_id'=>$this->session->userdata('client')['id'],
						'to_id'=>$this->input->post('to_id'),
						'rfp_id' => $this->input->post('rfp_id'),
						'noti_type'=>'message',
						'noti_url'=>'messageboard'								
					];
												
		$this->Notification_model->insert_notification($noti_data);
    	// ------------------------------------------------------------------------
    	$where=['id' => $this->input->post('rfp_bid_id')];
    	$up_data=['is_chat_started' => '1'];
	    $res=$this->Rfp_model->update_record('rfp_bid',$where,$up_data);
	    if($res)
	    {
	    	$where=['id' => $this->input->post('to_id')];
	    	$user_data=$this->Rfp_model->get_result('users',$where,'1');

	    	//------------ Send Mail Config-----------------
	    	$html_content=mailer('contact_inquiry','AccountActivation'); 
	        $username= $user_data['fname']." ".$user_data['lname'];
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$this->input->post('message'),$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $from_name =$this->session->userdata('client')['fname']." ".$this->session->userdata('client')['lname'];
	        $subject=config('site_name').' - Message For '.$this->input->post('rfp_title').' RFP From '.$from_name;    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($user_data['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send(); 
	        //------------ End Send Mail Config-----------------        
	    	$this->session->set_flashdata('success', 'Message Send Successfully');
	    }
	    else
	    {
	    	$this->session->set_flashdata('error', 'Error Into Send Message');
	    }
	    redirect('rfp/view_rfp_bid/'.encode($this->input->post('rfp_id')));
    }

	/* 
	*	Doctor Search RFP 
	*/ 
	public function search_rfp(){    
		
		//------- Filter RFP ----
		$search_data= $this->input->get('search') ? $this->input->get('search') :'';
		$date_data= $this->input->get('date') ? $this->input->get('date') :'';
		$sort_data= $this->input->get('sort') ? $this->input->get('sort') :'desc';
		//------- /Filter RFP ----
		$this->load->library('pagination');
		$config['base_url'] = base_url().'rfp/search_rfp?search='.$search_data.'&date='.$date_data.'&sort='.$sort_data;
		$config['total_rows'] = $this->Rfp_model->search_rfp_count($search_data,$date_data);
		$config['per_page'] = 10;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());       
		$this->pagination->initialize($config);
		$data['rfp_data']=$this->Rfp_model->search_rfp_result($config['per_page'],$offset,$search_data,$date_data,$sort_data);
		$data['subview']="front/rfp/doctor/search_rfp";
		$this->load->view('front/layouts/layout_main',$data);
	}

	/*
     *  view RFP data 
    */
    public function view_rfp($rfp_id){
        $data['record']=$this->Rfp_model->get_result('rfp',['id' => decode($rfp_id)],'1');
        if($this->session->userdata('client')['role_id'] == '4') // Check For Doctor Role (4)
        {
        	 $where=['rfp_id' => decode($rfp_id),'doctor_id' => $this->session->userdata('client')['id'],'is_deleted' => '0'];
        	 $data['rfp_bid']=$this->Rfp_model->get_result('rfp_bid',$where,1);
        	 $data['subview']="front/rfp/doctor/view_rfp_doctor";
        }
       elseif($this->session->userdata('client')['role_id'] == '5') // Check For Patient Role (5)
       {
       		$data['subview']="front/rfp/patient/view_rfp_patient";
       }
		$this->load->view('front/layouts/layout_main',$data);
    }

    /*
    *	Add to Favorite RFP
    */
    public function add_favorite_rfp(){
    	$rfp_favorite_data=[
    		'rfp_id' => decode($this->input->post('rfp_id')),
    		'doctor_id' => $this->session->userdata('client')['id'],
    		'created_at' => date("Y-m-d H:i:s")	
    	];
    	$res=$this->Rfp_model->insert_record('rfp_favorite',$rfp_favorite_data);
    	if($res){
    		return true;
    	}else{
    		return false;
    	}
    }

    /*
    *	Remove From Favorite RFP
    */
    public function remove_favorite_rfp(){
    	$res=$this->Rfp_model->delete_record('rfp_favorite',['rfp_id' => decode($this->input->post('rfp_id'))]);
    	if($res){
    		return true;
    	}else{
    		return false;
    	}
    }

    /*
    * Manage Bid 
    */
    public function manage_bid(){
    	if($this->input->post('rfp_bid_id') == '') // null means place a new bid
    	{
    		$data=array(
	    		'rfp_id' => $this->input->post('rfp_id'),
	    		'doctor_id' => $this->session->userdata['client']['id'],
	    		'amount' => $this->input->post('amount'),
	    		'description' => $this->input->post('description'),
	    		'created_at' => date("Y-m-d H:i:s"),
	    	);

	    	$res=$this->Rfp_model->insert_record('rfp_bid',$data);

	    	// ------------------------------------------------------------------------
	    	// v! insert data notifications table
	    	$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$this->input->post('rfp_id')],true);
			$noti_data = [
							'from_id'=>$this->session->userdata('client')['id'],
							'to_id'=>$rfp_data['patient_id'],
							'rfp_id' => $this->input->post('rfp_id'),
							'noti_type'=>'doc_bid',
							'noti_url'=>'bid'
						];
													
			$this->Notification_model->insert_notification($noti_data);
	    	// ------------------------------------------------------------------------

	    	if($res){
	    		$this->session->set_flashdata('success', 'Bid Placed Successfully!');
	    	}
	    	else{
	    		$this->session->set_flashdata('error', 'Error Into Place Bid, Please try again!');
	    	}
    	}else{
    		$data=array(
	    		'rfp_id' => $this->input->post('rfp_id'),
	    		'doctor_id' => $this->session->userdata['client']['id'],
	    		'amount' => $this->input->post('amount'),
	    		'description' => $this->input->post('description'),
	    	);
    		$where=['id' => $this->input->post('rfp_bid_id')];
	    	$res=$this->Rfp_model->update_record('rfp_bid',$where,$data);
	    	if($res){
	    		$this->session->set_flashdata('success', 'Bid Updated Successfully!');
	    	}
	    	else{
	    		$this->session->set_flashdata('error', 'Error Into Update Bid, Please try again!');
	    	}
    	}	
	    	
    	redirect('rfp/view_rfp/'.encode($this->input->post('rfp_id')));
    }

    public function redirect_profile(){
    	$this->session->set_userdata('redirect_profile','YES');
    	redirect('dashboard/edit_profile');
    }

    // v! Custom Form validation
    public function validate_birthdate($str){
        $field_value = $str; //this is redundant, but it's to show you how
        if($field_value != ''){
            $arr_date = explode('-',$field_value);
            if(count($arr_date) == 3 && checkdate($arr_date[1], $arr_date[2], $arr_date[0])){                
                return TRUE;
            }else{
                return FALSE;
            }
        }        
    }

}
