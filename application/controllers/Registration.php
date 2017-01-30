<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('client')) { redirect('dashboard');}
        $this->load->library('unirest');
        $this->load->model(array('Users_model','Country_model'));
    }

    /* Patient Registration @DHK */
    public function patient() {

        $data['country_list']=$this->Country_model->get_result('country');
        $data['state_list']=$this->Country_model->get_result('states',['country_id'=>'231']);

        $this->form_validation->set_rules('fname', 'first name', 'required');  
        $this->form_validation->set_rules('lname', 'last name', 'required');      
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|is_unique[users.email_id]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('city', 'city', 'required');
        $this->form_validation->set_rules('country_id', 'country', 'required');        
        $this->form_validation->set_rules('phone', 'phone', 'min_length[6]|max_length[15]');        
        $this->form_validation->set_rules('agree', 'terms and condition', 'required');
                
        if($this->form_validation->run() == FALSE){
            $data['subview']='front/registration/registration_patient';
            $this->load->view('front/layouts/layout_main',$data);        
        }else{

            // v! Check for valid zip code
            $zipcode = $this->input->post('zipcode');
            $str = 'http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:'.$zipcode.'&sensor=false';
            $res = $this->unirest->get($str);
            $res_arr = json_decode($res->raw_body,true);
            $loc_arr['lat'] = null;
            $loc_arr['lng'] = null;

            if($res_arr['status'] != 'OK' && !empty($zipcode)){
                $this->session->set_flashdata('error', 'Zip code must be valid. Please try again.');
                redirect('registration/patient');   
            }else if($res_arr['status'] == 'OK' && !empty($zipcode)) {
                $loc_arr = $res_arr['results'][0]['geometry']['location'];
            }

            $rand=random_string('alnum',5);
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
                'longitude' => $loc_arr['lng'],
                'latitude' => $loc_arr['lat'],
                'activation_code'  => $rand,
                'is_verified' => '1', // 1 Means Account is Not Verified 
                );
            $res=$this->Users_model->insert_user_data($data);
            if($res){

                //------ For Email Template -----------
                /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
                $html_content=mailer('account_activation','AccountActivation'); 
                $username= $this->input->post('fname')." ".$this->input->post('lname');
                $html_content = str_replace("@USERNAME@",$username,$html_content);
                $html_content = str_replace("@ACTIVATIONLINK@",base_url('registration/verification/'.$rand),$html_content);
                $html_content = str_replace("@EMAIL@",$this->input->post('email_id'),$html_content);
                $html_content = str_replace("@PASS@",$this->input->post('password'),$html_content);
                //--------------------------------------

                $email_config = mail_config();
                $this->email->initialize($email_config);
                $subject=config('site_name').' - Thank you for your registration';    
                $this->email->from(config('contact_email'), config('sender_name'))
                            ->to($this->input->post('email_id'))
                            ->subject($subject)
                            ->message($html_content);
                $this->email->send();
                $this->session->set_flashdata('success', 'Thank you for your registration, you will receive an activation link soon.'); 
                redirect('login');   
            } 
            else{
                $this->session->set_flashdata('error', 'Error Into Registration. Please Try Again !!'); 
                redirect('registration/patient');
            } 
        }    
    }
    
    /* Doctor Registration @DHK */
    public function doctor() {

        $this->form_validation->set_rules('fname', 'first name', 'required');  
        $this->form_validation->set_rules('lname', 'last name', 'required');      
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|is_unique[users.email_id]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');
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
            $data['subview']='front/registration/registration_doctor';
            $this->load->view('front/layouts/layout_main',$data);        
        }else{

            // v! Check for valid zip code
            $zipcode = $this->input->post('zipcode');
            $str = 'http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:'.$zipcode.'&sensor=false';
            $res = $this->unirest->get($str);
            $res_arr = json_decode($res->raw_body,true);

            if($res_arr['status'] != 'OK'){
                $this->session->set_flashdata('error', 'Zip code must be valid. Please try again.');
                redirect('registration/doctor');   
            }else{
                $loc_arr = $res_arr['results'][0]['geometry']['location'];
            }

            $rand=random_string('alnum',5);
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
                'longitude' => $loc_arr['lng'],
                'latitude' => $loc_arr['lat'],
                'activation_code'  => $rand,
                'is_verified' => '1', // 1 Means Account is Not Verified 
                );

            $res=$this->Users_model->insert_user_data($data);
            if($res){

                //------ For Email Template -----------
                /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
                $html_content=mailer('account_activation','AccountActivation'); 
                $username= $this->input->post('fname')." ".$this->input->post('lname');
                $html_content = str_replace("@USERNAME@",$username,$html_content);
                $html_content = str_replace("@ACTIVATIONLINK@",base_url('registration/verification/'.$rand),$html_content);
                $html_content = str_replace("@EMAIL@",$this->input->post('email_id'),$html_content);
                $html_content = str_replace("@PASS@",$this->input->post('password'),$html_content);
                //--------------------------------------

                $email_config = mail_config();
                $this->email->initialize($email_config);
                $subject=config('site_name').' - Thank you for your registration';    
                $this->email->from(config('contact_email'), config('sender_name'))
                            ->to($this->input->post('email_id'))
                            ->subject($subject)
                            ->message($html_content);
                $this->email->send();
                $this->session->set_flashdata('success', 'Thank you for your registration, you will receive an activation link soon.'); 
                redirect('login');   
            } 
            else{
                $this->session->set_flashdata('error', 'Error Into Registration. Please Try Again !!'); 
                redirect('registration/doctor');
            } 
        }        
    }    

    /*  Check For User Account Verify or Not 
        Param 1 : Account Verification No. 
        @DHK
    */
    public function verification($id='0'){
        if($this->Users_model->CheckActivationCode($id))
        {
            $this->db->set('activation_code','');
            $this->db->set('is_verified',0); // 0 Means Account is Verified & Now Open For Login
            $this->db->where('activation_code',$id);
            $this->db->update('users');
            $this->session->set_flashdata('success',
            'Your Email is verified successfully, Now you can login to your Account.');
        }
        else
        {
            $this->session->set_flashdata('error',
            'Activation link is either invalid or expired.');  
        }
        redirect('login');
    }

    /*  Check For Forgot Password   @DHK*/
    public function forgotpassword(){ 
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email');
       
        if($this->form_validation->run() == FALSE){            
            $data['subview']='front/security/forgot_password';
            $this->load->view('front/layouts/layout_main',$data);        
        }else{
            $user_data=$this->Users_model->check_if_user_exist(['email_id' => $this->input->post('email_id')], false, true);
            if($user_data){

                $rand=random_string('alnum',5);
                $this->db->set('activation_code', $rand);
                $this->db->where('id',$user_data['id']);
                $this->db->update('users');

                //------ For Email Template -----------
                /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
                $html_content=mailer('forgot_password','AccountActivation'); 
                $username= $user_data['fname']." ".$user_data['lname'];
                $html_content = str_replace("@USERNAME@",$username,$html_content);
                $html_content = str_replace("@FORGOTLINK@",base_url('registration/resetpwd/'.$rand),$html_content);
                //--------------------------------------

                $email_config = mail_config();
                $this->email->initialize($email_config);
                $subject= config('site_name').' - Forgot Password Request';    
                $this->email->from(config('contact_email'), config('sender_name'))
                            ->to($this->input->post('email_id'))
                            ->subject($subject)
                            ->message($html_content);
                $this->email->send();
                //echo $html_content; die;            
                $this->session->set_flashdata('success','Forgot password request sent successfully, You will receive the confirmation mail');
            }
            else{
                $this->session->set_flashdata('error','Provided email address does not match with the system records.');
            }
            redirect('registration/forgotpassword');
        }    
    }

    /*  Check For Reset Password  
        Param 1 : Activation Code 
        @DHK  
    */    
    public function resetpwd($id='0'){
        $this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('c_password', 'confirm password', 'required|matches[password]');

        if($this->form_validation->run() == FALSE)
        {
            if(!$this->Users_model->CheckActivationCode($id))
            {
                $this->session->set_flashdata('error','Password Reset link is either invalid or expired.');
                redirect('registration/forgotpassword');
            }
            else{
                $data['code']=$id;
                $data['subview']='front/security/reset_password';
                $this->load->view('front/layouts/layout_main',$data);
            }
        }
        else{
            $this->db->set('activation_code','');
            $this->db->set('password', $this->encrypt->encode($this->input->post('password')));
            $this->db->where('activation_code',$id);
            $this->db->update('users');
            $this->session->set_flashdata('success','Password Set Successfully, You can login with new password.');
            redirect('login');
        }           
    }

}
