<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
		$this->load->model(['Treatment_category_model','Rfp_model']);
	}	

	public function index(){
		
		$this->load->library('pagination');
		$where = ['is_deleted' => 0 , 'is_blocked' => 0, 'patient_id' => $this->session->userdata['client']['id']];
		$config['base_url'] = base_url().'rfp/index';
		$config['total_rows'] = $this->Rfp_model->get_rfp_front_count('rfp',$where);
		$config['per_page'] = 5;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());       
		$this->pagination->initialize($config);
		$data['rfp_list']=$this->Rfp_model->get_rfp_front_result('rfp',$where,$config['per_page'],$offset); 

		$data['subview']="front/rfp/rfp_list";
		$this->load->view('front/layouts/layout_main',$data);
	}

	/* ---------------- For Create a RFP --------------- */
	public function add($step='0'){
		if($step == 0) // For First Page Of RFP
		{
			$this->session->unset_userdata('rfp_data');
			$this->form_validation->set_rules('fname', 'first name', 'required');  
			$this->form_validation->set_rules('lname', 'last name', 'required'); 
			$this->form_validation->set_rules('birth_date', 'birth date', 'required'); 
			$this->form_validation->set_rules('title', 'RFP title', 'required'); 
			$this->form_validation->set_rules('dentition_type', 'dentition type', 'required');
			$this->form_validation->set_rules('message', 'message', 'required|max_length[500]');
			$this->form_validation->set_rules('allergies', 'allergies', 'required');
			$this->form_validation->set_rules('medication_list', 'Medication List', 'required');
			$this->form_validation->set_rules('heart_problem', 'Heart Problem', 'required');
			$this->form_validation->set_rules('chemo_radiation', 'History', 'required');
			$this->form_validation->set_rules('surgery', 'Surgery', 'required');
		   
		   
			if($this->form_validation->run() == FALSE){             
			   $data['subview']="front/rfp/rfp-1";
			   $this->load->view('front/layouts/layout_main',$data);
			 }else{
				
			   //-------------- For Multiple File Upload  ----------
			   $img_path='';
			   if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL)
			   {
					$location='uploads/rfp/';
					foreach($_FILES['img_path']['name'] as $key=>$data){
						$res=$this->filestorage->FileArrayUpload($location,'img_path',$key);
						if($res != ''){
							if($key == 0){
								$img_path=$res;
							}else{
								$img_path=$img_path."|".$res;
							}
						}
					}
			   }
			   //-----------------------
				$_POST['img_path']=$img_path;
				$this->session->set_userdata('rfp_data',$_POST); // Store Page 1 Data into Session
				redirect('rfp/add/1');
			}
		}
		else{
			//--------- For Check Step 1 is Success or not  ---------
			if(!isset($this->session->userdata['rfp_data'])){
				redirect('rfp/add');
			}
			if($this->session->userdata['rfp_data']['dentition_type'] != 'other') // If Type other than skip this validation 
			{
				$this->form_validation->set_rules('teeth[]', 'teeth', 'required');
			} 
			else{
				$this->form_validation->set_rules('other_description', 'Description', 'required');
			}
			$this->form_validation->set_rules('treatment_cat_id[]', 'Treatment Category', 'required');
			

			if($this->form_validation->run() == FALSE){  
				$where = 'is_deleted !=  1 and is_blocked != 1';
				$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);   
				$data['subview']="front/rfp/rfp-2";
				$this->load->view('front/layouts/layout_main',$data);
			}
			else
			{
				$treatment_cat_id='';
				if($this->input->post('treatment_cat_id')){
					$treatment_cat_id=implode(",",$this->input->post('treatment_cat_id')); // Convert Array into string
				} 
				$teeth='';
				if($this->input->post('teeth')){
					$teeth=implode(",",$this->input->post('teeth')); // Convert Array into string
				}   

				$rfp_data=array();
				$rfp_data=$this->session->userdata('rfp_data');
				unset($rfp_data['H_img_path']);
				$rfp_data['treatment_cat_id']=$treatment_cat_id;
				$rfp_data['teeth']=$teeth;
				$rfp_data['other_description']=$this->input->post('other_description');
				$rfp_data['patient_id'] =$this->session->userdata['client']['id'];
				$rfp_data['created_at'] = date("Y-m-d H:i:s a");
				$res=$this->Rfp_model->insert_record('rfp',$rfp_data);
				if($res){
					$this->session->set_flashdata('success', 'RFP Created Successfully');
				}
				else{
					$this->session->set_flashdata('error', 'Error Into Create RFP');
				}
				$this->session->unset_userdata('rfp_data');
				redirect('rfp');
			}
		}    
		 
	}


	 /* ---------------- For Update a RFP --------------- */
	public function edit($id='',$step='0'){
		$rfp_data=$this->Rfp_model->get_result('rfp',['id' => decode($id)]);
		
		if($rfp_data)
		{
			if($step == 0) // For First Page Of RFP
			{
				$this->session->unset_userdata('rfp_data');
				$this->form_validation->set_rules('fname', 'first name', 'required');  
				$this->form_validation->set_rules('lname', 'last name', 'required'); 
				$this->form_validation->set_rules('birth_date', 'birth date', 'required'); 
				$this->form_validation->set_rules('title', 'RFP title', 'required'); 
				$this->form_validation->set_rules('dentition_type', 'dentition type', 'required');
				$this->form_validation->set_rules('message', 'message', 'required|max_length[500]');
				$this->form_validation->set_rules('allergies', 'allergies', 'required');
				$this->form_validation->set_rules('medication_list', 'Medication List', 'required');
				$this->form_validation->set_rules('heart_problem', 'Heart Problem', 'required');
				$this->form_validation->set_rules('chemo_radiation', 'History', 'required');
				$this->form_validation->set_rules('surgery', 'Surgery', 'required');
			   
			   
				if($this->form_validation->run() == FALSE){    
				   $data['record']=$rfp_data[0];          
				   $data['subview']="front/rfp/rfp-1";
				   $this->load->view('front/layouts/layout_main',$data);
				 }else{
					
				   //-------------- For Multiple File Upload  ----------
				   $img_path='';
				   if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL)
				   {
						$location='uploads/rfp/';
						foreach($_FILES['img_path']['name'] as $key=>$data){
							$res=$this->filestorage->FileArrayUpload($location,'img_path',$key);
							if($res != ''){
								if($key == 0){
									$img_path=$res;
								}else{
									$img_path=$img_path."|".$res;
								}
							}
						}
				   }
				   //-----------------------
					$_POST['img_path']=$img_path;
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
				

				if($this->form_validation->run() == FALSE){  
					$data['record']=$rfp_data[0];
					$where = 'is_deleted !=  1 and is_blocked != 1';
					$data['treatment_category']=$this->Treatment_category_model->get_result('treatment_category',$where);   
					$data['subview']="front/rfp/rfp-2";
					$this->load->view('front/layouts/layout_main',$data);
				}
				else
				{
					$treatment_cat_id='';
					if($this->input->post('treatment_cat_id')){
						$treatment_cat_id=implode(",",$this->input->post('treatment_cat_id')); // Convert Array into string
					} 
					$teeth='';
					if($this->input->post('teeth')){
						$teeth=implode(",",$this->input->post('teeth')); // Convert Array into string
					}   

					$rfp_data=array();
					$rfp_data=$this->session->userdata('rfp_data');
					if($rfp_data['img_path'] == ''){
						$rfp_data['img_path'] = $rfp_data['H_img_path'];
					}
					unset($rfp_data['H_img_path']);
					$rfp_data['treatment_cat_id']=$treatment_cat_id;
					$rfp_data['teeth']=$teeth;
					$rfp_data['other_description']=$this->input->post('other_description');
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
}
