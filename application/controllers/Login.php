<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();             
        $this->load->model(array('Users_model'));
    }

    public function index() {
        //$this->session->unset_userdata('client');
        $data['user_data'] = $this->session->userdata('client');
        
        if (!empty($data['user_data'])) {
            $this->Users_model->update_user_data($data['user_data']['id'], ['last_login' => date('Y-m-d H:i:s')]);
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email');        
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/login_front';
            $this->load->view('front/layouts/layout_main',$data);
        }else{

            $email = $this->input->post('email_id');
            $password = $this->input->post('password');
            $role_id = $this->input->post('role_id');
            //check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
            $user_data = $this->Users_model->check_if_user_exist(['email_id' => $email, 'role_id' => $role_id], false, true);                        
            if (!empty($user_data)) {

                $db_pass = $this->encrypt->decode($user_data['password']);

                if ($db_pass == $password) {

                    $user_login = $this->session->userdata('client');
                    if(!empty($user_login)){
                        $this->session->set_flashdata('error','Can not allow login because of user login.Try another browser.');
                        redirect('login');
                    }
                    
                    $this->session->set_userdata(['client' => $user_data, 'loggedin' => TRUE]); // Start Loggedin User Session
                    $this->session->set_flashdata('success','Login Successfull');
                    $this->Users_model->update_user_data($user_data['id'], ['last_login' => date('Y-m-d H:i:s')]); // update last login time
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Password is incorrect.');
                    redirect('login');
                } // End of else for if($db_pass == $password) condition
            } else {
                $this->session->set_flashdata('error','Username and password incorrect.');
                redirect('login');
            }
        }
        
    }

}
