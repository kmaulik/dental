<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
        $this->load->model(['Treatment_category_model']);
    }	

    public function index($id='0'){
        if($id == 0) // For First Page Of RFP
        {
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
                //pr($this->session->userdata('rfp_data'),1);
                redirect('rfp/index/1');
            }
        }
        else{

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
                $rfp_data['treatment_cat_id']=$treatment_cat_id;
                $rfp_data['teeth']=$teeth;
                $rfp_data['other_description']=$this->input->post('other_description');
                $rfp_data['patient_id'] =$this->session->userdata['client']['id'];
                $rfp_data['status'] = 0;
                $rfp_data['created_at'] = date("Y-m-d H:i:s a");
                $rfp_data['is_deleted'] = 0;
                $this->session->unset_userdata('rfp_data');
                pr($rfp_data);die;


            }
        }    
         
    }
}
