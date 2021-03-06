<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		if(!isset($this->session->userdata['client'])){
        	$this->session->set_userdata('redirect_url',  current_url());
        	redirect('login');
        } else {
        	//-------------------- For check role wise access function ------
        	if($this->session->userdata['client']['role_id'] == 4)
	        {
	        	 $protected_methods = array('add', 'edit', 'action','view_rfp_bid','make_payment','paypal_payment','complete_transaction','choose_winner_doctor','cancel_winner_doctor','extend_rfp_validity');
	        }
	        else if($this->session->userdata['client']['role_id'] == 5)
	        {
	        	 $protected_methods = array('search_rfp', 'manage_bid', 'make_doctor_payment','save_filter_data','update_filter_data','view_filter_data');
	        	 
	        }
	        if(in_array($this->router->method, $protected_methods)){ 
    	 		redirect('rfp');
    	 	}		
	        //-------------------- For check role wise access function ------	
        }
		$this->load->helper(['paypal_helper']);	
		$this->load->library('unirest');
		$this->load->model(['Treatment_category_model','Rfp_model','Messageboard_model','Notification_model','Promotional_code_model']);		
	}

	public function index(){
		
		//-------------- If Role Id (4 Means doctor then redirect to search rfp)
		if($this->session->userdata['client']['role_id'] == 4) {
			redirect('rfp/search_rfp');
		}
		else if($this->session->userdata['client']['role_id'] == 5) {
			redirect('dashboard'); // For Patient Dashboard
		}
		//------------------------------------------------------------------

		// $this->load->library('pagination');
		// $where = ['is_deleted' => 0 , 'is_blocked' => 0, 'patient_id' => $this->session->userdata['client']['id']];
		// $config['base_url'] = base_url().'rfp/index';
		// $config['total_rows'] = $this->Rfp_model->get_rfp_front_count('rfp',$where);
		// $config['per_page'] = 10;
		// $offset = $this->input->get('per_page');
		// $config = array_merge($config,pagination_front_config());       
		// $this->pagination->initialize($config);
		// $data['rfp_list']=$this->Rfp_model->get_rfp_front_result('rfp',$where,$config['per_page'],$offset); 

		//$data['subview']="front/rfp/patient/rfp_list";
		//$this->load->view('front/layouts/layout_main',$data);
	}

	/* ---------------- For Create a RFP --------------- */
	public function add($step='0'){

		if($step == 0) // For First Page Of RFP
		{
			//$this->session->unset_userdata('rfp_data');
			$this->form_validation->set_rules('fname', 'first name', 'required');  
			$this->form_validation->set_rules('lname', 'last name', 'required'); 
			$this->form_validation->set_rules('birth_date', 'birth date', 'required|callback_validate_birthdate',
											 ['validate_birthdate'=>'Date should be in YYYY-MM-DD Format.']);
			$this->form_validation->set_rules('zipcode', 'zipcode', 'required|callback_validate_zipcode',
											 ['validate_zipcode'=>'Please, verify your ZIP Code.']);
			$this->form_validation->set_rules('title', 'Request Title', 'required'); 
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

				//-------- Fetch Longitude and Latitude based on zipcode ----
				$longitude='';
				$latitude='';
				$location_data = $this->validate_zipcode($this->input->post('zipcode'),1);
				if($location_data['status'] == 'OK'){
					$longitude = $location_data['results'][0]['geometry']['location']['lng'];
					$latitude= $location_data['results'][0]['geometry']['location']['lat'];
				}
				//--------------------------
				$a = explode('-',$this->input->post('birth_date'));
            	$birth_date = $a[2].'-'.$a[0].'-'.$a[1];

				$rfp_step_1= array(
						'fname' 			=> $this->input->post('fname'),
						'lname' 			=> $this->input->post('lname'),
						'birth_date'		=> $birth_date,
						'zipcode'			=> $this->input->post('zipcode'),
						'longitude'			=> $longitude,
						'latitude'			=> $latitude,
						'title' 			=> $this->input->post('title'),
						'dentition_type' 	=> $this->input->post('dentition_type'),
						'distance_travel'	=> $this->input->post('distance_travel'),
						'allergies' 		=> $this->input->post('allergies'),
						'medication_list' 	=> $this->input->post('medication_list'),
						'heart_problem' 	=> $this->input->post('heart_problem'),
						'chemo_radiation' 	=> $this->input->post('chemo_radiation'),
						'surgery' 			=> $this->input->post('surgery'),
						'patient_id' 		=> $this->session->userdata['client']['id'],
						'created_at' 		=> date("Y-m-d H:i:s a"),
					);
					$res=$this->Rfp_model->insert_record('rfp',$rfp_step_1);
					if($res){
						$rfp_data=array(
							'rfp_last_id' => $res,
							'dentition_type' => $this->input->post('dentition_type'),
							);
						$this->session->set_userdata('rfp_data',$rfp_data); // Store Last Insert Id & Dentition Type into Session
						$this->session->set_flashdata('success', 'Step 1 of 3 completed - You can access the Draft Version anytime from the Dashboard');
						if($this->input->post('step-btn') != ''){
							redirect('rfp/add/'.$this->input->post('step-btn'));
						}else{
							redirect('rfp/add/1');
						}
						
					}else{
						$this->session->set_flashdata('error', 'Error Into Create Basic Detail & Medical History');
						redirect('rfp/add');
					}
					
			}
		} 
		elseif($step == 1) 
		{
			//--------- For Check Step 1 is Success or not  ---------
			if(!isset($this->session->userdata['rfp_data'])){
				redirect('rfp/add');
			}

			//----- For Check Treatment Category Validation ------
			if($this->input->post('teeth') != ''){
				$this->form_validation->set_rules('teeth[]', 'teeth', 'required');
				foreach($this->input->post('teeth') as $key=>$val){
					$treat_cat_id = $this->input->post('treatment_cat_id_'.$val);
					$treat_cat_text = $this->input->post('treat_cat_text_'.$val);
					if($treat_cat_id == '' && $treat_cat_text == '')
					{
						$this->form_validation->set_rules('treatment_cat_id_'.$val.'[]', 'teeth category', 'required');
					}
				}
			}
			else {
				$this->form_validation->set_rules('other_description', 'Description', 'required',['required' => 'Please, select a minimum of one teeth or provide a treatment descritption!']);
			}
	
			if($this->form_validation->run() == FALSE)
			{  
				$where = 'is_deleted !=  1 and is_blocked != 1';
				$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);
				$data['subview']="front/rfp/patient/rfp-2";
				$this->load->view('front/layouts/layout_main',$data);
			} 
			else 
			{
				/*------------ For teeth and Treatment category data -------- */
				$teeth=[];
				$teeth_cat_array=[];
				$teeth_data='';
				if($this->input->post('teeth')){
					foreach($this->input->post('teeth') as $key=>$val){
						foreach($this->input->post('treatment_cat_id_'.$val) as $k=>$v){
							$teeth[$val]['cat_id'][$k]=$v;
							array_push($teeth_cat_array,$v);
						}
						$teeth[$val]['cat_text']=$this->input->post('treat_cat_text_'.$val);	
					}
					$teeth_data=json_encode($teeth);
					$teeth_cat_array=array_unique($teeth_cat_array);
				} 
				/*------------ For teeth and Treatment category data -------- */ 
		
				$rfp_step_2=array(
					'teeth_data' 				=> $teeth_data,
					'teeth_category'			=> implode(",",$teeth_cat_array),
					'other_description' 		=> $this->input->post('other_description'),
					'treatment_plan_total' 		=> $this->input->post('treatment_plan_total'),
					
					);
				$condition=['id' => $this->session->userdata['rfp_data']['rfp_last_id']];
				$res=$this->Rfp_model->update_record('rfp',$condition,$rfp_step_2);
				
				if($res){
					$this->session->set_flashdata('success', 'Step 2 of 3  completed - Treatment Plan Information Updated Successfully');
					if($this->input->post('step-btn') != ''){
						if($this->input->post('step-btn') == 0){
							redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']));
						}else{
							redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']).'/'.$this->input->post('step-btn'));
						}
					}
					elseif($this->input->post('prev')){
						redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id'])); // Go to 1st step (Basic Details)
					}else{
						redirect('rfp/add/2');
					}	
				} else {
					$this->session->set_flashdata('error', 'Error Into Create Treatment Plan');
					redirect('rfp/add/1');
				}	
			}
		}  
		elseif($step == 2) {
			//--------- For Check Step 1 is Success or not  ---------
			if(!isset($this->session->userdata['rfp_data'])){
				redirect('rfp/add');
			}	

			$this->form_validation->set_rules('message', 'message', 'max_length[500]');

			if($this->form_validation->run() == FALSE)
			{  
				$data['subview']="front/rfp/patient/rfp-3";
				$this->load->view('front/layouts/layout_main',$data);
			} 
			else{

				if($this->input->post('prev') || $this->input->post('next') || $this->input->post('step-btn') || $this->input->post('step-btn') == 0)
				{
					//-------------- For Multiple File Upload  ----------
				    $all_extensions = [];
				    $all_size = [];
				    $all_file_names = [];

				    $error_cnt = 0;
				    $img_path='';

				    if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL)
				    {
						$location='uploads/rfp/';					
						foreach($_FILES['img_path']['name'] as $key=>$data){
							if($data){
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
							redirect('rfp/add/2');
						}

			    	}				    
				    //-----------------------
					$rfp_step_3=array(
							'insurance_provider' 		=> $this->input->post('insurance_provider'),
							'message' 					=> $this->input->post('message'),
							'img_path' 					=> $img_path,
							);
					$condition=['id' => $this->session->userdata['rfp_data']['rfp_last_id']];
					$res=$this->Rfp_model->update_record('rfp',$condition,$rfp_step_3);
					if($res){
						$this->session->set_flashdata('success', 'Step 3 of 3  completed - Additional Information Updated Successfully - Kindly Review your Information and submit your Treatment Plan');
						if($this->input->post('step-btn') != ''){
							if($this->input->post('step-btn') == 0){
								redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']));
							}else{
								redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']).'/'.$this->input->post('step-btn'));
							}
						}
						elseif($this->input->post('prev')){
							redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']).'/1'); // Go to 2nd step (Treatment Plan Details)
						}else{
							redirect('rfp/add/3'); // Goto 4th step (Summary Page - Final)
						}	
					} else {
						redirect('rfp/add/2');
						$this->session->set_flashdata('error', 'Error Into Create Additional Information');
					}	
				}else{
					$data['subview']="front/rfp/patient/rfp-3";
					$this->load->view('front/layouts/layout_main',$data);
				}	
			}  
		}	
		elseif($step == 3){

			if($this->input->post('step-btn') != ''){
				if($this->input->post('step-btn') == 0){
					redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']));
				}else{
					redirect('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']).'/'.$this->input->post('step-btn'));
				}
			}
			elseif($this->input->post('submit')){
				
				$condition=['id' => $this->session->userdata['rfp_data']['rfp_last_id']];
				$res=$this->Rfp_model->update_record('rfp',$condition,['status'	=> 1]);
				if($res){
					$this->session->set_flashdata('success', 'Request Created Successfully');
					//$rfp_id = $this->session->userdata['rfp_data']['rfp_last_id'];
					$this->session->unset_userdata('rfp_data');
					//redirect('rfp');
				} else {
					$this->session->set_flashdata('error', 'Error Into Confirm Request');
					//redirect('rfp/add/3');
				}	
				redirect('rfp/add/3'); 
			}
			else{

				//$data['confirm_rfp']=1;
				$data['record']=$this->Rfp_model->get_result('rfp',['id' => $this->session->userdata['rfp_data']['rfp_last_id'],'patient_id' => $this->session->userdata['client']['id'] ],'1');
				$data['subview']="front/rfp/patient/view_rfp_patient";
				$this->load->view('front/layouts/layout_main',$data);
			}	
		}	 
	}


	/* ---------------- For Update a RFP --------------- */
	public function edit($id='',$step='0'){
		$rfp_arr=$this->Rfp_model->get_result('rfp',['id' => decode($id),'status <=' => '2'],'1');
		if($rfp_arr)
		{
			if($step == 0) // For First Page Of RFP
			{
				//$this->session->unset_userdata('rfp_data');
				$this->form_validation->set_rules('fname', 'first name', 'required');  
				$this->form_validation->set_rules('lname', 'last name', 'required'); 
				$this->form_validation->set_rules('birth_date', 'birth date', 'required|callback_validate_birthdate',
												 ['validate_birthdate'=>'Date should be in YYYY-MM-DD Format.']);
				$this->form_validation->set_rules('zipcode', 'zipcode', 'required|callback_validate_zipcode',
											 ['validate_zipcode'=>'Please, verify your ZIP Code.']);
				$this->form_validation->set_rules('title', 'Request Title', 'required'); 
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

					//-------- Fetch Longitude and Latitude based on zipcode ----
					$longitude='';
					$latitude='';
					$location_data = $this->validate_zipcode($this->input->post('zipcode'),1);
					if($location_data['status'] == 'OK'){
						$longitude = $location_data['results'][0]['geometry']['location']['lng'];
						$latitude= $location_data['results'][0]['geometry']['location']['lat'];
					}
					//--------------------------
					$a = explode('-',$this->input->post('birth_date'));
            		$birth_date = $a[2].'-'.$a[0].'-'.$a[1];

					$rfp_step_1= array(
						'fname' 			=> $this->input->post('fname'),
						'lname' 			=> $this->input->post('lname'),
						'birth_date'		=> $birth_date,
						'zipcode'			=> $this->input->post('zipcode'),
						'longitude'			=> $longitude,
						'latitude'			=> $latitude,
						'title' 			=> $this->input->post('title'),
						'dentition_type' 	=> $this->input->post('dentition_type'),
						'distance_travel'	=> $this->input->post('distance_travel'),
						'allergies' 		=> $this->input->post('allergies'),
						'medication_list' 	=> $this->input->post('medication_list'),
						'heart_problem' 	=> $this->input->post('heart_problem'),
						'chemo_radiation' 	=> $this->input->post('chemo_radiation'),
						'surgery' 			=> $this->input->post('surgery'),
					);
					$res=$this->Rfp_model->update_record('rfp',['id' => decode($id)],$rfp_step_1);

					if($res){
						$this->session->set_flashdata('success', 'Step 1 of 3 completed - You can access the Draft Version anytime from the Dashboard');				
						//-----------------
						if($this->input->post('step-btn') != ''){
							if($this->input->post('step-btn') == 0){
								redirect('rfp/edit/'.$id);
							}else{
								redirect('rfp/edit/'.$id.'/'.$this->input->post('step-btn'));
							}
						}else{
							redirect('rfp/edit/'.$id.'/1'); // Go to 2nd step (Treatment Plan Details)
						}	
						
					}else{
						$this->session->set_flashdata('error', 'Error Into Update Basic Detail & Medical History');
						redirect('rfp/edit/'.$id);					
					}
				}
			} elseif($step == 1){				
				//--------- For Check Step 1 is Success or not  ---------
					//----- For Check Treatment Category Validation ------
					if($this->input->post('teeth') != ''){
						$this->form_validation->set_rules('teeth[]', 'teeth', 'required');
						foreach($this->input->post('teeth') as $key=>$val){
							$treat_cat_id = $this->input->post('treatment_cat_id_'.$val);
							$treat_cat_text = $this->input->post('treat_cat_text_'.$val);
							if($treat_cat_id == '' && $treat_cat_text == '')
							{
								$this->form_validation->set_rules('treatment_cat_id_'.$val.'[]', 'teeth category', 'required');
							}
						}
					}
					else{
					
						$this->form_validation->set_rules('other_description', 'Description', 'required',['required' => 'Please, select a minimum of one teeth or provide a treatment descritption!']);
				}
							

				if($this->form_validation->run() == FALSE){  
					$data['record']=$rfp_arr;
					$where = 'is_deleted !=  1 and is_blocked != 1';
					$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);   
					$data['subview']="front/rfp/patient/edit_rfp-2";
					$this->load->view('front/layouts/layout_main',$data);
				}else{
					//pr($_FILES,1);
					//pr($_POST,1);
					/*------------ For teeth and Treatment category data -------- */ 
					$teeth=[];
					$teeth_cat_array=[];
					$teeth_data='';
					// check if teeth data is set or not 
					if($this->input->post('teeth')){
						foreach($this->input->post('teeth') as $key=>$val){
							foreach($this->input->post('treatment_cat_id_'.$val) as $k=>$v){
								$teeth[$val]['cat_id'][$k]=$v;
								array_push($teeth_cat_array,$v);
							}
							$teeth[$val]['cat_text']=$this->input->post('treat_cat_text_'.$val);	
						}
						$teeth_data=json_encode($teeth);
						$teeth_cat_array=array_unique($teeth_cat_array);
					} 
					// else{
					// 	$teeth_cat_array=$this->input->post('other_treatment_cat_id');
					// }
					/*------------ For teeth and Treatment category data -------- */ 
								
					$rfp_data['teeth_data']=$teeth_data;
					$rfp_data['teeth_category'] = null;
					if(!empty($teeth_cat_array)){
						$rfp_data['teeth_category']	= implode(",",$teeth_cat_array);
					}

					$rfp_data['other_description'] = $this->input->post('other_description');
					$rfp_data['treatment_plan_total'] = $this->input->post('treatment_plan_total');
				
					$res=$this->Rfp_model->update_record('rfp',['id' => decode($id)],$rfp_data);

					if($res){
						// IF Success
						$this->session->set_flashdata('success', 'Step 2 of 3  completed - Treatment Plan Information Updated Successfully');						
						// Check for event prev or next
						if($this->input->post('step-btn') != ''){
							if($this->input->post('step-btn') == 0){
								redirect('rfp/edit/'.$id);
							}else{
								redirect('rfp/edit/'.$id.'/'.$this->input->post('step-btn'));
							}
						}
						elseif($this->input->post('prev')){
							redirect('rfp/edit/'.$id); // Go to 1st step (Basic Details)
						}else{
							if($rfp_arr['insurance_provider'] != '' && $rfp_arr['insurance_provider'] != ''){
								redirect('rfp/edit/'.$id.'/3'); // Go to 4th step (summary page - final)
							}else{
								redirect('rfp/edit/'.$id.'/2'); // Go to 3rd step(Financial info page)
							}
						}
					} else{
						// If Error
						$this->session->set_flashdata('error', 'Error Into Update Treatment Plan');
						redirect('rfp/edit/'.$id.'/1');
					}
				}
			}  
			elseif($step == 2) {

				$this->form_validation->set_rules('message', 'message', 'max_length[500]');

				if($this->form_validation->run() == FALSE)
				{  
					$data['record']=$rfp_arr;
					$data['subview']="front/rfp/patient/edit_rfp-3";
					$this->load->view('front/layouts/layout_main',$data);
				}else{ 
					if($this->input->post('prev') || $this->input->post('next') || $this->input->post('step-btn') || $this->input->post('step-btn') == 0){

						$final_str = '';										
						$rfp_data_qry = $this->Rfp_model->get_result('rfp',['id'=>decode($id)],true);	
						//-------------- For Multiple File Upload  ----------
					    
					    $all_extensions = [];
					    $all_size = [];
					    $all_file_names = [];

					    $error_cnt = 0;
					    $total_file = explode("|",$rfp_data_qry['img_path']);
					    $img_path='';

					    if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL){
					    	//----- Check For Max 10 file upload ----
					    	if(count($total_file) >= 10){
					    		$this->session->set_flashdata('error', 'Allowed Only 10 Attachments');
								redirect('rfp/edit/'.$id.'/1');
							}
							//--------------
							$location='uploads/rfp/';					
							foreach($_FILES['img_path']['name'] as $key=>$data){

								if($data){		
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
								redirect('rfp/edit/'.$id.'/2');
							}

					    }				    
					   
					    //-----------------------
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
						//-------------- End For Multiple File Upload  ----------


						$rfp_step_3=array(
							'insurance_provider' 	=> 	$this->input->post('insurance_provider'),
							'img_path'				=>	$rfp_data['img_path'],
							'message'				=> 	$this->input->post('message'),
							);
						$condition=['id' => decode($id)];
						$res=$this->Rfp_model->update_record('rfp',$condition,$rfp_step_3);
						if($res){
							$this->session->set_flashdata('success', 'Step 3 of 3  completed - Additional Information Updated Successfully - Kindly Review your Information and submit your Treatment Plan');
							if($this->input->post('step-btn') != ''){
								if($this->input->post('step-btn') == 0){
									redirect('rfp/edit/'.$id);
								}else{
									redirect('rfp/edit/'.$id.'/'.$this->input->post('step-btn'));
								}
							}
							elseif($this->input->post('prev')){
								redirect('rfp/edit/'.$id.'/1'); // Go to 2nd step (Treatment Plan Details)
							}else{
								redirect('rfp/edit/'.$id.'/3'); // Go to 4th step (summary page - final)
							}
						} else {
							$this->session->set_flashdata('error', 'Error Into Update Additional Information');
							redirect('rfp/edit/'.$id.'/2');
						}	

					}
					else{
						$data['record']=$rfp_arr;
						$data['subview']="front/rfp/patient/edit_rfp-3";
						$this->load->view('front/layouts/layout_main',$data);
					}
				}	
			} 
			elseif($step == 3){
			if($this->input->post('step-btn') != ''){
				if($this->input->post('step-btn') == 0){
					redirect('rfp/edit/'.$id);
				}else{
					redirect('rfp/edit/'.$id.'/'.$this->input->post('step-btn'));
				}
			}
			elseif($this->input->post('submit')){

				$condition=['id' => decode($id)];
				$res=$this->Rfp_model->update_record('rfp',$condition,['status'	=> 1]);
				if($res){
					$this->session->set_flashdata('success', 'Request Updated Successfully');
				} else {
					$this->session->set_flashdata('error', 'Error Into Confirm Request');
				}	
				redirect('rfp/edit/'.$id.'/3');
			}
			else{

				//$data['confirm_rfp']=1;
				$data['record']=$this->Rfp_model->get_result('rfp',['id' => decode($id),'patient_id' => $this->session->userdata['client']['id'] ],'1');
				$data['subview']="front/rfp/patient/view_rfp_patient";
				$this->load->view('front/layouts/layout_main',$data);
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
				$this->session->set_flashdata('success', 'Request successfully deleted!');
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
	*	 BView RFPid (Proposal) particular rfp wise (Patient Side)
	*/
	public function view_rfp_bid($rfp_id){

		$data['rfp_data'] = $this->Rfp_model->get_result('rfp',['id' => decode($rfp_id)],true);
		$data['rfp_bid_list']=$this->Rfp_model->get_rfp_bid_data(decode($rfp_id));	
		$data['is_rated_rfp']=$this->Rfp_model->get_result('rfp_rating',['rfp_id' => decode($rfp_id)]);
		
		//----- For check Patient view doctor profile or not ------
		if(!empty($data['rfp_bid_list'])){
			foreach($data['rfp_bid_list'] as $key=>$rfp_bid_data){
				$user_id = $this->session->userdata('client')['id'];
				$data['rfp_bid_list'][$key]['is_profile_allow']= $this->Rfp_model->check_if_user_view_profile($rfp_bid_data['doctor_id'],decode($rfp_id));
			}
		}
		//----- End For check Patient view doctor profile or not ------
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
    	$res = $this->Messageboard_model->insert_record('messages',$data);
    	// ------------------------------------------------------------------------
    	// v! insert data notifications table
    	$frm_id = $this->session->userdata('client')['id'];
    	$rfp_id = $this->input->post('rfp_id');

    	$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_id],true); // fetch RFP data
    	$link = 'messageboard/message/'.encode($rfp_id).'/'.encode($frm_id);

    	$role_id = $this->session->userdata('client')['role_id'];
		
		if($role_id == '4'){ $noti_from = 'doctor'; }else{ $noti_from = 'patient'; }

		$noti_data = [
						'from_id'=>$this->session->userdata('client')['id'],
						'to_id'=>$this->input->post('to_id'),
						'rfp_id' => $rfp_id,
						'noti_type'=>'message',
						'noti_msg'=>'You have unread message for <b>'.$rfp_data['title'].'</b> from '.$noti_from,
						'noti_url'=>$link
					];											
		$this->Notification_model->insert_notification($noti_data);    	
    	// ------------------------------------------------------------------------
    	
    	// $where=['id' => $this->input->post('rfp_bid_id')];
    	// $up_data=['is_chat_started' => '1'];
	    // $res=$this->Rfp_model->update_record('rfp_bid',$where,$up_data);

	    if($res)
	    {
	    	$where=['id' => $this->input->post('to_id')];
	    	$user_data=$this->Rfp_model->get_result('users',$where,'1');

	    	//------------ Send Mail Config-----------------
	    	$html_content=mailer('contact_inquiry','AccountActivation'); 
	        $username= $user_data['fname']." ".$user_data['lname'];
	        //----- For Message -------
	    	$msg_url = 'messageboard/message/'.encode($rfp_id).'/'.encode($frm_id);
	        $msg = $this->input->post('message')." <br/><br/>";
		    $msg .= "<a href='".base_url($msg_url)."'>Click Here To Reply</a>";
		    //----- End For Message -------
	        $html_content = str_replace("@USERNAME@",$username,$html_content);
	        $html_content = str_replace("@MESSAGE@",$msg,$html_content);
	       
	        $email_config = mail_config();
	        $this->email->initialize($email_config);
	        $from_name =$this->session->userdata('client')['fname']." ".$this->session->userdata('client')['lname'];
	        $subject=config('site_name').' - Message For '.$this->input->post('rfp_title').' Request From '.$from_name;    
	        $this->email->from(config('contact_email'), config('sender_name'))
	                    ->to($user_data['email_id'])
	                    ->subject($subject)
	                    ->message($html_content);
	        $this->email->send(); 
	        //------------ End Send Mail Config-----------------        
	    	$this->session->set_flashdata('success', 'Message Send Successfully');
	    } else {
	    	$this->session->set_flashdata('error', 'Error Into Send Message');
	    }

	    //--------- If submit using ajax then return true and false -----
	    if($this->input->is_ajax_request() && $res){	    	
	    	echo true;			
	    } elseif($this->input->is_ajax_request() && !$res){
	    	echo false;
	    } else{
	    	redirect('rfp/view_rfp_bid/'.encode($this->input->post('rfp_id')));
	    }
    }

	/* 
	*	Doctor Search RFP 
	*/ 
	public function search_rfp(){    
		
		$where = 'is_deleted !=  1 and is_blocked != 1';
		$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);

		//------------ Fetch Filter Data using session id ----------
		$where_filter=[	
						'user_id'	=> $this->session->userdata('client')['id']
					 ];
		$data['search_filter_list']=$this->Rfp_model->get_result('custom_search_filter',$where_filter);
		//------------------------------------------------------------
		//pr($_GET,1);
		//------- Filter RFP ----
		$search_data= $this->input->get('search') ? $this->input->get('search') :'';
		$date_data= $this->input->get('date') ? $this->input->get('date') :'';
		$cat_data =  $this->input->get('treatment_cat_id') ? $this->input->get('treatment_cat_id') :'';
		$sort_data= $this->input->get('sort') ? $this->input->get('sort') :'desc';
		$favorite_data= $this->input->get('favorite_search') ? $this->input->get('favorite_search') :'All';
		$bid_data = $this->input->get('bid_search') ? $this->input->get('bid_search') :'All';
		$saved_filter= $this->input->get('saved_filter') ? $this->input->get('saved_filter') :'';
		//------- /Filter RFP ----
		$category_data='';
		if($cat_data != ''){
			foreach($cat_data as $cat) {
				$category_data .= "&treatment_cat_id[]=".$cat;
			}
		}
			
		$config['base_url'] = base_url().'rfp/search_rfp?search='.$search_data.'&date='.$date_data.$category_data.'&sort='.$sort_data.'&favorite_search='.$favorite_data.'&bid_search='.$bid_data.'&saved_filter='.$saved_filter;
		$config['total_rows'] = $this->Rfp_model->search_rfp_count($search_data,$date_data,$cat_data,$favorite_data,$bid_data);
		//qry(1);
		$config['per_page'] = 10;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());       
		$this->pagination->initialize($config);
		$data['rfp_data']=$this->Rfp_model->search_rfp_result($config['per_page'],$offset,$search_data,$date_data,$cat_data,$sort_data,$favorite_data,$bid_data);
		//pr($data['rfp_data']);
		// qry(1);
		$data['subview']="front/rfp/doctor/search_rfp";
		$this->load->view('front/layouts/layout_main',$data);
	}

	/*
     *  view RFP data 
    */
    public function view_rfp($rfp_id){
        
        if($this->session->userdata('client')['role_id'] == '4') // Check For Doctor Role (4)
        {
        	 //---------- Only Open RFP View By Doctor (Status >= 3)-------
        	 $data['record']=$this->Rfp_model->rfp_result_with_distance('rfp',['id' => decode($rfp_id),'status >=' => '3'],'1');
        	 if(empty($data['record'])){
        	 	show_404();
        	 } else {
        	 	$doctor_id = $this->session->userdata('client')['id'];
	        	$data['is_allow_rfp_info']= $this->Rfp_model->check_if_doctor_view_rfp_info(decode($rfp_id),$doctor_id);
	        	$where=['rfp_id' => decode($rfp_id),'doctor_id' => $this->session->userdata('client')['id'],'is_deleted' => '0'];
	        	$data['rfp_bid']=$this->Rfp_model->get_result('rfp_bid',$where,1);
	        	$data['subview']="front/rfp/doctor/view_rfp_doctor";
        	 }
        }
       	elseif($this->session->userdata('client')['role_id'] == '5') // Check For Patient Role (5)
       	{
       		$data['is_view_rfp'] = 1;
       		$data['record']=$this->Rfp_model->get_result('rfp',['id' => decode($rfp_id),'patient_id' => $this->session->userdata['client']['id'] ],'1');
       		 if(empty($data['record'])){
        	 	show_404();
        	 } else{
        	 	$data['subview']="front/rfp/patient/view_rfp_patient";
        	 }
       		
       	}
       	// pr($data['record'],1);
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
	    	$rfp_id = $this->input->post('rfp_id');
	    	$link = 'rfp/view_rfp_bid/'.encode($rfp_id);
	    	$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$this->input->post('rfp_id')],true);

			$noti_data = [
							'from_id'=>$this->session->userdata('client')['id'],
							'to_id'=>$rfp_data['patient_id'],
							'rfp_id' => $rfp_id,
							'noti_type'=>'doc_bid',
							'noti_url'=>$link,
							'noti_msg'=>"You have new bid on <b>".$rfp_data['title'].'</b> by doctor'							
						];
													
			$this->Notification_model->insert_notification($noti_data);
	    	// ------------------------------------------------------------------------
	    	if($res){
	    		$this->session->set_flashdata('success', 'Bid Placed Successfully!');
	    	}else{
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
	    	}else{
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
            if(count($arr_date) == 3 && is_numeric($arr_date[0]) && is_numeric($arr_date[1]) && is_numeric($arr_date[2]) && checkdate($arr_date[0], $arr_date[1], $arr_date[2])){                
                return TRUE;
            }else{
                return FALSE;
            }
        }        
    }

    /* @DHK Custom Form validation for zipcode
    /* Param 1 : Zipcode
    /* Param 2 : for return array if null then return TRUE/FALSE(Optional)
    */
    public function validate_zipcode($zipcode,$data=''){
        if($zipcode != '')
        {
            $str = 'https://maps.googleapis.com/maps/api/geocode/json?key='.GOOGLE_MAP_API.'&components=postal_code:'.$zipcode.'&sensor=false';
            $res = $this->unirest->get($str);
            $res_arr = json_decode($res->raw_body,true);
            // If $data is not null means return a longitude and latitude array ohter wise only status True/False
            if($data){
	            return $res_arr;
            }
            else
            {
            	if($res_arr['status'] != 'OK' && !empty($zipcode)){
	                return FALSE;
	            }else if($res_arr['status'] == 'OK' && !empty($zipcode)) {
	                return TRUE;
	            }
            }
            
        }        
    }

    //------------- Make Payment by patient when create a RFP ---------
    public function make_payment(){
		if($this->input->post('submit')) {
			$final_price = config('patient_fees');
			$discount=0;
			$promotinal_code_id = '';
			$rfp_id = decode($this->input->post('rfp_id'));
			//------ Calculate the discount based on coupan code ----
			if($this->input->post('coupan_code') != ''){
				$data=$this->Promotional_code_model->fetch_coupan_data();
				//--- Check code is valid and apply code limit for per user
				if(isset($data['discount']) && $data['discount'] != '' && $data['per_user_limit'] > $data['total_apply_code']) {
					$promotinal_code_id = $data['id'];
					$discount = $data['discount'];
					$final_price = $final_price - (($final_price * $discount) /100);
				}
			}
			$payment_arr=[
				'rfp_id'				=> $rfp_id,
				'actual_price'  		=> config('patient_fees'),
				'payable_price'			=> $final_price,
				'discount'				=> $discount,
				'promotinal_code_id'	=> $promotinal_code_id,
			];

			$this->session->set_userdata('payment_data',$payment_arr);
			//----------------Paypal Payment------------------
			// Final price is > 0 then redirect to paypal other wise skip it paypal
			if($final_price > 0){		
				$this->paypal_payment(); // Redirect to Paypal
			}else{
				redirect('rfp/complete_transaction'); // Skip paypal and follow next step after paypal
			}			
			//------ End Calculate the discount based on coupan code ----
		}		
    }


    // ------------------------------------------------------------------------
    public function doctor_discount_100($rfp_id,$coupan_code_id,$actual_price){
    	
    	$user_data = $this->session->userdata('client');
       	$user_id = $user_data['id'];
       	$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_id],true);
    	// ------------------------------------------------------------------------
		// Insert into Next Schdule payment (billing_schedule)
    	// ------------------------------------------------------------------------
    	$due_1_arr = array(
    						'doctor_id'=>$user_data['id'],
    						'rfp_id'=>$rfp_id,
    						'next_billing_date'=>date('Y-m-d'),
    						'price'=>'0',
    						'status'=>'1',
    						'created_at'=>date('Y-m-d H:i:s')
    					);
    	$this->Rfp_model->insert_record('billing_schedule',$due_1_arr);
        
        $this->Rfp_model->update_record('rfp',['id'=>$rfp_id],['status'=>'5']); // status : 5 - chnage pending  to waiting for doctor approval

    	$due_2_arr =  array(
    						'doctor_id'=>$user_data['id'],
    						'rfp_id'=>$rfp_id,
    						'next_billing_date'=>date('Y-m-d', strtotime("+45 days")),
    						'price'=>'0',
    						'is_second'=>'1',
    						'created_at'=>date('Y-m-d H:i:s')
    						);
    	$this->Rfp_model->insert_record('billing_schedule',$due_2_arr);

    	// ------------------------------------------------------------------------
		// Insert into Next Schdule payment (billing_schedule)
    	// ------------------------------------------------------------------------

    	$transaction_arr =  array(
    							'user_id'=>$user_data['id'],
    							'rfp_id'=>$rfp_id,
    							'actual_price'=>$actual_price,
    							'payable_price'=>'0',
    							'discount'=>'100',
    							'promotional_code_id'=>$coupan_code_id,
    							'paypal_token'=>'',
    							'meta_arr'=>'',
    							'status'=>'1',
    							'created_at'=>date('Y-m-d H:i:s')
    						);
    	$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);

    	//------------------ Auto Generated Message  ----------------
		$ins_data = array(
							'rfp_id'=>$rfp_id,
							'from_id'=>$rfp_data['patient_id'],
							'to_id'=>$user_data['id'],
							'message'=>'( Auto-generated message ) You have been selected for '.$rfp_data['title'].' RFP.',
							'created_at'=>date('Y-m-d H:i:s'),
						);
		$this->Rfp_model->insert_record('messages',$ins_data);
		//------------------ End Auto Generated Message ----------------

		// ----------------------------- Patient Notification -----------------------------
    	$noti_data = [
    					'from_id'=>$user_data['id'],
    					'to_id'=>$rfp_data['patient_id'],
    					'rfp_id'=>$rfp_id,
    					'noti_type'=>'confirm_payment',
    					'noti_msg'=>'Congratulation..!! Doctor has confirmed the RFP - <b>'.$rfp_data['title'].'</b>.Please contact doctor for appointment.',
    					'noti_url'=>'dashboard'
    				];
    	$this->Notification_model->insert_rfp_notification($noti_data);
    	// ------------------------------------------------------------------------

		// -----------------------------  Doctor Notification  -----------------------------
    	$noti_data = [
    					'from_id'=>$rfp_data['patient_id'],
    					'to_id'=>$user_data['id'],
    					'rfp_id'=>$rfp_id,
    					'noti_type'=>'confirm_payment',
    					'noti_msg'=>'Congratulation..!! You\'re contract has been made with patient.',
    					'noti_url'=>'dashboard'
    				];
    	$this->Notification_model->insert_rfp_notification($noti_data);
    	// -----------------------------------------------------------------------

    	//----------------- Chnage RFP Bid is_chat_started Stauts -------------
    	$this->Rfp_model->update_record('rfp_bid',['rfp_id'=>$rfp_id,'status'=>'2','doctor_id'=>$user_data['id']],['is_chat_started'=>'1']);
    	//----------------- Chnage RFP Bid is_chat_started Stauts -------------


    	// Need to redirect after this Step
    	$this->session->set_flashdata('success','Congratulations to your new patient, please, schedule an appointment, from the appointment management tab <a href="'.base_url().'dashboard'.'">click here</a>');
	   	redirect('dashboard?reload='.encode($rfp_id));    	
    }
    

    public function make_doctor_payment(){

       	$user_data = $this->session->userdata('client');
       	$user_id = $user_data['id'];

       	$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_id],true);

       	//--------------- Calcuate discount and find installment 1 & 2  -----------
       	$rfp_id = decode($this->input->post('rfp_id'));

       	$rfp_bid_data = $this->Rfp_model->get_result('rfp_bid',['rfp_id'=>$rfp_id,'doctor_id'=>$user_id],true);
       	$amt = $rfp_bid_data['amount']; // Bid price								
		$percentage = config('doctor_fees');
		$payable_price = ($percentage * $amt)/100; // calculate 10% againts the bid of doctor
		if($payable_price < config('doctor_initial_fees')){
			$payable_price = config('doctor_initial_fees');
		}
		$orignal_price=$payable_price;
		$is_second_due = 0;

	    $promotinal_code_id = 0;  	
       	//---------- If coupan code is enter ---------
       	if($this->input->post('coupan_code') != ''){
			$data=$this->Promotional_code_model->fetch_coupan_data();
			//--- Check code is valid and apply code limit for per user
			if(isset($data['discount']) && $data['discount'] != '' && $data['per_user_limit'] > $data['total_apply_code']) {
				$promotinal_code_id = $data['id'];
				$discount = $data['discount'];
				$payable_price = $payable_price - (($payable_price * $discount) /100);
			}
		}
		//---------- End coupan code is enter ---------
		$due_1 = config('doctor_initial_fees');
		if($payable_price == 0){
			if($due_1 > $orignal_price){
				$orignal_price = $due_1; // Means Admin min amount
			}
			$due_1 = 0;
			$due_2 = 0;
		}
		elseif($payable_price > $due_1){
			$due_2 = $payable_price - $due_1;
			$is_second_due = 1;
		}else{
			// check IF Promotional Code Apply or not 
			$due_2 = 0;
			if($promotinal_code_id != 0){
				$due_1 = $payable_price;	
			}else{
				// IF not apply then consider min price fixed by admin
				$payable_price = $due_1;
			}
			
		}

		//--------------- End Calcuate discount and find installment 1 & 2  ------------

       	$rfp_id = decode($this->input->post('rfp_id'));
       	$coupan_code = $this->input->post('coupan_code');
       	$due_1 = $due_1;
       	$due_2 = $due_2;       	
       	$actual_price = $payable_price;
       	$orignal_price = $orignal_price;
       	$default_payment = $this->input->post('payment_method');

       	
       	// fetch data from billing agrrement table for user id
    	$billing_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_id,'status'=>'1'],true);

    	
       	$total_per_discount = 0;
       	if($due_1 == 0 && $due_2 == 0){
       		$this->doctor_discount_100($rfp_id,$promotinal_code_id,$orignal_price);
       	}

       	if($default_payment == 'manual'){

       		$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_id],true);
       		//--------------------- For Billing Schedule ---------------
       		$due_1_arr = array(
        						'doctor_id'=>$user_data['id'],
        						'rfp_id'=>$rfp_id,
        						'next_billing_date'=>date('Y-m-d'),
        						'transaction_id'=> 'MANUAL',
        						'price'=>$due_1,
        						'is_manual'=>'1', // 1 Means Manual Payment 
        						'status'=> '1',
        						'created_at'=>date('Y-m-d H:i:s')
        						);
        	$this->Rfp_model->insert_record('billing_schedule',$due_1_arr);
                	
        	$due_2_arr =  array(
        						'doctor_id'=>$user_data['id'],
        						'rfp_id'=>$rfp_id,
        						'next_billing_date'=>date('Y-m-d', strtotime("+45 days")),
        						'transaction_id'=> 'MANUAL',
        						'price'=>$due_2,
        						'is_second'=>'1',
        						'is_manual'=>'1', // 1 Means Manual Payment 
        						'created_at'=>date('Y-m-d H:i:s')
        						);
        	$this->Rfp_model->insert_record('billing_schedule',$due_2_arr);
       		//--------------------End For Biling Schedule --------------

       		//---------------- For Payment Transaction --------------
       		$transaction_arr =  array(
        							'user_id'=>$user_data['id'],
        							'rfp_id'=>$rfp_id,
        							'actual_price'=>$orignal_price,
        							'payable_price'=>$due_1,
        							'discount'=>(isset($discount)) ? $discount:0,
        							'promotional_code_id'=>(isset($promotinal_code_id)) ? $promotinal_code_id:0,
        							'payment_type' => 1, // 1 Means Manual Payment 
        							'status' => 0,
        							'created_at'=>date('Y-m-d H:i:s')
        						);

			$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
			//---------------- End For Payment Transaction --------------

			//------------------ Auto Generated Message  ----------------
			$ins_data = array(
								'rfp_id'=>$rfp_id,
								'from_id'=>$rfp_data['patient_id'],
								'to_id'=>$user_data['id'],
								'message'=>'( Auto-generated message ) You have been selected for '.$rfp_data['title'].' Request.',
								'created_at'=>date('Y-m-d H:i:s'),
							);
			$this->Rfp_model->insert_record('messages',$ins_data);
			//------------------ End Auto Generated Message ----------------

			// ----------------------------- Patient Notification -----------------------------
	    	$noti_data = [
	    					'from_id'=>$user_data['id'],
	    					'to_id'=>$rfp_data['patient_id'],
	    					'rfp_id'=>$rfp_id,
	    					'noti_type'=>'confirm_payment',
	    					'noti_msg'=>'Congratulation..!! Doctor has confirmed the Request - <b>'.$rfp_data['title'].'</b>.Please contact doctor for appointment.',
	    					'noti_url'=>'dashboard'
	    				];
	    	$this->Notification_model->insert_rfp_notification($noti_data);
	    	// ------------------------------------------------------------------------

			// -----------------------------  Doctor Notification  -----------------------------
	    	$noti_data = [
	    					'from_id'=>$rfp_data['patient_id'],
	    					'to_id'=>$user_data['id'],
	    					'rfp_id'=>$rfp_id,
	    					'noti_type'=>'confirm_payment',
	    					'noti_msg'=>'Congratulation..!! You\'re contract has been made with patient.',
	    					'noti_url'=>'dashboard'
	    				];
	    	$this->Notification_model->insert_rfp_notification($noti_data);
	    	// -----------------------------------------------------------------------

	    	//----------------- Chnage RFP Bid is_chat_started Stauts -------------
	    	$this->Rfp_model->update_record('rfp_bid',['rfp_id'=>$rfp_id,'status'=>'2','doctor_id'=>$user_data['id']],['is_chat_started'=>'1']);
	    	//----------------- Chnage RFP Bid is_chat_started Stauts -------------

	    	//----------------------- Change RFP Status ------------------
	    	$this->Rfp_model->update_record('rfp',['id'=>$rfp_id],['status'=>'5']); // status : 4 TO 5- Doctor Confirmation pending to appointment pending
	    	//----------------------- End Change RFP Status --------------

	    	$this->session->set_flashdata('success','Congratulations to your new patient, please, schedule an appointment, from the appointment management tab');
       		redirect('dashboard?reload='.encode($rfp_id));


       	}else if($default_payment == 'paypal_new'){
       		//cancel_billing_agreement($agreement_data['billing_id']);
       		//$this->Rfp_model->delete_record('billing_agreement',['id'=>$agreement_data['id']]);
       		$billing_data = '';
       	}


       	$this->session->set_userdata('doc_payment_data',
       								['rfp_id'=>$rfp_id,'coupan_code'=>$coupan_code,
       								 'due_1'=>$due_1,'due_2'=>$due_2,'orignal_price'=>$orignal_price,
       								 'actual_price'=>$actual_price]);

       

    	// If empty create new agrrement with paypal ( Redirect to paypal if no agreement created )
    	if(empty($billing_data)){

    		$returnURL = base_url().'rfp/make_doctor_payment_success';
	       	$cancelURL = base_url().'rfp/make_doctor_payment_error';
	        //-------------------------------------------------
	       	$resArray = CallShortcutExpressCheckout('45',$returnURL, $cancelURL);

	        $ack = strtoupper($resArray["ACK"]);

	    	if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
	        	RedirectToPayPal($resArray["TOKEN"]);
	    	} else {
	        	$this->session->set_flashdata('error','Something goes wrong. Please try again');
	        	redirect('dashboard');
	        }
    	}else{

    		$billing_id = $billing_data['billing_id'];
    		$bill_api_data = get_detail_billing_agreement($billing_id);
    		
    		$ack_bill_data = strtoupper($bill_api_data['ACK']);
    		if ($ack_bill_data == "FAILURE") {

    			// Billing agreement somehow cancelled by the user
    			// Check status update in billing schedule

				$this->Rfp_model->update_record('billing_agreement',['billing_id'=>$billing_id],['status'=>'0']);

    			$returnURL = base_url().'rfp/make_doctor_payment_success';
		       	$cancelURL = base_url().'rfp/make_doctor_payment_error';
		        //-------------------------------------------------
		       	$resArray = CallShortcutExpressCheckout('45',$returnURL, $cancelURL);

		        $ack = strtoupper($resArray["ACK"]);

		    	if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
		        	RedirectToPayPal($resArray["TOKEN"]);
		    	} else {
		        	$this->session->set_flashdata('error','Something goes wrong. Please try again');
		        	redirect('dashboard');
		        }	
    		}

    		// Create referemce tramsactoin by below function    		
    		$payment_arr = DoReferenceTransaction($billing_id,$due_1);
    		$payment_arr_json = json_encode($payment_arr);    		

    		// ------------------------------------------------------------------------
    		// Insert into Next Schdule payment (billing_schedule)
        	// ------------------------------------------------------------------------
        	$due_1_arr = array(
        						'doctor_id'=>$user_data['id'],
        						'rfp_id'=>$rfp_id,
        						'next_billing_date'=>date('Y-m-d'),
        						'transaction_id'=>$payment_arr['TRANSACTIONID'],
        						'price'=>$due_1,
        						'created_at'=>date('Y-m-d H:i:s')
        						);
        	$this->Rfp_model->insert_record('billing_schedule',$due_1_arr);
                	
        	$due_2_arr =  array(
        						'doctor_id'=>$user_data['id'],
        						'rfp_id'=>$rfp_id,
        						'next_billing_date'=>date('Y-m-d', strtotime("+45 days")),
        						'price'=>$due_2,
        						'is_second'=>'1',
        						'created_at'=>date('Y-m-d H:i:s')
        						);
        	$this->Rfp_model->insert_record('billing_schedule',$due_2_arr);

	        // ------------------------------------------------------------------------
    		// Insert into transaction paylemt list (payment_transaction)
        	// ------------------------------------------------------------------------
        	$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_data['id'],'status'=>'1'],true);
        	$paypal_email = '';
        	if(!empty($agreement_data)){
        		$agreement_data = json_decode($agreement_data['meta_arr']);
        		$paypal_email= $agreement_data->EMAIL;
        	}

        	$transaction_arr =  array(
        							'user_id'=>$user_data['id'],
        							'rfp_id'=>$rfp_id,
        							'actual_price'=>$orignal_price,
        							'payable_price'=>$due_1,
        							'discount'=>(isset($discount)) ? $discount:0,
        							'promotional_code_id'=>(isset($promotinal_code_id)) ? $promotinal_code_id:0,
        							'paypal_token'=>$payment_arr['TRANSACTIONID'],
        							'meta_arr'=>$payment_arr_json,
        							'status'=>'0',
        							'paypal_email'=>$paypal_email,
        							'created_at'=>date('Y-m-d H:i:s')
        						);

			$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
       		$this->session->set_flashdata('success','Congratulations to your new patient, please, schedule an appointment, from the appointment management tab');
       		redirect('dashboard?reload='.encode($rfp_id));
	    	// redirect('dashboard');
    	}
    }	

    public function make_doctor_payment_success(){
        	
    	$data = array();

    	$user_data = $this->session->userdata('client');
    	$doc_payment_data = $this->session->userdata('doc_payment_data');

    	$due_1 = $doc_payment_data['due_1'];
    	$due_2 = $doc_payment_data['due_2'];
    	$orignal_price = $doc_payment_data['orignal_price'];
    	$actual_price = $doc_payment_data['actual_price'];
    	$coupan_code = $doc_payment_data['coupan_code'];
    	$coupon_data = [];

    	if($coupan_code != ''){
       		$coupon_data = $this->Promotional_code_model->fetch_coupan_data($coupan_code);
       	}
       
        if (isset($_REQUEST['token'])) {
        	
        	$token = $_REQUEST['token'];
        	$payer_id = $_REQUEST['PayerID'];

        	$ret_arr = CreateBillingAgreement($token); // Create Billing agreement return billing agreement ID        	
        	$ack_agreement = strtoupper($ret_arr['ACK']);

        	if ($ack_agreement == "SUCCESS" || $ack_agreement == "SUCCESSWITHWARNING") {
        		$billing_id = $ret_arr['BILLINGAGREEMENTID'];				

        		$all_details = get_detail_billing_agreement($billing_id);
        		$all_details_json = json_encode($all_details);

        		// ------------------------------------------------------------------------
        		// billing_schedule Make Initial payment
	        	// ------------------------------------------------------------------------
	        	$payment_due_1 = DoExpressCheckoutPayment($payer_id,$token,$due_1);
	        	$payment_meta_arr = json_encode($payment_due_1);

        		// ------------------------------------------------------------------------
        		// Insert into Billing Agreement
        		// ------------------------------------------------------------------------

    			// fetch data from billing agrrement table for user id
				$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_data['id'],'status'=>'1'],true);
				if(!empty($agreement_data)){
					//--- For Check if agreement id is same then not cancel billing agreement (Create same account agreement then occur this situation) 
					if($agreement_data['billing_id'] != $billing_id){
						cancel_billing_agreement($agreement_data['billing_id']);	
					}
        			$this->Rfp_model->delete_record('billing_agreement',['doctor_id'=>$user_data['id']]);
				}
				
				$ins_data = array(
        							'doctor_id'=>$user_data['id'],
        							'billing_id'=>$billing_id,
        							'rfp_id'=>$doc_payment_data['rfp_id'],
        							'status'=>'1',
        							'meta_arr'=>$all_details_json,
        							'created_at'=>date('Y-m-d H:i:s')
        						);
	        	$this->Rfp_model->insert_record('billing_agreement',$ins_data);
	        	
	        	// ------------------------------------------------------------------------
        		// Insert into Next Schdule payment (billing_schedule)
	        	// ------------------------------------------------------------------------
	        	$due_1_arr = array(
	        						'doctor_id'=>$user_data['id'],
	        						'rfp_id'=>$doc_payment_data['rfp_id'],
	        						'next_billing_date'=>date('Y-m-d'),
	        						'transaction_id'=>$payment_due_1['PAYMENTINFO_0_TRANSACTIONID'],
	        						'price'=>$due_1,
	        						'created_at'=>date('Y-m-d H:i:s')
	        						);
	        	$this->Rfp_model->insert_record('billing_schedule',$due_1_arr);
	        		        	
	        	$due_2_arr =  array(
	        						'doctor_id'=>$user_data['id'],
	        						'rfp_id'=>$doc_payment_data['rfp_id'],
	        						'next_billing_date'=>date('Y-m-d', strtotime("+45 days")),
	        						'price'=>$due_2,
	        						'is_second'=>'1',
	        						'created_at'=>date('Y-m-d H:i:s')
	        						);
	        	$this->Rfp_model->insert_record('billing_schedule',$due_2_arr);	        	
	        	
	        	// ------------------------------------------------------------------------
        		// Insert into Next Schdule payment (billing_schedule)
	        	// ------------------------------------------------------------------------
	        	$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_data['id'],'status'=>'1'],true);
	        	$paypal_email = '';
	        	if(!empty($agreement_data)){
	        		$agreement_data = json_decode($agreement_data['meta_arr']);
	        		$paypal_email= $agreement_data->EMAIL;
	        	}
	        	$transaction_arr =  array(
	        							'user_id'=>$user_data['id'],
	        							'rfp_id'=>$doc_payment_data['rfp_id'],
	        							'actual_price'=>$orignal_price,
	        							'payable_price'=>$due_1,
	        							'discount'=>(isset($coupon_data['discount'])) ? $coupon_data['discount']:0,
	        							'promotional_code_id'=>(isset($coupon_data['id'])) ? $coupon_data['id']:0,
	        							'paypal_token'=>$payment_due_1['PAYMENTINFO_0_TRANSACTIONID'],
	        							'meta_arr'=>$payment_meta_arr,
	        							'status'=>'0',
	        							'paypal_email'=>$paypal_email,
	        							'created_at'=>date('Y-m-d H:i:s')
	        						);
	        	$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);

	        	// ------------------------------------------------------------------------

	        	$url = base_url().'cron/check_status';
    			$res = $this->unirest->get($url);

	        	$this->session->set_flashdata('success','Congratulations to your new patient, please, schedule an appointment, from the appointment management tab');
	        	redirect('dashboard?reload='.encode($doc_payment_data['rfp_id']));
			}else{
				$this->session->set_flashdata('error','Something goes wrong. Please try again');
	        	redirect('dashboard');
			}
        }
    }

    public function make_doctor_payment_error(){
    	$this->session->set_flashdata('error','Something goes wrong. Please try again');
	    redirect('dashboard');
    }

    // ------------------------------------------------------------------------

    //------------ Paypal Payment ---
    public function paypal_payment(){

		$action= 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		$rfp_id= $this->session->userdata['payment_data']['rfp_id'];
		$final_price = $this->session->userdata['payment_data']['payable_price'];
		$form = '';
		$form .= '<form name="frm_payment_method" action="' . $action . '" method="post">';
		$form .= '<input type="hidden" name="business" value="demo.narolainfotech@gmail.com" />';
		 // Instant Payment Notification & Return Page Details /
		 $form .= '<input type="hidden" name="notify_url" value="' . base_url('rfp/complete_transaction') . '" />';
		 $form .= '<input type="hidden" name="cancel_return" value="' . base_url('rfp/edit/'.encode($rfp_id).'/3') . '" />';
		 $form .= '<input type="hidden" name="return" value="' . base_url('rfp/complete_transaction') . '" />';
		 $form .= '<input type="hidden" name="rm" value="2" />';
		 // Configures Basic Checkout Fields -->
		 $form .= '<input type="hidden" name="lc" value="" />';
		 $form .= '<input type="hidden" name="no_shipping" value="1" />';
		 $form .= '<input type="hidden" name="no_note" value="1" />';
		 // <input type="hidden" name="custom" value="localhost" />-->
		 $form .= '<input type="hidden" name="currency_code" value="USD" />';
		 $form .= '<input type="hidden" name="page_style" value="paypal" />';
		 $form .= '<input type="hidden" name="charset" value="utf-8" />';
		 $form .= '<input type="hidden" name="item_name" value="test" />';
		 $form .= '<input type="hidden" value="_xclick" name="cmd"/>';
		 $form .= '<input type="hidden" name="amount" value="'.$final_price.'" />';
		 $form .= '<script>';
		 $form .= 'setTimeout("document.frm_payment_method.submit()", 2);';
		 $form .= '</script>';
		 $form .= '</form>';
		 echo $form;
    }
    
    //----------Complete Transaction and Insert data into Payment Transaction table & Update Status in RFP----- 
    public function complete_transaction(){
    	
    	$paypal_data = '';
    	$paypal_email = '';
    	if($this->input->get('tx') != ''){
    		$data=GetTransactionDetails($this->input->get('tx'));
    		$paypal_email = $data['EMAIL'];
    		$paypal_data = json_encode($data);
    	}

    	//------ If refresh this page then redirect to RFP list ---
    	if(empty($this->session->userdata('payment_data'))){
    		redirect('rfp');
    	}
    	//---------------------
    	
    	$this->load->model('Payment_transaction_model');
    	$pay_arr = [
    		'user_id'				=> $this->session->userdata['client']['id'],
    		'rfp_id'				=> $this->session->userdata['payment_data']['rfp_id'],
    		'actual_price'			=> $this->session->userdata['payment_data']['actual_price'],
    		'payable_price'			=> $this->session->userdata['payment_data']['payable_price'],
    		'discount'				=> $this->session->userdata['payment_data']['discount'],
    		'promotional_code_id'	=> $this->session->userdata['payment_data']['promotinal_code_id'],
    		'paypal_token'			=> $this->input->get('tx'),
    		'paypal_email'			=> $paypal_email,
    		'meta_arr'				=> $paypal_data,
    		'created_at'			=> date("Y-m-d H:i:s"),
    	];
    	$res=$this->Payment_transaction_model->insert_record('payment_transaction',$pay_arr);
    	if($res)
    	{
    		$rfp_id = $this->session->userdata['payment_data']['rfp_id'];
    		$condition=['id' => $rfp_id];
			$update_status=$this->Rfp_model->update_record('rfp',$condition,['status'	=> 1 , 'is_paid' => 1]);
			if($update_status){
				$rfp_data = $this->Rfp_model->get_result('rfp',['id' => $rfp_id],true);
				// ------------- Send Mail For Successfully RFP Created ------------
		        /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
		        $html_content=mailer('contact_inquiry','AccountActivation'); 
		        $username= $this->session->userdata['client']['fname']." ".$this->session->userdata['client']['lname'];
		        $message = "Your ".$rfp_data['title']." quote request has been successfully submitted. Our team will notify you when a quote from a dental professional has been reviewed. <br/>
					<p>Your dental needs are unique, and we are confident our expert team will identify a fully vetted and reliable dental professional to fulfill your precise medical specifications.</p>";
				
		        $html_content = str_replace("@USERNAME@",$username,$html_content);
		        $html_content = str_replace("@MESSAGE@",$message,$html_content);
		        //--------------------------------------

		        $email_config = mail_config();
		        $this->email->initialize($email_config);
		        $subject=config('site_name').' - Your quote request has been submitted.';    
		        $this->email->from(config('contact_email'), config('sender_name'))
		                    ->to($this->session->userdata['client']['email_id'])
		                   // ->reply_to(config('contact_email'))
		                    ->subject($subject)
		                    ->message($html_content);

		      	$this->email->send();
		     	//--------------------- End Mail -----------------------------------
		      	$this->session->unset_userdata('rfp_data');
				$this->session->unset_userdata('payment_data');	
				$data['subview'] = 'front/rfp/payment_success';
				$this->load->view('front/layouts/layout_main',$data);
			}else{
				$this->session->unset_userdata('rfp_data');
				$this->session->unset_userdata('payment_data');	
				$this->session->set_flashdata('error', 'Error Into Change Payment & Request Status, Please Contact to Admin');
				redirect('rfp');
			}
    	}
    	else
    	{
    		$this->session->unset_userdata('rfp_data');
			$this->session->unset_userdata('payment_data');	
    		$this->session->set_flashdata('error', 'Error Into Payment Transaction, Please Contact To Admin');
    		redirect('rfp');
    	}    	    	
    }

    //-------------- Doctor Review -------------------
    public function doctor_review(){

    	if($this->input->post('submit')){
    		
    		$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$this->input->post('rfp_id')],true);

    		$rating_data= [
    			'rfp_id'		=>	$this->input->post('rfp_id'),
    			'doctor_id'		=>	$this->input->post('doctor_id'),
    			'rating'		=>	$this->input->post('rating'),
    			'description'	=>	$this->input->post('description'),
    			'created_at'	=>  date("Y-m-d H:i:s"),
    		];
    		$res=$this->Rfp_model->insert_record('rfp_rating',$rating_data);
    			
    		$encode_id = encode($this->input->post('doctor_id'));
    		$link = 'dashboard/view_profile/'.$encode_id;

    		// ------------------------------------------------------------------------
	    	$noti_data = [
	    					'from_id'=>$rfp_data['patient_id'],
	    					'to_id'=>$this->input->post('doctor_id'),
	    					'rfp_id'=>$this->input->post('rfp_id'),
	    					'noti_type'=>'doc_review',
	    					'noti_msg'=>'Congratulation..!! You\'ve new review from the patient.',
	    					'noti_url'=>$link
	    				];
	    	$this->Notification_model->insert_rfp_notification($noti_data);
	    	// ------------------------------------------------------------------------

    		if($res){
    			$this->session->set_flashdata('success', 'Review Submitted Successfully');
    		}else{
    			$this->session->set_flashdata('error', 'Error Into Submit Review, Please Try Again!');
    		}
    		//--------- If submit using ajax then return true and false -----
    		if($this->input->is_ajax_request() && $res){
    			$doctor_id = $this->input->post('doctor_id');
    			$review_data=$this->Rfp_model->fetch_doctor_wise_review($doctor_id);
    			echo json_encode($review_data); 
		    }
		    elseif($this->input->is_ajax_request() && !$res){
		    	echo false;
		    }
		    else{
    			redirect('rfp/view_rfp_bid/'.encode($this->input->post('rfp_id')));
    		}
    	}
    }
    //------------- End Review --------------

    /* @DHK Choose Winner Doctor By Patient (Update RFP And rfp_bid Status for winner)
    /* Param 1 : RFP ID
    /* Param 2 : RFP BID ID
    */
    public function choose_winner_doctor($rfp_id,$rfp_bid_id){
    	
    	$appointment_schedule='';
    	if($this->input->post('appointment_schedule') != ''){
    		$appointment_schedule=implode(",",$this->input->post('appointment_schedule'));
    	}
    	
    	// Update RFP Status 
	    $rfp_bid_fetch = $this->Rfp_model->get_result('rfp_bid',['id'=>decode($rfp_bid_id)],true);
	    $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>decode($rfp_id)],true);
	    
    	$upd_rfp_status = [
    					'status'			    => '4', // 4 Means Waiting for doctor approval For this RFP
    					'appointment_schedule' 		=> $appointment_schedule,
    					'appointment_comment'	=> $this->input->post('appointment_comment'),
    					]; 
    	$res_rfp=$this->Rfp_model->update_record('rfp',['id' => decode($rfp_id)],$upd_rfp_status);
    	
    	if($res_rfp){
	    	// Update RFP Bid Status 
			$upd_rfp_bid_status = ['status' => '2']; // 2 Means Winner Doctor For This BID
	    	
	    	$res_rfp_bid = $this->Rfp_model->update_record('rfp_bid',['id' => decode($rfp_bid_id)],$upd_rfp_bid_status);

	    	// ------------------------------------------------------------------------
	    	$noti_data = [
	    					'from_id'=>$rfp_data['patient_id'],
	    					'to_id'=>$rfp_bid_fetch['doctor_id'],
	    					'rfp_id'=>decode($rfp_id),
	    					'noti_type'=>'doc_won',
	    					'noti_msg'=> 'Congratulations! For  <b>'.$rfp_data['title'].'</b>, the patient selected your offer! Your Next Step: Confirm your Payment and Schedule an appointment.',
	    					// 'noti_url'=>'rfp/view_rfp/'.$rfp_id
	    					'noti_url'=> 'dashboard?proceed_rfp='.$rfp_id,
	    				];
	    	$this->Notification_model->insert_rfp_notification($noti_data);
	    	// ------------------------------------------------------------------------

	    	if($res_rfp_bid){
	    		$this->session->set_flashdata('success', 'Winner Choose Successfully');
	    	}else{
	    		$this->session->set_flashdata('error', 'Error Into Choose Winner, Please Try Again!');
	    	}
    	}else{
    		$this->session->set_flashdata('error', 'Error Into Choose Winner, Please Try Again!');
    	}
    	redirect('rfp/view_rfp_bid/'.$rfp_id);
    }

    /* @DHK Cancel Doctor By Patient (Update RFP status 3(Open) And rfp_bid Status (0) Pending)
    /* Param 1 : RFP ID
    /* Param 2 : RFP BID ID
    */
    public function cancel_winner_doctor($rfp_id,$rfp_bid_id){

    	$upd_rfp_status = [
    					'status' => '3',
    					'appointment_schedule' 		=> '', // 3 Means Open Status For this RFP
    					'appointment_comment'	=> '',
    					]; 
    	$res_rfp=$this->Rfp_model->update_record('rfp',['id' => decode($rfp_id)],$upd_rfp_status);

    	$rfp_bid_fetch = $this->Rfp_model->get_result('rfp_bid',['id'=>decode($rfp_bid_id)],true);
    	$rfp_data = $this->Rfp_model->get_result('rfp',['id'=>decode($rfp_id)],true);
    	
    	// ------------------------------------------------------------------------
    	$noti_data = [
    					'from_id'=>$rfp_data['patient_id'],
    					'to_id'=>$rfp_bid_fetch['doctor_id'],
    					'rfp_id'=>decode($rfp_id),
    					'noti_type'=>'doc_bid_cancel',
    					'noti_msg'=>'Sorry..!! Patient canceled the agreement for <b>'.$rfp_data['title'].'</b>',
    					'noti_url'=>'dashboard'
    				];
    	$this->Notification_model->insert_rfp_notification($noti_data);
    	// ------------------------------------------------------------------------

    	if($res_rfp){
	    	// Update RFP Bid Status 
			$upd_rfp_bid_status = ['status' => '0']; // 0 Means  Pending For This BID
	    	$res_rfp_bid = $this->Rfp_model->update_record('rfp_bid',['id' => decode($rfp_bid_id)],$upd_rfp_bid_status);
		    if($res_rfp_bid){
		    		$this->session->set_flashdata('success', 'Winner Cancel Successfully');
		    	}else{
		    		$this->session->set_flashdata('error', 'Error Into Cancel Winner, Please Try Again!');
		    	}
    	}else{
    		$this->session->set_flashdata('error', 'Error Into Cancel Winner, Please Try Again!');
    	}	
    	redirect('rfp/view_rfp_bid/'.$rfp_id);
    }

    /**
     * Fetch Promotional code data Using Id 
     * */
    public function fetch_coupan_data(){

        $data=$this->Promotional_code_model->fetch_coupan_data();        
        if(!empty($data)){    
            echo json_encode($data);
        }else{
            echo 0;
        }
    }

    /**
    * Extend RFP Validity for 7 Days by patient
    **/
    public function extend_rfp_validity($rfp_id,$redirect=''){
    	
    	$rfp_data=$this->Rfp_model->get_result('rfp',['id' => decode($rfp_id)],1);
    	$rfp_valid_date = date('Y-m-d', strtotime($rfp_data['rfp_valid_date']. ' + 7 days'));
    	$rfp_array = [
    					'rfp_valid_date'	=> $rfp_valid_date,
    					'is_extended'		=>	1
    				];
    	$res=$this->Rfp_model->update_record('rfp',['id' => decode($rfp_id)],$rfp_array);
    	if($res){
    		$this->session->set_flashdata('success', 'Request Extended Successfully');
    	}else{
    		$this->session->set_flashdata('error', 'Error Into Extend Request, Please Try Again!');
    	}
    	if($redirect){
    		redirect('rfp/view_rfp_bid/'.$rfp_id); // Redirect to view rfp bid page
    	}else{
    		redirect('rfp');
    	}
    }

    /**
    * Save Filter data from search rfp doctor side 
    **/
    public function save_filter_data(){

    	$filter_array = [
    					'user_id'					=>  $this->session->userdata('client')['id'],
    					'filter_name'				=>	$this->input->post('filter_name'),
    					'search_data'				=>	$this->input->post('search_data'),
    					'search_date'				=>	$this->input->post('search_date'),
    					'search_sort'				=>	$this->input->post('search_sort'),
    					'search_bid'				=>	$this->input->post('search_bid'),
    					'search_favorite'			=>	$this->input->post('search_favorite'),
    					'search_treatment_cat_id'	=>	$this->input->post('search_treatment_cat_id'),
    					'created_at'				=>	date("Y-m-d H:i:s"),
    				];

    	$res=$this->Rfp_model->insert_record('custom_search_filter',$filter_array);
    	if($res){
    		$this->session->set_flashdata('success', 'Search Filter Saved Successfully');
    	}else{
    		$this->session->set_flashdata('error', 'Error Into Save Search Filter, Please Try Again!');
    	}
    	redirect('rfp/view_filter_data/'.encode($res));
    }


    /**
    * Edit Filter data from search rfp doctor side 
    **/
    public function update_filter_data(){
    	
    	$filter_id = $this->input->post('search_filter_id');

    	$filter_array = [
    					'filter_name'				=>	$this->input->post('filter_name'),
    					'search_data'				=>	$this->input->post('search_data'),
    					'search_date'				=>	$this->input->post('search_date'),
    					'search_sort'				=>	$this->input->post('search_sort'),
    					'search_bid'				=>	$this->input->post('search_bid'),
    					'search_favorite'			=>	$this->input->post('search_favorite'),
    					'search_treatment_cat_id'	=>	$this->input->post('search_treatment_cat_id'),
    				];

    	$res=$this->Rfp_model->update_record('custom_search_filter',['id' => $this->input->post('search_filter_id')],$filter_array);
    	if($res){
    		$this->session->set_flashdata('success', 'Search Filter Updated Successfully');
    	}else{
    		$this->session->set_flashdata('error', 'Error Into Update Search Filter, Please Try Again!');
    	}
    	
    	redirect('rfp/view_filter_data/'.encode($filter_id));
    }


    /**
    * Fetch Filter data filter id wise
    **/
    public function fetch_filter_data(){
    	$data=$this->Rfp_model->get_result('custom_search_filter',['id' => $this->input->post('filter_id')],1);
    	echo json_encode($data);
    }

    /**
    *	Count Total Filter stored for particular doctor
    **/
    public function count_filter_data(){
    	$where_filter=[	
						'user_id'	=> $this->session->userdata('client')['id']
					 ];
		$search_filter_list=$this->Rfp_model->get_result('custom_search_filter',$where_filter);
		echo count($search_filter_list);
    }


    /**
    *	when select filter from dashboard by doctor for view particular filter data
    **/
    public function view_filter_data($filter_id=''){
    	$this->session->set_flashdata('filter_id', decode($filter_id));
    	redirect('rfp/search_rfp');
    }

}
