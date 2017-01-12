<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Users_model']);
        $this->load->library(['encryption', 'upload']);
    }

    /**
     * function use to display admin dashboard.(HPA)
     */
    public function index() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id'], 'role_id' => 1], false, true);

        if (empty($data['user_data'])) { redirect('admin/login'); }        
            
        $data['subview'] = 'admin/dashboard';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * function use for logout from admin panel.(HDA)
     */
    public function log_out() {                
        $this->session->unset_userdata('');
        $this->session->set_flashdata('message', array('message' => 'Log out Successfully.', 'class' => 'alert alert-success'));
        redirect('admin/login');
    }

    public function edit() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id'], 'role_id' => 1], false, true);
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }                
        $data['heading'] = 'Edit Profile';
        $email = $session_data['email_id'];
        $post_email = $this->input->post('email_id');
        $email_unique_str = '';
        if ($email != $post_email) {
            $email_unique_str = '|is_unique[users.email_id]';
        }

        $this->form_validation->set_rules('fname', 'First name', 'trim|required', array('required' => 'Please fill the field' . ' %s .'));
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required', array('required' => 'Please fill the field' . ' %s .'));        
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email' . $email_unique_str, array('required' => 'Please fill the field' . ' %s .', 'valid_email' => 'Please enter valid E-mail'));
        $this->form_validation->set_rules('phone_no', 'Phone Number', 'numeric|regex_match[/^[0-9]{9}$/]', array('numeric' => 'Please enter number in phone number', 'regex_match' => 'Please enter 9 number in phone'));

        if ($this->form_validation->run() == FALSE) {
            $data['subview'] = 'admin/profile_edit';
            $this->load->view('admin/layouts/layout_main', $data);
        } else {            
            $user_id = $session_data['id'];
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $email_id = $this->input->post('email_id');            
            $gender = $this->input->post('gender');
            $birth_year = $this->input->post('birth_year');
            $country_code = $this->input->post('country_code');
            $phone_no = $this->input->post('phone_no');
            $phone_privacy = (int) $this->input->post('phone_privacy');

            $old_bio = trim($data['user_data']['bio']);
            $user_bio = trim($this->input->post('user_bio'));

            $old_phone = trim($data['user_data']['phone']);
            $post_phone_no = $this->input->post('phone_no');

            $ip = $this->input->ip_address();

            //update_user_data
            $upd_data = [
                'fname' => $fname,
                'lname' => $lname,                
                'email_id' => $email_id,
                'gender' => $gender,
                'birth_year' => $birth_year,
                'country' => $country_code,
                'phone' => $phone_no,
                'is_phone_privacy' => $phone_privacy,
                'bio' => $user_bio,
                'modified_date' => date('Y-m-d H:i:s')
            ];
            
            $this->Users_model->update_user_data($user_id, $upd_data);

            $user_data = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true);
            $this->session->set_userdata(['admin' => $user_data]);
            $this->session->set_flashdata('success', 'Profile updated successfully.');
            redirect('admin/edit_profile');
        }
    }

    public function change_password() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id'], 'role_id' => 1], false, true);
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
                $this->session->set_flashdata('error', 'Please do not use existing password.');
                redirect('admin/change_password');
            }
            $encode_pass = $this->encrypt->encode($password);

            $this->Users_model->update_user_data($user_id, ['password' => $encode_pass]);
            $this->session->set_flashdata('message', ['message'=>'Password has been set Successfully.','class'=>'alert alert-success']);
            redirect('admin/dashboard');
        }
    }

}
