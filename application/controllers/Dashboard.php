<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
        $this->load->model(['Users_model','Country_model']);
        $this->load->library('unirest');
    }	

    public function index() {
       
        $data['subview']="front/dashboard";
        $this->load->view('front/layouts/layout_main',$data);
    }

    public function edit_profile(){    	
        $loc_arr = array();
        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);
        $data['country_list']=$this->Country_model->get_result('country');
        $decode_pass = $this->encrypt->decode($data['db_data']['password']);

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
                $this->form_validation->set_rules('birth_date', 'birth date', 'required|callback_validate_birthdate',
                                                 ['validate_birthdate'=>'Date should be in YYYY-MM-DD Format.']);
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

                $loc_arr['lat'] = $data['db_data']['latitude'];
                $loc_arr['lng'] = $data['db_data']['longitude'];

                $zipcode = $this->input->post('zipcode');

                if($zipcode != $data['db_data']['zipcode']){

                    $str = 'http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:'.$zipcode.'&sensor=false';
                    $res = $this->unirest->get($str);
                    $res_arr = json_decode($res->raw_body,true);

                    if($res_arr['status'] != 'OK'){
                        $this->session->set_flashdata('error', 'Zip code must be valid. Please try again.');
                        redirect('dashboard/edit_profile');
                    }else{
                        $loc_arr = $res_arr['results'][0]['geometry']['location'];
                    }                    
                }                

                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');                
                $city = $this->input->post('city');
                $country_id = $this->input->post('country_id');
                $zipcode = $this->input->post('zipcode');
                $gender = $this->input->post('gender');
                $phone = $this->input->post('phone');
                $birth_date = $this->input->post('birth_date');
                $address = $this->input->post('address');                

                $upd_data = array(
                                    'fname'=>$fname,
                                    'lname'=>$lname,
                                    'address'=>$address,
                                    'city'=>$city,
                                    'country_id'=>$country_id,
                                    'zipcode'=>$zipcode,
                                    'gender'=>$gender,
                                    'phone'=>$phone,
                                    'latitude' => $loc_arr['lat'],
                                    'longitude' => $loc_arr['lng'],
                                    'birth_date'=>$birth_date
                                );

                $this->Users_model->update_user_data($user_id,$upd_data);

                $u_data = $this->Users_model->get_data(['id'=>$user_id],true);
                $this->session->set_userdata('client',$u_data);
                $this->session->set_flashdata('success','Profile has been successfully updated.');

                $redirect_profile = $this->session->userdata('redirect_profile');
                if($redirect_profile != ''){
                    $this->session->unset_userdata('redirect_profile');
                    redirect('rfp/add');
                }else{
                    redirect('dashboard/edit_profile');
                }
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

    // v! Custom Form validation
    public function validate_birthdate($str){
        $field_value = $str; //this is redundant, but it's to show you how
        if($field_value != ''){
            $arr_date = explode('-',$field_value);
            if(count($arr_date) == 3 && checkdate($arr_date[1], $arr_date[2], $arr_date[0])){                
                return TRUE;
            }else{
                return FALSE;
            }
        }        
    }

}
