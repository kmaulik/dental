<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
        $this->load->model('Users_model');
    }	

    public function index() {
       
        $data['subview']="front/dashboard";
        $this->load->view('front/layouts/layout_main',$data);
    }

    public function edit_profile(){
    	
        $user_data = $this->session->userdata('client');
    	$user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);
        
        $data['tab'] = 'info';
        
        if($_POST){            
            $tab = $this->input->post('tab');            
            $data['tab'] = $tab;

            if($tab == 'password'){
                $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[re_password]');
                $this->form_validation->set_rules('re_password', 'Retype Password', 'trim|required');
            }
        }


        if($this->form_validation->run() == false){
        	$data['subview']="front/profile/edit_patient_profile";
            $this->load->view('front/layouts/layout_main',$data);
        }else{
        
        }

    } // END of function edit_profile

}
