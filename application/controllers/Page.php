<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	 public function __construct() {
        parent::__construct();             
        $this->load->model(array('Cms_model','admin/Admin_contact_inquiry_model'));
    }

    /*------------ For Cms Page Dynamic Content fetch from database @DHK */
    function index($slug=''){        
    	$data['cms_data']=$this->Cms_model->get_result('cms_page',['slug' => $slug,'is_deleted' => '0', 'is_blocked' => '0']);
    	if(isset($data['cms_data'][0]) && $data['cms_data'][0] != ''){
    		$data['subview']="front/page/cms_page";
    	}
    	else{
    		$data['subview']="front/page/error-404";
    	}
		$this->load->view('front/layouts/layout_main',$data);
    }


    /* ----  For Contact Us Page Inquiry  ------- @DHK */ 
    function contact_us(){
        $data['client_data'] = $this->session->userdata('client');

    	$this->form_validation->set_rules('name', 'Full Name', 'required');
    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    	$this->form_validation->set_rules('subject', 'Subject', 'required');
    	$this->form_validation->set_rules('description', 'Message', 'required');

    	if($this->form_validation->run() == FALSE){  
    		$data['subview']="front/page/contact_us";
    		$this->load->view('front/layouts/layout_main',$data);
    	}
    	else{
    		$data=array(
    				'name'	=>$this->input->post('name'),
    				'email'	=>$this->input->post('email'),
    				'subject'	=>$this->input->post('subject'),
    				'description'	=>$this->input->post('description'),
    				'created_at'	=> date("Y-m-d H:i:s"),
    			);
    		$res=$this->Admin_contact_inquiry_model->insert_record('contact_inquiry',$data);
    		if($res){
    			 $this->session->set_flashdata('success', 'Your message successfully sent!'); 
    		}else{
    			 $this->session->set_flashdata('error', 'Error into send inquiry !!'); 
    		}
    		redirect('contact_us');
    	}	
		
    }
}    