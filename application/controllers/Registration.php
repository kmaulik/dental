<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('client')) { redirect('dashboard');}
        $this->load->library('unirest');
        $this->load->model(array('Users_model','Country_model'));
    }

    public function user(){
        $data['country_list']=$this->Country_model->get_result('country');
        $data['state_list']=$this->Country_model->get_result('states',['country_id'=>'231']);

        $this->form_validation->set_rules('fname', 'first name', 'required');  
        $this->form_validation->set_rules('lname', 'last name', 'required');      
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|is_unique[users.email_id]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');                
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'callback_validate_birthdate',
                                            ['validate_birthdate'=>'Date should be in MM-DD-YYYY Format.']);
        $this->form_validation->set_rules('zipcode', 'zipcode', 'callback_validate_zipcode',
                                             ['validate_zipcode'=>'Please Enter Valid Zipcode']);
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('phone', 'phone', 'min_length[6]|max_length[15]');
        $this->form_validation->set_rules('agree', 'terms and condition', 'required');
                
        if($this->form_validation->run() == FALSE){
            $data['subview']='front/registration/registration_user';
            $this->load->view('front/layouts/layout_main',$data);        
        }else{

                     
            //-------- Fetch Longitude and Latitude based on zipcode ----
            $longitude='';
            $latitude='';
            $location_data = $this->validate_zipcode($this->input->post('zipcode'),1);
            if($location_data['status'] == 'OK'){
                $longitude = $location_data['results'][0]['geometry']['location']['lng'];
                $latitude= $location_data['results'][0]['geometry']['location']['lat'];
            }
            //--------------------------


            $rand=random_string('alnum',5);
            $a = explode('-',$this->input->post('birth_date'));
            $birth_date = $a[2].'-'.$a[0].'-'.$a[1];

            $data=array(
                'role_id' => $this->input->post('role'),
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email_id' => $this->input->post('email_id'),
                'street'=>$this->input->post('street'),
                'password' => $this->encrypt->encode($this->input->post('password')),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'state_id' => $this->input->post('state_id'),
                'country_id' => '231',
                'zipcode' => $this->input->post('zipcode'),
                'gender' => $this->input->post('gender'),
                'phone' => $this->input->post('phone'),
                'birth_date' => $birth_date,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'activation_code'  => $rand,
                'created_at'  => date("Y-m-d H:i:s"),
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
                //$html_content = str_replace("@PASS@",$this->input->post('password'),$html_content);
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
            } else {
                $this->session->set_flashdata('error', 'Error Into Registration. Please Try Again !!'); 
                redirect('registration/user');
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
            $user_data=$this->Users_model->check_if_user_exist(['email_id' => $this->input->post('email_id')], false, true,['4','5']);
            if($user_data)
            {
                // check If user is not verified then send a verification mail otherwise forgot password mail
                if($user_data['is_verified'] == 1)
                {
                     //------ For Email Template -----------
                    /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
                    $html_content=mailer('account_activation','AccountActivation'); 
                    $username= $user_data['fname']." ".$user_data['lname'];
                    $html_content = str_replace("@USERNAME@",$username,$html_content);
                    $html_content = str_replace("@ACTIVATIONLINK@",base_url('registration/verification/'.$user_data['activation_code']),$html_content);
                    $html_content = str_replace("@EMAIL@",$user_data['email_id'],$html_content);
                    //$html_content = str_replace("@PASS@",$this->input->post('password'),$html_content);
                    //--------------------------------------

                    $email_config = mail_config();
                    $this->email->initialize($email_config);
                    $subject=config('site_name').' - Please Confirm your Email Address';    
                    $this->email->from(config('contact_email'), config('sender_name'))
                                ->to($user_data['email_id'])
                                ->subject($subject)
                                ->message($html_content);
                    $this->email->send();
                    $this->session->set_flashdata('success', 'Thank you for your request. Please verify your account first , you will receive an activation link soon.'); 
                    redirect('login');   
                }
                else
                {
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

    // v! Custom Form validation
    public function validate_birthdate($str){
        $field_value = $str; //this is redundant, but it's to show you how
        if($field_value != ''){
            $arr_date = explode('-',$field_value);
            if(count($arr_date) == 3 && is_numeric($arr_date[0]) && is_numeric($arr_date[1]) && is_numeric($arr_date[2]) && checkdate($arr_date[0], $arr_date[1], $arr_date[2])){                
                return TRUE;
            }else{
                return FALSE;
            }
        }        
    }


    /* @DHK Custom Form validation for zipcode
    /* Param 1 : Zipcode
    /* Param 2 : for return array if null then return TRUE/FALSE(Optional)
    */
    public function validate_zipcode($zipcode,$data=''){
        if($zipcode != ''){
            // $str = 'http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:'.$zipcode.'&sensor=false';
            $str = 'https://maps.googleapis.com/maps/api/geocode/json?key='.GOOGLE_MAP_API.'&components=postal_code:'.$zipcode.'&sensor=false';
            $res = $this->unirest->get($str);
            $res_arr = json_decode($res->raw_body,true);            
            // If $data is not null means return a longitude and latitude array ohter wise only status True/False
            if($data){
                return $res_arr;
            }else{
                if($res_arr['status'] != 'OK' && !empty($zipcode)){
                    return FALSE;
                }else if($res_arr['status'] == 'OK' && !empty($zipcode)) {
                    return TRUE;
                }
            }
            
        }        
    }

    //----------------------------
       
}
