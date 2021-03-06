<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model(['Rfp_model','Notification_model','Users_model']);
        check_admin_login();
        // pr($this->session->userdata('admin'));
    }

    /**
     * Function load view of rfp list.
     */
    public function index() {
        $data['subview'] = 'admin/rfp/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in rfp list page
     */
    public function list_rfp() {
        $final['recordsTotal'] = $this->Rfp_model->get_rfp_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Rfp_model->get_all_rfp();
        echo json_encode($final);
    }

    /**
     * Function is used to view specific data 
    */
    public function view($rfp_id){

        $data['title'] = 'Admin View Request';
        $data['heading'] = 'View Request Page';  
        $data['rfp_id'] = decode($rfp_id);

        $data['record']=$this->Rfp_model->get_result('rfp',['id' => decode($rfp_id)],'1');
        // pr($data['record'],1);
        $data['subview'] = 'admin/rfp/view';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $rfp_id) {

        $where = 'id = ' . decode($this->db->escape($rfp_id));
        $check_data = $this->Rfp_model->get_result('rfp', $where);
        if ($check_data) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Request successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Request successfully blocked!','class'=>'success']);
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message', ['message'=>'Request successfully unblocked!','class'=>'success']);
            }
            $this->Rfp_model->update_record('rfp', $where, $update_array);
        } else {
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/rfp'));
    }

    public function choose_action($rfp_id){
        $encode_rfp_id = $rfp_id;

        $rfp_id = decode($rfp_id);
        $data['rfp_id'] = $rfp_id;        
        $record = $this->Rfp_model->get_result('rfp',['id' => $rfp_id],'1');

        $user_data = $this->Users_model->check_if_user_exist(['id' => $record['patient_id']], false, true);
        if(empty($rfp_id)){ show_404(); }

        if($_POST){

            $last_remark = json_decode($record['admin_remarks'],true);
            
            $remarks = $this->input->post('remarks');
            $action = $this->input->post('action');
            $message = $this->input->post('message');
            $msg = '';
            //------ For Extend the RFP Date ------
            $rfp_approve_date = NULL;
            $rfp_valid_date = NULL;
            //-------------------------------------
            
            if($action == 'yes'){
                
                $status='3'; 
                $rfp_approve_date = date('Y-m-d');
                $rfp_valid_date = date('Y-m-d', strtotime("+13 days"));
                $noti_msg = '<b>'.$record['title'].'</b> has been successfully approved and it is live.';
                $noti_url = 'rfp/view_rfp/'.encode($rfp_id);
                
                $subject_mail = config('site_name').' - Your "'.$record['title'].'" quote request has been published!';
              

                $msg = "Your '".$record['title']."' quote request has been published for dental professionals to review and submit their quotes. Once we receive a quote for you to review, we will notify you.<br><br>";
                $msg .= "Please <a href='".base_url()."".$noti_url."'>click here</a> to frequently check your dental plan offers or simply login to your account.<br><br>";
                $msg .= $message.'<br><br>';
                $msg .= "You may review and select your preferred dental plan at any given time. You may also opt to extend the period your quote request is open for more dental plan quotes to be submitted.<br><br>";
            }else{ 

                $status='2';
                $noti_msg = '<b>'.$record['title'].'</b> was denied.For know the reason check your mail.';
                $noti_url = 'rfp/edit/'.encode($rfp_id).'/3';

                $subject_mail = config('site_name').' - Additional information requested regarding your "'.$record['title'].'" quote request';
                
                $msg = "We have reviewed your quote request and need additional information from you to process your request.<br><br>";
                $msg .= "<a href='".base_url()."".$noti_url."'>Click here</a> to update your quote request with the following information:<br><br>";
                $msg .=  $message.'<br><br>';
                $msg .= "Once your information has been updated, we will review your request again and provide dental plan options for you to select.<br><br>";
                $msg .= "If you have any questions in regards to this request, please fill out our <a href='".base_url('contact_us')."'>Contact Us form</a>.<br><br>";
            }

            if(!empty($record['admin_remarks'])){
                $last_remark = json_decode($record['admin_remarks'],true);
                $last_cnt = count($last_remark)+1;
            }else{
                $last_cnt = '1';
            }

            $admin_remarks =[
                                'attempt_no'=>$last_cnt,
                                'last_message'=>$this->input->post('message'),
                                'last_remarks'=>$remarks,
                                'last_action_by'=>$this->session->userdata('admin')['email_id'],
                                'last_action'=>date('Y-m-d H:i:s')
                            ];

            if(!empty($last_remark)){
                $arr_remark[] =$admin_remarks;
                $final_remark = array_merge($last_remark,$arr_remark);
            }else{
                $final_remark[] =$admin_remarks;
            }

            $admin_remarks_str = json_encode($final_remark);
            $this->Rfp_model->update_record('rfp',['id'=>$rfp_id],['status'=>$status,'admin_remarks'=>$admin_remarks_str,'rfp_approve_date'=>$rfp_approve_date,'rfp_valid_date' => $rfp_valid_date]);
            
            // ------------------------------------------------------------------------
            $noti_data = [
                            'from_id'=>$this->session->userdata('admin')['id'],
                            'to_id'=>$record['patient_id'],
                            'rfp_id' => $rfp_id,
                            'noti_type'=>'admin_action',
                            'noti_msg'=>$noti_msg,
                            'noti_url'=>$noti_url
                        ];
            $this->Notification_model->insert_rfp_notification($noti_data);
            // ------------------------------------------------------------------------

            //------ For Email Template -----------
            /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
            $html_content=mailer('contact_inquiry','AccountActivation');
            $username= $user_data['fname'].' '.$user_data['lname'];
            $html_content = str_replace("@USERNAME@",$username,$html_content);
            $html_content = str_replace("@MESSAGE@",$msg,$html_content);            

            $email_config = mail_config();
            $this->email->initialize($email_config);
            //$subject=config('site_name').' - Regarding your Request -'.$record['title'];
            $this->email->from(config('contact_email'), config('sender_name'))
                    ->to($user_data['email_id'])
                    ->subject($subject_mail)
                    ->message($html_content);

            if($this->email->send() == false){
                $this->session->set_flashdata('message', ['message'=>'Something is wrong with email send. Please try again.',
                                                          'class'=>'danger']);
                redirect('admin/rfp');
            }
            // ------------------------------------------------------------------------
            $this->session->set_flashdata('message', ['message'=>'Action successfully completed','class'=>'success']);
            redirect('admin/rfp');
        }
        // $data['subview'] = 'admin/rfp/choose_action';
        // $this->load->view('admin/layouts/layout_main', $data);
    }

    //--------------- Fetch Pre Drafted Text based on RFP Action using Ajax -----------
    public function fetch_pre_drafted_text(){
        $data = config($this->input->post('key'));
        echo $data;
    }


    public function move_to_private(){

        $rfp_id = $this->input->post('rfp_id');
        $rfp_data = $this->db->get_where('rfp',['id'=>$rfp_id])->row_array();
        // pr($rfp_data,1);
        $rfp_images = $this->input->post('rfp_images');

        if(!empty($rfp_images)){


            $private_img_path_arr = [];
            $private_img_path = $rfp_data['private_img_path'];

            if(!empty($private_img_path)){
                $private_img_path_arr = explode('|',$private_img_path);                
            }
            $new_res_arr = array_merge($private_img_path_arr,$rfp_images);

            // ------------------------------------------------------------------------
            $public_img_path_arr = [];
            $public_img_path = $rfp_data['img_path'];
            if(!empty($public_img_path)){
                $public_img_path_arr = explode('|',$public_img_path);
            }
            // ------------------------------------------------------------------------

            $diff_arr = array_diff($public_img_path_arr, $new_res_arr);
            $public_img_str = '';
            if(!empty($diff_arr)){
                $public_img_str = implode('|', $diff_arr);
            }

            $rfp_images_str = '';
            if(!empty($new_res_arr)){
                $rfp_images_str = implode('|', $new_res_arr);
            }

            $this->db->update('rfp',['private_img_path'=>$rfp_images_str,'img_path'=>$public_img_str], array('id' => $rfp_id));
            $this->session->set_flashdata('message', ['message'=>'Images status has been saved to private.','class'=>'success']);
            redirect('admin/rfp/view/'.encode($rfp_id));
        }
        else{
            redirect('admin/rfp/view/'.encode($rfp_id));
        }
    }

    public function move_to_public(){
        $rfp_id = $this->input->post('rfp_id');
        $rfp_data = $this->db->get_where('rfp',['id'=>$rfp_id])->row_array();
        // pr($rfp_data,1);
        $rfp_images = $this->input->post('rfp_images');   

        // pr($rfp_images,1);

        if(!empty($rfp_images)){
            
            $public_img_path_arr = [];
            $public_img_path = $rfp_data['img_path'];

            if(!empty($public_img_path)){
                $public_img_path_arr = explode('|',$public_img_path);
            }
            $new_res_arr = array_merge($public_img_path_arr,$rfp_images);

            // ------------------------------------------------------------------------
            $private_img_path_arr = [];
            $private_img_path = $rfp_data['private_img_path'];
            if(!empty($private_img_path)){
                $private_img_path_arr = explode('|',$private_img_path);
            }
            // -----------------------------------------------------------------------

            $diff_arr = array_diff($private_img_path_arr, $new_res_arr);
            $private_img_str = '';
            if(!empty($diff_arr)){
                $private_img_str = implode('|', $diff_arr);
            }

            $rfp_images_str = '';
            if(!empty($new_res_arr)){
                $rfp_images_str = implode('|', $new_res_arr);
            }

            $this->db->update('rfp',['private_img_path'=>$private_img_str,'img_path'=>$rfp_images_str], array('id' => $rfp_id));
            $this->session->set_flashdata('message', ['message'=>'Images status has been saved to private.','class'=>'success']);
            redirect('admin/rfp/view/'.encode($rfp_id));

        }else{
            redirect('admin/rfp/view/'.encode($rfp_id));
        }

        // pr($rfp_images,1);
    }
     

}
