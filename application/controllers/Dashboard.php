<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
        $this->load->model(['Users_model','Country_model','Rfp_model','Treatment_category_model']);
        $this->load->library('unirest');
    }	

    public function index() {
        
        
        $data['rfp_list']=$this->Rfp_model->get_payment_list_user_wise();
        
        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);

        
        // Means 4 Doctor Dashboard 
        if($this->session->userdata('client')['role_id'] == 4) {
            
            $all_settings = $data['db_data']['alert_search_setting'];
            $data['settings'] = [];

            if(!empty($all_settings)){
                $data['settings'] = json_decode($all_settings,true);
            }

            $where = 'is_deleted !=  1 and is_blocked != 1';

            $data['treatment_category'] = $this->Treatment_category_model->get_result('treatment_category',$where);
            $data['rfp_data_fav'] = $this->Rfp_model->get_user_fav_rfp($user_id,'30'); // list of fav rfps

            $data['won_rfps'] = $this->Rfp_model->get_user_won_rfp($user_id);

            // qry();
            // pr($data['won_rfps'],1);

            $data['subview']="front/doctor_dashboard";

        } else if($this->session->userdata('client')['role_id'] == 5) { // Means 5 Patient Dashboard
            $data['subview']="front/patient_dashboard";
        }
                
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
                $this->form_validation->set_rules('city', 'city', 'required');
                $this->form_validation->set_rules('country_id', 'country', 'required');
                $this->form_validation->set_rules('zipcode', 'zipcode', 'required|callback_validate_zipcode',
                                             ['validate_zipcode'=>'Please Enter Valid Zipcode']);
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

                $longitude = $data['db_data']['longitude'];
                $latitude = $data['db_data']['latitude'];

                $zipcode = $this->input->post('zipcode');

                if($zipcode != $data['db_data']['zipcode']){

                    //-------- Fetch Longitude and Latitude based on zipcode ----
                    $longitude='';
                    $latitude='';
                    $location_data = $this->validate_zipcode($zipcode,1);
                    if($location_data['status'] == 'OK'){
                        $longitude = $location_data['results'][0]['geometry']['location']['lng'];
                        $latitude= $location_data['results'][0]['geometry']['location']['lat'];
                    }
                    //--------------------------
                }                

                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');                
                $city = $this->input->post('city');
                $country_id = $this->input->post('country_id');
                $zipcode = $this->input->post('zipcode');
                $gender = $this->input->post('gender');
                $phone = $this->input->post('phone');

                $a = explode('-',$this->input->post('birth_date'));
                $birth_date = $a[2].'-'.$a[0].'-'.$a[1];
                
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
                                    'latitude' => $latitude,
                                    'longitude' => $longitude,
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

    // List of Won RFP and offer appointment and communication on it (Appointment Pending, Contact Patient, Payment Status)
    // v! Doctor Profile Tab
    public function rfp_bids(){
        $loc_arr = array();
        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);
        $data['tab'] = 'info';

        //------- Filter RFP ----
        $search_data= $this->input->get('search') ? $this->input->get('search') :'';
        $sort_data= $this->input->get('sort') ? $this->input->get('sort') :'desc';
        $date_data = '';
        //------- /Filter RFP ----        
        $config['base_url'] = base_url().'dashboard/rfp_bids?search='.$search_data.'&date='.$date_data.'&sort='.$sort_data;
        $config['total_rows'] = $this->Rfp_model->doctor_rfp_count($search_data,$date_data);
        $config['per_page'] = 10;
        $offset = $this->input->get('per_page');
        $config = array_merge($config,pagination_front_config());       
        $this->pagination->initialize($config);
        $data['rfp_data']=$this->Rfp_model->doctor_rfp_result($config['per_page'],$offset,$search_data,$date_data,$sort_data);

        // qry();        
        // pr($data['rfp_data'],1);
        
        $data['subview']="front/profile/appointmetns";
        $this->load->view('front/layouts/layout_main',$data);
    }

    // v! - rfp_alert() function in bkp for 20_2 for RFP alert module    
    
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
        if($zipcode != '')
        {
            $str = 'http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:'.$zipcode.'&sensor=false';
            $res = $this->unirest->get($str);
            $res_arr = json_decode($res->raw_body,true);
            // If $data is not null means return a longitude and latitude array ohter wise only status True/False
            if($data){
                return $res_arr;
            }
            else
            {
                if($res_arr['status'] != 'OK' && !empty($zipcode)){
                    return FALSE;
                }else if($res_arr['status'] == 'OK' && !empty($zipcode)) {
                    return TRUE;
                }
            }
            
        }        
    }

    /* @DHK View User Profile
    /* Param 1 : User Id
    */
    public function view_profile($user_id){

        $data['db_data'] = $this->Users_model->get_data(['id'=>decode($user_id)],true);
        $data['review_data'] = $this->Rfp_model->get_user_rating(decode($user_id));
        $data['overall_review']=$this->Rfp_model->get_overall_rating(decode($user_id));
        //pr($data['overall_review'],1);
        $data['subview']="front/profile/view_profile";
        $this->load->view('front/layouts/layout_main',$data);
    }

     /* @DHK Refund Payment Request
    /* Param 1 : User Id
    */
    public function refund_request(){
        $refund_arr=[
            'payment_id' => $this->input->post('payment_id'),
            'rfp_id' => $this->input->post('rfp_id'),
            'description' => $this->input->post('description'),
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $res=$this->Rfp_model->insert_record('refund',$refund_arr);
        if($res){
            $this->session->set_flashdata('success','Refund Request Successfully Submitted');
        }else{
            $this->session->set_flashdata('success','Error Into Refund Request');
        }
        redirect('dashboard');
    }

    public function save_dashboard_alert(){
        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];

        $treatment_cat = $this->input->post('treatment_cat');
        $res_arr = ['treatment_cat'=>$treatment_cat];
        $res_str = json_encode($res_arr);
        $this->Users_model->update_user_data($user_id,['alert_search_setting'=>$res_str]);
        echo json_encode(['success'=>true]);
    }

}
