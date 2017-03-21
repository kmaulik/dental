<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['admin/Admin_users_model', 'Users_model','Country_model']);
        check_admin_login();
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index() {
        $data['subview'] = 'admin/users/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in user list page
     */
    public function list_user() {
        $final['recordsTotal'] = $this->Admin_users_model->get_users_count();
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_users_model->get_users_result(TBL_USER,$select,'count');
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_users_model->get_all_users();
        echo json_encode($final);
    }

    public function action($action, $user_id) {

        $where = 'id = ' . decode($this->db->escape($user_id));
        $check_user = $this->Admin_users_model->get_result('users', $where);
        if ($check_user) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                );
               $this->session->set_flashdata('message', ['message'=> 'User successfully deleted!','class'=>'alert alert-success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                );
                $this->session->set_flashdata('message', ['message'=> 'User successfully blocked!','class'=>'alert alert-success']);
               } else {
                $update_array = array(
                    'is_blocked' => 0
                );
                $this->session->set_flashdata('message', ['message'=> 'User successfully unblocked!','class'=>'alert alert-success']);
            }
            $this->Admin_users_model->update_record('users', $where, $update_array);
        } else {
            $this->session->set_flashdata('message', ['message'=> 'Invalid request. Please try again!','class'=>'alert alert-danger']);
        }
        redirect('admin/users');
    }

    public function add() {
        $data['heading'] = 'Add User';
        $data['country_list']=$this->Country_model->get_result('country');
        $data['state_list']=$this->Country_model->get_result('states',['country_id'=>'231']);
        if ($this->input->post()) {

            $avtar['msg']='';
            $path = "uploads/avatars/";
            //10 MB File Size
            $avtar = $this->filestorage->FileInsert($path, 'avatar', 'image', 10485760);
            //----------------------------------------
            if ($avtar['status'] == 0) {
               $this->session->set_flashdata('message', ['message'=> $avtar['msg'],'class'=>'alert alert-danger']);
           }
           else{
                $rand=random_string('alnum',5);
                //$password=random_string('alnum',6);
                $ins_data=array(
                    'role_id' => $this->input->post('role_id'), // 2 Means Subadmin Role & 3 Means Agent 
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
                    'activation_code'  => $rand,
                    'is_verified' => '1', // 1 Means Account is not Verified
                    'created_at'=>date('Y-m-d H:i:s')
                    );


                $res=$this->Users_model->insert_user_data($ins_data);
                if($res){ 
                    //------ For Email Template -----------
                    /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
                    $html_content=mailer('account_activation','AccountActivation'); 
                    $username= $this->input->post('fname')." ".$this->input->post('lname');
                    $html_content = str_replace("@USERNAME@",$username,$html_content);
                    $html_content = str_replace("@ACTIVATIONLINK@",base_url('admin/set_password/'.$rand),$html_content);
                    $html_content = str_replace("@EMAIL@",$this->input->post('email_id'),$html_content);
                    //$html_content = str_replace("@PASS@",$password,$html_content);
                    //--------------------------------------

                    $email_config = mail_config();
                    $this->email->initialize($email_config);
                    $subject=config('site_name').' - Admin Create a New User';    
                    $this->email->from(config('contact_email'), config('sender_name'))
                                ->to($this->input->post('email_id'))
                                ->subject($subject)
                                ->message($html_content);
                    $this->email->send();
                    $this->session->set_flashdata('message', ['message'=>'User Created successfully.','class'=>'alert alert-success']);
                }else{
                    $this->session->set_flashdata('message', ['message'=>'Error Into Create User','class'=>'alert alert-danger']);
                }
                redirect('admin/users');
           }
            
        } 
        $data['subview'] = 'admin/users/manage';
        $this->load->view('admin/layouts/layout_main', $data);   
    }    

    /**
     * @uses : Edit Users
     * */
    public function edit($id='') {
        $user_id=decode($id);
        $data['heading'] = 'Edit User';
        $data['user_data'] = $this->Users_model->get_data(['id' => $user_id],true);
        $data['country_list']=$this->Country_model->get_result('country');
        $data['state_list']=$this->Country_model->get_result('states',['country_id'=>'231']);

        if ($this->input->post()) {
            $avtar['msg']='';
             if(isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != NULL) 
             {
                 $path = "uploads/avatars/";
                //2 MB File Size
                $avtar = $this->filestorage->FileInsert($path, 'avatar', 'image', 2097152,$this->input->post('H_avatar'));
                if ($avtar['status'] == 0) {
                   $this->session->set_flashdata('message', ['message'=> $avtar['msg'],'class'=>'alert alert-danger']);
                   redirect('admin/users');
               }
             }
             else{
                $avtar['msg'] = $this->input->post('H_avatar');
             }
           

             $upd_data=array(    
                        'role_id'   => $this->input->post('role_id'), // 2 Means Subadmin Role & 3 Means Agent     
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

            $res=$this->Users_model->update_user_data($user_id,$upd_data);
            if($res){ 
                $this->session->set_flashdata('message', ['message'=>'User Updated successfully.','class'=>'alert alert-success']);
            }else{
                $this->session->set_flashdata('message', ['message'=>'Error Into Update User','class'=>'alert alert-danger']);
            }
            redirect('admin/users');
            
        } 
        $data['subview'] = 'admin/users/manage';
        $this->load->view('admin/layouts/layout_main', $data);   
    }

    public function check_unique(){
        $email_id = $this->input->post('email_id');
        $old_email_id = $this->input->post('old_email_id');

        if($old_email_id != ''){
            if($old_email_id != $email_id){
                $res = $this->Users_model->check_if_user_unique($email_id);
                if($res == 0){
                    echo json_encode(TRUE);
                }else{
                    echo json_encode(FALSE);
                }
            }else{
                echo json_encode(TRUE);
            }
        }else{            
            $res = $this->Users_model->check_if_user_unique($email_id);
            if($res == 0){
                echo json_encode(TRUE);
            }else{
                echo json_encode(FALSE);
            }        
        }
    }

}
