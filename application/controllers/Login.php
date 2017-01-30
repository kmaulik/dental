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
            //check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
            $user_data = $this->Users_model->check_if_user_exist(['email_id' => $email], false, true); 

            if (!empty($user_data) && ($user_data['role_id'] != '1' && $user_data['role_id'] != '2')) {
                $db_pass = $this->encrypt->decode($user_data['password']);

                if ($db_pass == $password) {
                    if($user_data['is_verified'] == 1){
                        $msg="Thank you for visiting us; in order to use your account, please, check your emails for our Welcome message AND click on the activation link to use your account with us. If you haven’t received the email, please, find in our <a href='".base_url('faq')."'>FAQ </a> (Account Activation) for help.";
                        $this->session->set_flashdata('error',$msg);
                        redirect('login');
                    }
                    if($user_data['is_blocked'] == 1){
                        $msg="Unfortunately your account cannot be used. Kindly <a href='".base_url('contact_us')."'>contact us </a>, so we can activate your account again";
                        $this->session->set_flashdata('error',$msg);
                        redirect('login');
                    }
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

    function logout(){
            $this->session->unset_userdata('client');
            $this->session->set_flashdata('success','Logout Successfull');
            redirect('login');
    }    

}
