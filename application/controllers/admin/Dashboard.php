<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Users_model','Country_model']);
        check_admin_login();
    }

    /**
     * function use to display admin dashboard.(HPA)
     */
    public function index() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);        
        if (empty($data['user_data'])) { redirect('admin/login'); }        
            
        $data['subview'] = 'admin/dashboard';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * function use for logout from admin panel.(HDA)
     */
    public function log_out() {
        $this->session->unset_userdata('admin');
        $this->session->set_flashdata('message', array('message' => 'Log out Successfully.', 'class' => 'alert alert-success'));
        redirect('admin/login');
    }

    public function edit() {

        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);
        $data['country_list']=$this->Country_model->get_result('country');
        $data['state_list']=$this->Country_model->get_result('states',['country_id'=>'231']);        
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }                
        $data['heading'] = 'Edit Profile';
      
        if ($this->input->post()) {

            $avtar['msg']='';
            $path = "uploads/avatars/";
            //2 MB File Size
            $avtar = $this->filestorage->FileInsert($path, 'avatar', 'image', 2097152,$this->input->post('H_avatar'));
            //----------------------------------------
            if ($avtar['status'] == 0) {
               $this->session->set_flashdata('message', ['message'=> $avtar['msg'],'class'=>'alert alert-danger']);
           }
           else{
            
                $upd_data=array(
                    'fname' => $this->input->post('fname'),
                    'lname' => $this->input->post('lname'),
                    'email_id' => $this->input->post('email_id'),
                    'address' => $this->input->post('address'),
                    'street'=>$this->input->post('street'),
                    'city' => $this->input->post('city'),
                    'state_id' => $this->input->post('state_id'),
                    'country_id' => '231',
                    'zipcode' => $this->input->post('zipcode'),
                    'gender' => $this->input->post('gender'),
                    'phone' => $this->input->post('phone'),
                    'avatar'  => $avtar['msg'],  
                    'birth_date' => $this->input->post('birth_date'),
                    'longitude' => $this->input->post('longitude'),
                    'latitude' => $this->input->post('latitude'),
                );

                $user_id = $session_data['id']; 
                $this->Users_model->update_user_data($user_id, $upd_data);

                $user_data = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);
                $this->session->set_userdata(['admin' => $user_data]);
                $this->session->set_flashdata('message', ['message'=>'Profile updated successfully.','class'=>'alert alert-success']);
                redirect('admin/edit_profile');
           }
            
        }  
        $data['subview'] = 'admin/profile_edit';
        $this->load->view('admin/layouts/layout_main', $data);      
    }

    public function change_password() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }        
        $data['heading'] = 'Change Password';
        $sess_pass = $data['user_data']['password'];
        $decode_pass = $this->encrypt->decode($sess_pass);

        $user_id = $session_data['id'];
        $this->form_validation->set_rules('curr_pass', 'Current Password', 'trim|required|in_list[' . $decode_pass . ']', ['in_list' => 'Current Password Incorrect.', 'required' => 'Please fill the field' . ' %s .']);
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[6]|matches[re_pass]', array('required' => 'Please fill the field' . ' %s .', 'min_length' => 'Please enter password min 6 letter', 'matches' => 'Please enter same password'));
        $this->form_validation->set_rules('re_pass', 'Repeat Password', 'trim|required', array('required' => 'Please fill the field' . ' %s .'));

        if ($this->form_validation->run() == FALSE) {
            $data['subview'] = 'admin/change_password';
            $this->load->view('admin/layouts/layout_main', $data);
        } else {

            $password = $this->input->post('pass');

            if ($password == $decode_pass) {
                $this->session->set_flashdata('message', ['message'=>'Please do not use existing password.','class'=>'alert alert-danger']);
                redirect('admin/change_password');
            }
            $encode_pass = $this->encrypt->encode($password);

            $this->Users_model->update_user_data($user_id, ['password' => $encode_pass]);
            $this->session->set_flashdata('message', ['message'=>'Password has been set Successfully.','class'=>'alert alert-success']);
            redirect('admin/change_password');
        }
    }

}
