<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->load->model(['Users_model']);
        $this->load->library(['encryption', 'upload']);
    }

    public function index() {

        $data['user_data'] = $this->session->userdata('admin');
        
        if (!empty($data['user_data'])) {
            $this->Users_model->update_user_data($data['user_data']['id'], ['last_login' => date('Y-m-d H:i:s')]);
            redirect('admin/dashboard');
        }

        if ($this->input->post()) {

            $email = $this->input->post('username');
            $password = $this->input->post('password');
            $remember_me = $this->input->post('remember_me');

            //check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
            $user_data = $this->Users_model->check_if_user_exist(['email_id' => $email, 'role_id' => 1], false, true);                        
            if (!empty($user_data)) {

                $db_pass = $this->encrypt->decode($user_data['password']);

                if ($db_pass == $password) {

                    $user_login = $this->session->userdata('user');
                    if(!empty($user_login)){
                        $this->session->set_flashdata('message', ['message'=>'Can not allow login because of user login.Try another browser.','class'=>'alert alert-danger']);
                        redirect('admin/login');
                    }
                    $this->session->set_userdata(['admin_data' => $user_data]); // Start Loggedin User Session
                    $this->session->set_flashdata('message', ['message' => 'Login Successfull', 'class' => 'alert alert-success']);
                    $this->Users_model->update_user_data($user_data['id'], ['last_login' => date('Y-m-d H:i:s')]); // update last login time
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('message', ['message' => 'Password is incorrect.', 'class' => 'alert alert-danger']);
                    redirect('admin/login');
                } // End of else for if($db_pass == $password) condition
            } else {
                $this->session->set_flashdata('message', ['message' => 'Username and password incorrect.', 'class' => 'alert alert-danger']);
                redirect('admin/login');
            }
        } else {
            $this->load->view('admin/login_admin');
        }
    }
    
    public function user_list() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id'], 'role_id' => 1], false, true);
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }
        $data['subview'] = 'admin/admin/user_list';
        $this->load->view('admin/layouts/layout_main', $data);
    }

}
