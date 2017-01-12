<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();             
        $this->load->model(array('Users_model','Country_model'));
    }

    public function patient() {

        $this->form_validation->set_rules('fname', 'first name', 'required');  
        $this->form_validation->set_rules('lname', 'last name', 'required');      
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|is_unique[users.email_id]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('city', 'city', 'required');
        $this->form_validation->set_rules('country_id', 'country', 'required');
        $this->form_validation->set_rules('zipcode', 'zipcode', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'required|min_length[6]|max_length[15]');
        $this->form_validation->set_rules('birth_date', 'birth date', 'required');
        $this->form_validation->set_rules('agree', 'terms and condition', 'required');

        if($this->form_validation->run() == FALSE){
            $data['country_list']=$this->Country_model->get_result('country');
            $data['subview']='front/registration/registration_patient';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            $data=array(
                'role_id' => $this->input->post('role_id'),
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email_id' => $this->input->post('email_id'),
                'password' => $this->encrypt->encode($this->input->post('password')),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'country_id' => $this->input->post('country_id'),
                'zipcode' => $this->input->post('zipcode'),
                'gender' => $this->input->post('gender'),
                'phone' => $this->input->post('phone'),
                'birth_date' => $this->input->post('birth_date'),
                );
            $res=$this->Users_model->insert_user_data($data);
            if($res){
                $email_config = mail_config();
                $this->email->initialize($email_config);

                $this->email
                ->from('demo.narola@gmail.com', 'Dental')
                ->to($this->input->post('email_id'))
                ->subject('Dental - Thank You For Registration')
                ->message('Successfully Register With Dental');
                $this->email->send();
                $this->session->set_flashdata('success', 'Registration Successfull'); 
                $this->redirect('login');   
            } 
            else{
                $this->session->set_flashdata('error', 'Error Into Registration. Please Try Again !!'); 
                $this->redirect('registration/patient');

            } 
        }
        
    }

}
