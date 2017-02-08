<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model(['Rfp_model','Notification_model','Users_model']);
        check_admin_login();
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
        $data['title'] = 'Admin View RFP';
        $data['heading'] = 'View RFP Page';  
        $data['rfp_id'] = decode($rfp_id);
        $data['record']=$this->Rfp_model->get_result('rfp',['id' => decode($rfp_id)],'1');
        //pr($data,1);
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
                $this->session->set_flashdata('message', ['message'=>'RFP successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'RFP successfully blocked!','class'=>'success']);
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message', ['message'=>'RFP successfully unblocked!','class'=>'success']);
            }
            $this->Rfp_model->update_record('rfp', $where, $update_array);
        } else {
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/rfp'));
    }

    public function choose_action($rfp_id){
        $rfp_id = decode($rfp_id);
        $data['rfp_id'] = $rfp_id;        
        $record = $this->Rfp_model->get_result('rfp',['id' => $rfp_id],'1');
        // pr($record,1);
        $user_data = $this->Users_model->check_if_user_exist(['id' => $record['patient_id']], false, true);        

        if(empty($rfp_id)){    show_404(); }

        if($_POST){
            $remarks = $this->input->post('remarks');
            $action = $this->input->post('action');
            $message = $this->input->post('message');            
            if($action == 'yes'){ $status='3'; }else{ $status='2'; }
            
            if(!empty($record['admin_remarks'])){
                $last_remark = json_decode($record['admin_remarks'],true);
                $last_cnt = $last_remark['attempt_no']+1;                
            }else{                
                $last_cnt = '1';
            }

            $admin_remarks =[
                                'attempt_no'=>$last_cnt,
                                'last_message'=>$message,
                                'last_remarks'=>$remarks
                            ];

            $admin_remarks_str = json_encode($admin_remarks);
            $this->Rfp_model->update_record('rfp',['id'=>$rfp_id],['status'=>$status,'admin_remarks'=>$admin_remarks_str]);
            // ------------------------------------------------------------------------
            $noti_data = [
                            'from_id'=>$this->session->userdata('admin')['id'],
                            'to_id'=>$record['patient_id'],
                            'rfp_id' => $rfp_id,
                            'noti_type'=>'admin_action',
                            'noti_msg'=>$message,
                            'noti_url'=>'rfp'
                        ];
            $this->Notification_model->insert_rfp_notification($noti_data);
            // ------------------------------------------------------------------------            
            //------ For Email Template -----------
            /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
            $html_content=mailer('contact_inquiry','AccountActivation'); 
            $username= $user_data['fname'].' '.$user_data['lname'];
            $html_content = str_replace("@USERNAME@",$username,$html_content);
            $html_content = str_replace("@MESSAGE@",$message,$html_content);            

            $email_config = mail_config();
            $this->email->initialize($email_config);
            $subject=config('site_name').' - Regarding your RFP -'.$record['title'];
            $this->email->from(config('contact_email'), config('sender_name'))
                    ->to($user_data['email_id'])
                    ->subject($subject)
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

        $data['subview'] = 'admin/rfp/choose_action';
        $this->load->view('admin/layouts/layout_main', $data);
    }

}
