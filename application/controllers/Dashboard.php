<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
        $this->load->model(['Users_model','Country_model']);
    }	

    public function index() {
       
        $data['subview']="front/dashboard";
        $this->load->view('front/layouts/layout_main',$data);
    }

    public function edit_profile(){
    	
        $user_data = $this->session->userdata('client');
    	$user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);
        $data['country_list']=$this->Country_model->get_result('country');
        // pr($data,2);
        $decode_pass = $this->encrypt->decode($data['db_data']['password']);
        // pr($data['db_data'],1);

        $data['tab'] = 'info';
        
        if($_POST){            
            $tab = $this->input->post('tab');            
            $data['tab'] = $tab;

            if($tab == 'info'){
                $this->form_validation->set_rules('fname', 'first name', 'required');  
                $this->form_validation->set_rules('lname', 'last name', 'required');                                              
                $this->form_validation->set_rules('address', 'address', 'required');
                $this->form_validation->set_rules('city', 'city', 'required');
                $this->form_validation->set_rules('country_id', 'country', 'required');
                $this->form_validation->set_rules('zipcode', 'zipcode', 'required');                
                $this->form_validation->set_rules('phone', 'phone', 'required|min_length[6]|max_length[15]');
                $this->form_validation->set_rules('birth_date', 'birth date', 'required');                
            }

            if($tab == 'avatar'){
                $this->form_validation->set_rules('tab', 'Tab', 'trim|required');
            }
            
            if($tab == 'password'){
                $this->form_validation->set_rules('current_password', 'Current Password', 
                                                  'trim|required|in_list['.$decode_pass.']',
                                                  ['in_list'=>'Current password is Wrong!!']);
                $this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[re_password]');
                $this->form_validation->set_rules('re_password', 'Retype Password', 'trim|required');
            }            
        }

        if($this->form_validation->run() == false){
        	$data['subview']="front/profile/edit_patient_profile";
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            
            if($tab == 'info'){                
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');                
                $city = $this->input->post('city');
                $country_id = $this->input->post('country_id');
                $zipcode = $this->input->post('zipcode');
                $gender = $this->input->post('gender');
                $phone = $this->input->post('phone');
                $birth_date = $this->input->post('birth_date');
                $address = $this->input->post('address');                

            }

            if($tab == 'password'){
                $password = $this->input->post('password');
                $encode = $this->encrypt->encode($password);
                $this->Users_model->update_user_data($user_id,['password'=>$encode]);
                $this->session->set_flashdata('success','Password has been successfully changed.');
                redirect('dashboard/edit_profile');
            }

            if($tab == 'avatar'){
                $location='uploads/avatars/';
                $res=$this->filestorage->FileInsert($location,'img_avatar','image','20000000',$data['db_data']['avatar']);

                if($res['msg'] != '' && $res['status'] == '1'){
                    $file_name = $res['msg'];
                    $this->Users_model->update_user_data($user_id,['avatar'=>$file_name]);
                    $this->session->set_flashdata('success','Avatar has been successfully changed.');
                    redirect('dashboard/edit_profile');
                }else{
                    $this->session->set_flashdata('error','Something went wrong. Please try again.');
                    redirect('dashboard/edit_profile');
                }
            }

        }
    } // END of function edit_profile

    public function remove_avatar($id){
        $id = decode($id);
        $this->Users_model->update_user_data($id,['avatar'=>'']);
        $this->session->set_flashdata('success','Avatar has been successfully removed.');
        redirect('dashboard/edit_profile');
    }


}
