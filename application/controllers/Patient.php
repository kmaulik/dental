<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!isset($this->session->userdata['client']) && $this->session->userdata['client']['role_id'] != 5)redirect('login');
    }	

    public function index() {
       
       	$data['subview']="front/profile/edit_patient_profile";
    	$this->load->view('front/layouts/layout_main',$data);	
        
    }

    

}
