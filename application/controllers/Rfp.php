<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
    }		
	public function index()
	{
		 
		
		$this->form_validation->set_rules('fname', 'first name', 'required');  
        $this->form_validation->set_rules('lname', 'last name', 'required'); 
        $this->form_validation->set_rules('birth_date', 'birth date', 'required'); 
        $this->form_validation->set_rules('title', 'RFP title', 'required'); 
        $this->form_validation->set_rules('dentition_type', 'dentition type', 'required');
        $this->form_validation->set_rules('message', 'message', 'required');
       
        if($this->form_validation->run() == FALSE){            
           $data['subview']="front/rfp/rfp";
		   $this->load->view('front/layouts/layout_main',$data);
         }else{

         }   

		 
	}
	 
 

}
