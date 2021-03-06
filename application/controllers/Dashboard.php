<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
		if(!isset($this->session->userdata['client']))
        {
            $this->session->set_userdata('redirect_url',  current_url());
            redirect('login');
        }  
        else{
            //-------------------- For check role wise access function ------
            if($this->session->userdata['client']['role_id'] == 4)
            {
                 $protected_methods = array('refund_request','choose_appointment_schedule');
            }
            else if($this->session->userdata['client']['role_id'] == 5)
            {
                 $protected_methods = array('save_dashboard_alert','delete_appointment','reschedule_appointment','change_filter_notify_status','delete_search_filter','save_map_address');
                 
            }
            if(in_array($this->router->method, $protected_methods)){ 
                redirect('dashboard');
            }       
            //-------------------- For check role wise access function ------   
        } 
        $this->load->model(['Users_model','Country_model','Rfp_model','Treatment_category_model','Notification_model']);
        $this->load->library(['unirest','googlemaps']);        
    }

    public function index() {
                
        $data['rfp_list']=$this->Rfp_model->get_payment_list_user_wise();

        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);

        // Means 4 Doctor Dashboard
        if($this->session->userdata('client')['role_id'] == 4) {
                        
            $where = 'is_deleted !=  1 and is_blocked != 1';
            $data['treatment_category'] = $this->Treatment_category_model->get_result('treatment_category',$where);
            $data['rfp_data_fav'] = $this->Rfp_model->get_user_fav_rfp($user_id,'30'); // list of fav rfps                    
            $data['won_rfps'] = $this->Rfp_model->get_user_won_rfp($user_id);
            $data['total_rfp_bids'] = $this->Rfp_model->get_bids_rfp($user_id);
            $data['review_list']=$this->Rfp_model->get_user_rating($user_id); // Fetch All Review Doctor Wise
            $search_filter_where=['user_id' => $this->session->userdata('client')['id']];
            $data['search_filter_list']=$this->Rfp_model->get_result('custom_search_filter',$search_filter_where);
            $data['appointment_list']=$this->Rfp_model->get_doctor_appointment_rfp($user_id); // Fetch RFP For Appointment           
            $data['agreement_data'] = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_id],true);            
            $data['subview']="front/doctor_dashboard";

        } else if($this->session->userdata('client')['role_id'] == 5) { 

            // Means 5 Patient Dashboard

            //--------------- All RFP List -------------
            $this->load->library('pagination');
            $where = ['is_deleted' => 0 , 'is_blocked' => 0, 'patient_id' => $this->session->userdata['client']['id']];
            $config['base_url'] = base_url().'dashboard/index';
            $config['total_rows'] = $this->Rfp_model->get_rfp_front_count('rfp',$where);
            $config['per_page'] = 10;
            $offset = $this->input->get('per_page');
            $config = array_merge($config,pagination_front_config());       
            $this->pagination->initialize($config);
            $data['patient_rfp_list']=$this->Rfp_model->get_rfp_front_result('rfp',$where,$config['per_page'],$offset); 
            //-------------End All RPF List ------------
            
            $data['active_rfp_list']=$this->Rfp_model->get_active_rfp_patient_wise();
            $data['appointment_list']=$this->Rfp_model->get_patient_appointment_rfp($user_id); // Fetch RFP For Appointment
            //pr($data['active_rfp_list'],1);
            $data['subview']="front/patient_dashboard";
        }
                
        $this->load->view('front/layouts/layout_main',$data);
    }

    public function edit_profile(){
        
        $loc_arr = array();
        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);

        // pr($data['db_data'],1);
        $data['country_list']=$this->Country_model->get_result('country');
        $data['state_list']=$this->Country_model->get_result('states',['country_id'=>'231']);
        $decode_pass = $this->encrypt->decode($data['db_data']['password']);

        $get_tab = $this->input->get('tab');

        if($get_tab == 'office_map'){
            $data['tab'] = 'office_map';
        }elseif($get_tab == 'payment_method'){
            $data['tab'] = 'payment_method';
        }else{
            $data['tab'] = 'info';
        }

        // ------------------------------------------------------------------------
        // Google Maps
        // -----------------------------------------------------------------------

        $get_address = $this->input->get('address');
        $get_address_decode = '';
        $center_map_str = '52.5200, 13.4050';
        $data['get_address'] = '';

        $data['lat']='52.5200';
        $data['lng']='13.4050';

        if(!empty($data['db_data']['office_map_data'])){
                                        
            $office_map_data = json_decode($data['db_data']['office_map_data'],true);
            
            $data['lat'] = $office_map_data['lat'];
            $data['lng'] = $office_map_data['lng'];

            $center_map_str =  $data['lat'].', '.$data['lng'];
            $data['get_address'] = $office_map_data['office_text'];
        }        

        if(!empty($get_address)){
            $get_address_decode = utf8_encode(decode($get_address));
            $online_url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$get_address_decode.'&key='.GOOGLE_MAP_API;
            $res_data = $this->unirest->get($online_url);
            $row_data_decode = json_decode($res_data->raw_body);
            $location_data = $row_data_decode->results[0]->geometry->location;

            $lat_data = (string)$location_data->lat;
            $lng_data = (string)$location_data->lng;

            $data['lat'] = $lat_data;
            $data['lng'] = $lng_data;

            $center_map_str = $lat_data.', '.$lng_data;
        }
        
        $config['center'] = $center_map_str;
        $config['zoom'] = '16';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'new_id';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'get_location()';
        $this->googlemaps->initialize($config);

        // ------------------------------------------------------------------------
        $description = str_replace(array("\r","\n"),"",nl2br($data['db_data']['office_description']));

        $marker = array();
        $marker['position'] = $center_map_str; 
        $marker['infowindow_content'] = html_entity_decode($description);
        $marker['draggable'] = true;
        $marker['ondragend'] = 'fetch_lat_long(event.latLng.lat(),event.latLng.lng())';

        $this->googlemaps->add_marker($marker);

        $data['map'] = $this->googlemaps->create_map();        
        $data['latlong_location'] = $center_map_str;
        // ------------------------------------------------------------------------

        // ------------------------------------------------------------------------

        $data['agreement_created'] = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$user_id],true);        
        //pr($data['agreement_created'],1);
        // ------------------------------------------------------------------------

        if($_POST){
            
            $tab = $this->input->post('tab');
            $data['tab'] = $tab;

            if($tab == 'info'){
                $this->form_validation->set_rules('fname', 'first name', 'required');
                $this->form_validation->set_rules('lname', 'last name', 'required');
                $this->form_validation->set_rules('city', 'city', 'required');
                // $this->form_validation->set_rules('country_id', 'country', 'required');
                $this->form_validation->set_rules('state_id', 'state', 'required');
                $this->form_validation->set_rules('zipcode', 'zipcode', 'required|callback_validate_zipcode',
                                             ['validate_zipcode'=>'Please, verify your ZIP Code.']);
                $this->form_validation->set_rules('phone', 'phone', 'required|min_length[6]|max_length[15]');
                $this->form_validation->set_rules('birth_date', 'birth date', 'required|callback_validate_birthdate',
                                                ['validate_birthdate'=>'Date should be in YYYY-MM-DD Format.']);
                $this->form_validation->set_rules('public_email', 'Public Email', 'valid_email');
            }

            if($tab == 'avatar' || $tab == 'payment_method'){
                $this->form_validation->set_rules('tab', 'Tab', 'trim|required');
            }
            
            if($tab == 'password'){
                $this->form_validation->set_rules('current_password', 'Current Password', 
                                                  'trim|required|in_list['.$decode_pass.']',
                                                  ['in_list'=>'Current password is Wrong!!']);
                $this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[re_password]|min_length[5]|max_length[12]',array('min_length' => 'For Security, your password field must be at least 5 characters in length'));
                $this->form_validation->set_rules('re_password', 'Retype Password', 'trim|required|min_length[5]|max_length[12]');
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
                //pr($_POST,1);
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');                
                $city = $this->input->post('city');
                $state_id = $this->input->post('state_id');
                // $country_id = $this->input->post('country_id');
                $zipcode = $this->input->post('zipcode');
                $gender = $this->input->post('gender');
                $phone = $this->input->post('phone');
                $street = $this->input->post('street');
                $public_email = $this->input->post('public_email');
                $office_description = $this->input->post('office_description');

                $a = explode('-',$this->input->post('birth_date'));
                $birth_date = $a[2].'-'.$a[0].'-'.$a[1];
                
                $address = $this->input->post('address');                

                $upd_data = array(
                                    'fname'=>$fname,
                                    'lname'=>$lname,
                                    'address'=>$address,
                                    'city'=>$city,
                                    'state_id'=>$state_id,
                                    // 'country_id'=>$country_id,
                                    'zipcode'=>$zipcode,
                                    'gender'=>$gender,
                                    'phone'=>$phone,
                                    'street'=>$street,
                                    'latitude' => $latitude,
                                    'longitude' => $longitude,
                                    'birth_date'=>$birth_date,
                                    'public_email'=>$public_email,
                                    'office_description'=>$office_description,

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
                $res=$this->filestorage->FileInsert($location,'img_avatar','image','2097152',$data['db_data']['avatar']);

                if($res['msg'] != '' && $res['status'] == '1'){
                    $file_name = $res['msg'];
                    $this->Users_model->update_user_data($user_id,['avatar'=>$file_name]);
                    $this->session->set_flashdata('success','Avatar has been successfully changed.');
                    redirect('dashboard/edit_profile');
                }else{
                   // $this->session->set_flashdata('error','Something went wrong. Please try again.');
                    $this->session->set_flashdata('error',$res['msg']);
                    redirect('dashboard/edit_profile');
                }
            }

            if($tab == 'payment_method'){                
                $default_payment = $this->input->post('default_payment');                
                $this->Users_model->update_user_data($user_id,['default_payment'=>$default_payment]);
                $this->session->set_flashdata('success','Payment method has been successfully changed.');
                redirect('dashboard/edit_profile?tab=payment_method');
            }
        }
    } // END of function edit_profile

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
            $str = 'https://maps.googleapis.com/maps/api/geocode/json?key='.GOOGLE_MAP_API.'&components=postal_code:'.$zipcode.'&sensor=false';
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
    public function view_profile($user_id,$rfp_id=''){

        $data['db_data'] = $this->Users_model->get_data(['id'=>decode($user_id)],true);
        // pr($data['db_data'],1);
        $data['review_data'] = $this->Rfp_model->get_user_rating(decode($user_id));
        $data['overall_review']=$this->Rfp_model->get_overall_rating(decode($user_id));
        $data['encoded_user_id'] = $user_id;

        $sess_data = $this->session->userdata('client');
        $sess_role_id = $sess_data['role_id'];

        if($sess_role_id == '4'){
            $data['allow_view'] = 1;
        }else{       
            // $patient_id = $this->session->userdata('client')['id'];
            $data['allow_view'] = $this->Rfp_model->check_if_user_view_profile(decode($user_id),decode($rfp_id));
        }        

        $data['tab'] = $this->input->get('tab');

        if(!empty($data['db_data']['office_map_data'])){
            $office_map_data = json_decode($data['db_data']['office_map_data'],true);
            
            $data['lat'] = $office_map_data['lat'];
            $data['lng'] = $office_map_data['lng'];

            $center_map_str =  $data['lat'].', '.$data['lng'];
            $data['get_address'] = $office_map_data['office_text'];

            $config['center'] = $center_map_str;
            $config['zoom'] = '16';
            $config['places'] = TRUE;
            $config['placesAutocompleteInputID'] = 'new_id';
            $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
            $config['placesAutocompleteOnChange'] = 'get_location()';
            $this->googlemaps->initialize($config);

            // ------------------------------------------------------------------------
            $description = str_replace(array("\r","\n"),"",nl2br($data['db_data']['office_description']));

            $marker = array();
            $marker['position'] = $center_map_str; 
            $marker['infowindow_content'] = html_entity_decode($description);

            $this->googlemaps->add_marker($marker);
            
            $data['map'] = $this->googlemaps->create_map();        
            $data['latlong_location'] = $center_map_str;

            // ------------------------------------------------------------------------
        }

        // pr($data['db_data'],1);

        $data['subview']="front/profile/view_profile";
        $this->load->view('front/layouts/layout_main',$data);
    }

    /* @DHK Refund Payment Request
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

    /* 
    * For Doctor Submit the Thank you note on particular review
    */
    public function thankyou_note(){

        if($this->input->post('submit')){

            $doc_id = $this->session->userdata('client')['id'];
            $rfp_rating_id = $this->input->post('rfp_rating_id');
            $rfp_rating_data = $this->Rfp_model->get_result('rfp_rating',['id'=>$rfp_rating_id],true);
            $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_rating_data['rfp_id']],true);            
            $link = 'dashboard/view_profile/'.encode($doc_id).'/'.encode($rfp_rating_data['rfp_id']);
            // ------------------------------------------------------------------------
            $noti_data = [
                        'from_id'=>$this->session->userdata('client')['id'],
                        'to_id'=>$rfp_data['patient_id'],
                        'rfp_id' => $rfp_rating_data['rfp_id'],
                        'noti_type'=>'doc_thank_you',
                        'noti_msg'=>'Doctor write thank you note on your review for <b>'.$rfp_data['title'].'</b>',
                        'noti_url'=>$link
                    ];
            $this->Notification_model->insert_rfp_notification($noti_data);
            // ------------------------------------------------------------------------

            $review_data = [
                          'doctor_comment'  => $this->input->post('doctor_comment'), 
                        ];
            $res=$this->Rfp_model->update_record('rfp_rating',['id' => $this->input->post('rfp_rating_id')],$review_data);
            if($res){
                $this->session->set_flashdata('success','Thank You Note Successfully Submitted');
            }else{
                $this->session->set_flashdata('error','Error Into Submit Thank You Note');
            }
        }
        redirect('dashboard');
    }

    /* 
    * Manage Call Appointment
    */  
    public function call_appointment(){

        if($this->input->post('submit')){

            $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$this->input->post('rfp_id')],true); // fetch RFP data

            // if appointment_id is null then add new appointment otherwise edit the appointment 
            if($this->input->post('appointment_id') == '')
            {    
                $appointment_data = [
                              'rfp_id'              => $this->input->post('rfp_id'), 
                              'doc_id'              => $this->session->userdata('client')['id'], 
                              'doc_comments'        => $this->input->post('doc_comments'),
                              'appointment_type'    => 1, // (1) It means call appointment type
                              'created_at'          => date("Y-m-d H:i:s"),
                            ];
                $res=$this->Rfp_model->insert_record('appointments',$appointment_data);
                $app_id = $this->db->insert_id();

            }
            else
            {
                $app_id = $this->input->post('appointment_id');
                $appointment_data = [
                            'doc_comments'        => $this->input->post('doc_comments'), 
                            'appointment_type'    => 1,
                            ];
                $res=$this->Rfp_model->update_record('appointments',['id' => $app_id],$appointment_data);
                 
                // IF successfully update then delete all schedule data from appointment schedule table
                if($res){
                    $this->Rfp_model->delete_record('appointment_schedule',['appointment_id' => $app_id]);
                }
            }
            
            if($res){
                //------------ Update RFP Status ------------
                $where = ['id' => $this->input->post('rfp_id')];
                $data_array = ['status' => 6]; // For chnage status 5 to 6 (Appointment Pending to Service InProgress)
                $res=$this->Rfp_model->update_record('rfp',$where,$data_array);
                //------------- End Update RFP Status ------
            }
            // ------------------------------------------------------------------------
            $noti_data = [
                            'from_id'=>$this->session->userdata('client')['id'],
                            'to_id'=>$rfp_data['patient_id'],
                            'rfp_id' => $rfp_data['id'],
                            'noti_type'=>'doc_confirm_by_call',
                            'noti_msg'=>'Appointment has been confirmed by the doctor based on call for <b>'.$rfp_data['title'].'</b>',
                            'noti_url'=>'dashboard?view_appointment='.encode($rfp_data['id'])
                        ];
            $this->Notification_model->insert_rfp_notification($noti_data);

            // ------------------------------------------------------------------------

            if($res){
                //---- Insert Data into Appointment schedule table ------
                $date= explode('-',$this->input->post('appointment_date'));
                $appointment_date= $date[2]."-".$date[0]."-".$date[1];

                $time = explode(':',$this->input->post('appointment_time'));
                $appointment_time = trim($time[0]).':'.trim($time[1]).':00';

                $schedule_data = [
                               'appointment_id'     =>  $app_id,
                               'appointment_date'   =>  $appointment_date,
                               'appointment_time'   =>  $appointment_time,
                               'is_selected'        =>  1,
                            ];

                $this->db->insert('appointment_schedule',$schedule_data);
                //-----------------------------------------------------------
                $this->session->set_flashdata('success','Appointment Successfully Submitted');
            }
            else{
                $this->session->set_flashdata('error','Error Into Submit Appointment');
            }            
        }   
        redirect('dashboard'); 
    }

    /* 
    * Manage Doctor Appointment Manual (3 time schedule option)
    */  
    public function manage_appointment(){

        if($this->input->post('submit')){

            $noti_msg = '';
            $rfp_id = $this->input->post('rfp_id');
            $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_id],true); // fetch RFP data

            // if appointment_id is null then add new appointment otherwise edit the appointment 
            if($this->input->post('appointment_id') == '') {
                $appointment_data = [
                          'rfp_id'  => $this->input->post('rfp_id'), 
                          'doc_id'  => $this->session->userdata('client')['id'], 
                          'doc_comments'  => $this->input->post('doc_comments'), 
                          'created_at'  => date("Y-m-d H:i:s"),
                        ];

                $res=$this->Rfp_model->insert_record('appointments',$appointment_data);

                $noti_msg = 'Appointment has been created by the doctor for <b>'.$rfp_data['title'].'</b>';

                $app_id = $this->db->insert_id();
            } else {
                $app_id = $this->input->post('appointment_id');
                $appointment_data = [
                          'doc_comments'  => $this->input->post('doc_comments'), 
                        ];
                $res=$this->Rfp_model->update_record('appointments',['id' => $app_id],$appointment_data);
                
                $noti_msg = 'Appointment has been updated by the doctor for <b>'.$rfp_data['title'].'</b>';

                // IF successfully update then delete all schedule data from appointment schedule table
                if($res){
                    $this->Rfp_model->delete_record('appointment_schedule',['appointment_id' => $app_id]);
                }
            }

            // ------------------------------------------------------------------------
            $noti_data = [
                            'from_id'=>$this->session->userdata('client')['id'],
                            'to_id'=>$rfp_data['patient_id'],
                            'rfp_id' => $rfp_data['id'],
                            'noti_type'=>'doc_appointment_create',
                            'noti_msg'=>$noti_msg,
                            'noti_url'=>'dashboard?view_appointment='.encode($rfp_data['id'])
                        ];
            $this->Notification_model->insert_rfp_notification($noti_data);
            // ------------------------------------------------------------------------
            
            if($res){
                $schedule_data='';
                $i=0;
                //------------ For Insert Data into appointment schedule table---------------
                $app_date = $this->input->post('appointment_date');
                $app_time = $this->input->post('appointment_time');            
                foreach($app_date as $key=>$data){
                    if($app_date[$key] != '' && $app_time[$key] != ''){

                        $date= explode('-',$app_date[$key]);
                        $appointment_date= $date[2]."-".$date[0]."-".$date[1];

                        $time = explode(':',$app_time[$key]);
                        $appointment_time = trim($time[0]).':'.trim($time[1]).' '.trim($time[2]);
                       
                        $schedule_data[$i]['appointment_id'] = $app_id;
                        $schedule_data[$i]['appointment_date'] = $appointment_date;
                        $schedule_data[$i]['appointment_time'] = date("H:i", strtotime($appointment_time));
                        $i++;
                    }
                }
                
                if($schedule_data != ''){
                    $this->db->insert_batch('appointment_schedule',$schedule_data);
                }
                //-----------------End For Insert Data into appointment schedule table----------

                $this->session->set_flashdata('success','Appointment Successfully Submitted');
            }else{
                $this->session->set_flashdata('error','Error Into Submit Appointment');
            }
        }
        redirect('dashboard');
    }

    /*
    * Choose a particular schedule by patient (Patient Dashboard)
    */
    public function choose_appointment_schedule(){
        
        // pr($_POST,1);
        $rfp_id = $this->input->post('rfp_id');
        $doctor_id = $this->input->post('doctor_id');
        $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$rfp_id],true); // fetch RFP data
        // ------------------------------------------------------------------------
        $noti_data = [
                        'from_id'=>$this->session->userdata('client')['id'],
                        'to_id'=>$doctor_id,
                        'rfp_id' => $rfp_id,
                        'noti_type'=>'patient_appointment_confirm',
                        'noti_msg'=>'Appointment has been confirmed by the patient for <b>'.$rfp_data['title'].'</b>',
                        'noti_url'=>'dashboard?tab=appointment&schedule_rfp='.encode($rfp_id)
                    ];
        $this->Notification_model->insert_rfp_notification($noti_data);
        // ------------------------------------------------------------------------

        $where = ['id' => $this->input->post('schedule_selected')];
        $data_array = ['is_selected' => 1];
        $res=$this->Rfp_model->update_record('appointment_schedule',$where,$data_array);

        //------------ Update RFP Status ------------
        $where = ['id' => $rfp_id];
        $data_array = ['status' => 6]; // For chnage status 5 to 6 (Appointment Pending to Service InProgress)
        $res=$this->Rfp_model->update_record('rfp',$where,$data_array);
        //------------- End Update RFP Status ------
        if($res)  {
            $this->session->set_flashdata('success','Appointment Selected Successfully');
        }else{
            $this->session->set_flashdata('error','Error Into Select Appointment');
        }
        redirect('dashboard');
    }

    /*
    * Delete Appointment
    */
    public function delete_appointment($app_id){

        $appointment_id = decode($app_id);
        $appointment_data = $this->Rfp_model->get_result('appointments',['id'=>$appointment_id],true);                
        $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$appointment_data['rfp_id']],true); // fetch RFP data

        // ------------------------------------------------------------------------
        $noti_data = [
                        'from_id'=>$this->session->userdata('client')['id'],
                        'to_id'=>$rfp_data['patient_id'],
                        'rfp_id' => $rfp_data['id'],
                        'noti_type'=>'doc_appointment_delete',
                        'noti_msg'=>'Appointment has been canceled by the doctor for <b>'.$rfp_data['title'].'</b>',
                        'noti_url'=>'dashboard'
                    ];
        $this->Notification_model->insert_rfp_notification($noti_data);
        // ------------------------------------------------------------------------

        //$res=$this->Rfp_model->delete_record('appointment_schedule',['appointment_id' => $appointment_id]);
        $res=$this->Rfp_model->delete_record('appointments',['id' => $appointment_id]);
        if($res)  {
            //------------ Update RFP Status ------------
            $where = ['id' => $appointment_data['rfp_id']];
            $data_array = ['status' => 5]; // For chnage status 6 to 5 (Service InProgress to Appointment Pending)
            $res=$this->Rfp_model->update_record('rfp',$where,$data_array);
            //------------- End Update RFP Status ------
            $this->session->set_flashdata('success','Appointment Deleted Successfully');
        }else{
            $this->session->set_flashdata('error','Error Into Delete Appointment');
        }
        redirect('dashboard');
    }

     /*
    * Reschedule Appointment
    */
    public function reschedule_appointment($app_id){

        $appointment_id = decode($app_id);
        $appointment_data = $this->Rfp_model->get_result('appointments',['id'=>$appointment_id],true);                
        $rfp_data = $this->Rfp_model->get_result('rfp',['id'=>$appointment_data['rfp_id']],true); // fetch RFP data

        // ------------------------------------------------------------------------
        $noti_data = [
                        'from_id'=>$this->session->userdata('client')['id'],
                        'to_id'=>$rfp_data['patient_id'],
                        'rfp_id' => $rfp_data['id'],
                        'noti_type'=>'doc_appointment_delete',
                        'noti_msg'=>'Appointment has been rescheduled by the doctor for <b>'.$rfp_data['title'].'</b>',
                        'noti_url'=>'dashboard'
                    ];
        $this->Notification_model->insert_rfp_notification($noti_data);
        // ------------------------------------------------------------------------

        //$res=$this->Rfp_model->delete_record('appointment_schedule',['appointment_id' => $appointment_id]);
        $res=$this->Rfp_model->delete_record('appointments',['id' => $appointment_id]);
        if($res)  {
            //------------ Update RFP Status ------------
            $where = ['id' => $rfp_data['id']];
            $data_array = ['status' => 5]; // For chnage status 6 to 5 (Service InProgress to Appointment Pending)
            $res=$this->Rfp_model->update_record('rfp',$where,$data_array);
            //------------- End Update RFP Status ------
            $this->session->set_flashdata('success','Appointment Rescheduled Successfully');
        }else{
            $this->session->set_flashdata('error','Error Into Reschedule Appointment');
        }
        redirect('dashboard?schedule_rfp='.encode($rfp_data['id']));
    }

    /*
    *   Change Filter Notification Status (Doctor Dashboard)
    */
    public function change_filter_notify_status(){

        //-------------- For add particular date ----------------
        if($this->input->post('notification_status') == 0){
            $filter_cron_date=null;
        }
        else if($this->input->post('notification_status') == 1){
            $filter_cron_date = date("Y-m-d", strtotime("+ 1 day"));
        }
        else if($this->input->post('notification_status') == 2){
            $filter_cron_date = date("Y-m-d", strtotime("+ 7 day"));
        }
        else if($this->input->post('notification_status') == 3){
            $filter_cron_date = date("Y-m-d", strtotime("+ 15 day"));
        }
        //-------------- For add particular date ----------------

        $where=['id' => $this->input->post('filter_id')];
        $data_array=['notification_status'  => $this->input->post('notification_status') , 'filter_cron_date' => $filter_cron_date];
        $res=$this->Rfp_model->update_record('custom_search_filter',$where,$data_array);
        echo $res;
    }

    /*
    *   Delete Search Filter (Doctor Dashboard)
    */
    public function delete_search_filter(){

        $where=['id' => $this->input->post('filter_id')];
        $res=$this->Rfp_model->delete_record('custom_search_filter',$where);
        echo $res;
    }

    // ------------------------------------------------------------------------

    public function save_map_address(){

        $u_data = $this->session->userdata('client');
        
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $office_text = $this->input->post('office_text');

        $ret_json['lat'] = $lat;
        $ret_json['lng'] = $lng;
        $ret_json['office_text'] = $office_text;

        $json_str = json_encode($ret_json);
        $this->Rfp_model->update_record('users',['id'=>$u_data['id']],['office_map_data'=>$json_str]);
        
        echo json_encode(['success'=>'success']);
        
    }

    // ------------------------------------------------------------------------

}
