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
		$config['per_page'] = 1;
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
			$this->form_validation->set_rules('allergies', 'allergies', 'required');
			$this->form_validation->set_rules('medication_list', 'Medication List', 'required');
			$this->form_validation->set_rules('heart_problem', 'Heart Problem', 'required');
			$this->form_validation->set_rules('chemo_radiation', 'History', 'required');
			$this->form_validation->set_rules('surgery', 'Surgery', 'required');
		   
		   
			if($this->form_validation->run() == FALSE){             
			   $data['subview']="front/rfp/rfp-1";
			   $this->load->view('front/layouts/layout_main',$data);
			 }else{
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
			$this->form_validation->set_rules('message', 'message', 'required|max_length[500]');

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
		$rfp_arr=$this->Rfp_model->get_result('rfp',['id' => decode($id)],'1');
		
		if($rfp_arr)
		{
			if($step == 0) // For First Page Of RFP
			{
				$this->session->unset_userdata('rfp_data');
				$this->form_validation->set_rules('fname', 'first name', 'required');  
				$this->form_validation->set_rules('lname', 'last name', 'required'); 
				$this->form_validation->set_rules('birth_date', 'birth date', 'required'); 
				$this->form_validation->set_rules('title', 'RFP title', 'required'); 
				$this->form_validation->set_rules('dentition_type', 'dentition type', 'required');
				$this->form_validation->set_rules('allergies', 'allergies', 'required');
				$this->form_validation->set_rules('medication_list', 'Medication List', 'required');
				$this->form_validation->set_rules('heart_problem', 'Heart Problem', 'required');
				$this->form_validation->set_rules('chemo_radiation', 'History', 'required');
				$this->form_validation->set_rules('surgery', 'Surgery', 'required');
			   
			   
				if($this->form_validation->run() == FALSE){    
				   $data['record']=$rfp_arr;          
				   $data['subview']="front/rfp/rfp-1";
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
					$data['subview']="front/rfp/rfp-2";
					$this->load->view('front/layouts/layout_main',$data);
				}else{
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

					$rfp_data=$this->session->userdata('rfp_data');

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
	*	Doctor Search RFP 
	*/ 
	public function search_rfp(){    
		$search_data=isset($_GET['search']) ? $_GET['search'] :'';
		$sort_data=isset($_GET['sort'])?$_GET['sort']:'asc';
		$this->load->library('pagination');
		$config['base_url'] = base_url().'rfp/search_rfp?search='.$search_data.'&sort='.$sort_data;
		$config['total_rows'] = $this->Rfp_model->search_rfp_count($search_data);
		$config['per_page'] = 2;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());       
		$this->pagination->initialize($config);
		$data['rfp_data']=$this->Rfp_model->search_rfp_result($config['per_page'],$offset,$search_data,$sort_data);
		$data['subview']="front/rfp/search_rfp";
		$this->load->view('front/layouts/layout_main',$data);

	}

	 /*
     *  view RFP data 
     */
    public function view_rfp($rfp_id){
        $data['record']=$this->Rfp_model->get_result('rfp',['id' => decode($rfp_id)],'1');
        if($this->session->userdata('client')['role_id'] == '4') // Check For Doctor Role (4)
        {
        	 $data['subview']="front/rfp/view_rfp_doctor";
        }
       elseif($this->session->userdata('client')['role_id'] == '5') // Check For Patient Role (5)
       {
       		$data['subview']="front/rfp/view_rfp_patient";
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
}
