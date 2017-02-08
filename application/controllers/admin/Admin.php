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
            redirect('admin/dashboard');
        }

        if ($this->input->post()) {

            $email = $this->input->post('username');
            $password = $this->input->post('password');
            
            //check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
            $user_data = $this->Users_model->check_if_user_exist(['email_id' => $email], false, true,['1','2','3']);
            if (!empty($user_data)) 
            {

                $db_pass = $this->encrypt->decode($user_data['password']);
                if($user_data['is_verified'] == 1) 
                {
                    $this->session->set_flashdata('message', ['message'=>"Thank you for visiting us. In order to use your account, please check your emails for our Welcome message and click on the activation link to use your account with us. If you haven’t received the email, please, find in our <a href='".base_url('faq')."'>FAQ </a> (Account Activation) for help.",'class'=>'alert alert-danger']);
                    redirect('admin/login');
                }
                else
                {
                    if ($db_pass == $password) {   
                        if($user_data['is_blocked'] == 1){
                            $this->session->set_flashdata('message', ['message'=>'Your Account is Deactivated, Please contact to admin','class'=>'alert alert-danger']);
                            redirect('admin/login');
                        }
                                         
                        $user_login = $this->session->userdata('admin');
                        if(!empty($user_login)){
                            $this->session->set_flashdata('message', ['message'=>'Can not allow login because of user login.Try another browser.','class'=>'alert alert-danger']);
                            redirect('admin/login');
                        }
                        $this->session->set_userdata(['admin' => $user_data]); // Start Loggedin User Session
                        $this->session->set_flashdata('message', ['message' => 'Login Successfull', 'class' => 'alert alert-success']);
                        $this->Users_model->update_user_data($user_data['id'], ['last_login' => date('Y-m-d H:i:s')]); // update last login time
                        redirect('admin/dashboard');
                    } else {
                        $this->session->set_flashdata('message', ['message' => 'Password is incorrect.', 'class' => 'alert alert-danger']);
                        redirect('admin/login');
                    } // End of else for if($db_pass == $password) condition
                }  
            }     
            else 
            {
                $this->session->set_flashdata('message', ['message' => 'Username and password incorrect.', 'class' => 'alert alert-danger']);
                redirect('admin/login');
            }
        } 
        else 
        {
            $this->load->view('admin/login_admin');
        }
    }   

    /* ---------- Set a New Paasword when user create and forgot password ---- */
    public function set_password($rand_no){
        
        $this->session->unset_userdata('admin');
        
        $res = $this->Users_model->get_data(['activation_code'=>$rand_no],true);        

        if(empty($res)) { show_404(); }
        // pr($res,1);
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('re_password', 'Re-type Password', 'required|matches[password]');

        if($this->form_validation->run() == FALSE){
            $this->load->view('admin/set_password');
        }else{
            $password = $this->input->post('password');
            $encode_password = $this->encrypt->encode($password);
            $this->Users_model->update_user_data($res['id'],['password'=>$encode_password,'is_verified'=>'0','activation_code'=>'']);
            $this->session->set_flashdata('message', ['message' => 'Password has been successfully set.Try email and password to login.', 'class' => 'alert alert-success']);
            redirect('admin/login');
        }
    }

    /*  Check For Forgot Password   @DHK*/
    public function forgotpassword(){ 
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email');
       
        if($this->form_validation->run() == FALSE){   
            $this->load->view('admin/forgot_password');          
        }else{
            $user_data=$this->Users_model->check_if_user_exist(['email_id' => $this->input->post('email_id')], false, true,['1','2','3']);
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
                $html_content = str_replace("@FORGOTLINK@",base_url('admin/set_password/'.$rand),$html_content);
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
                 $this->session->set_flashdata('message', ['message' => 'Forgot password request sent successfully, You will receive the confirmation mail', 'class' => 'alert alert-success']);
            }
            else{
                 $this->session->set_flashdata('message', ['message' => 'Provided email address does not match with the system records.', 'class' => 'alert alert-error']);
            }
            redirect('admin/forgotpassword');
        }    
    }

}
