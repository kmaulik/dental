<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_inquiry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['admin/Admin_contact_inquiry_model']);
        $this->load->library(['encryption', 'upload']);
        check_admin_login();
    }

    /**
     * Function load view of Contact Inquiry list.
     */
    public function index() {

        $data['subview'] = 'admin/contact_inquiry/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Contact Inquiry list page
     */
    public function list_inquiry() {
        $final['recordsTotal'] = $this->Admin_contact_inquiry_model->get_inquiry_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_contact_inquiry_model->get_all_inquiry();
        echo json_encode($final);
    }

    /**
     * Function is used to perform action (Delete)
     */
    public function action($action, $inquiry_id) {

        $where = 'id = ' . decode($this->db->escape($inquiry_id));
        $check_inquiry = $this->Admin_contact_inquiry_model->get_result('contact_inquiry', $where);
        if ($check_inquiry) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Contact Inquiry successfully deleted!','class'=>'success']);
            }
            $this->Admin_contact_inquiry_model->update_record('contact_inquiry', $where, $update_array);
        } else {
           $this->session->set_flashdata('message',['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/contact_inquiry'));
    }

     /**
     * Function is used to perform Fetch Inquiry Data Using Ajax
     */
     public function fetch_inquiry_data(){
        $where = 'id = ' . $this->db->escape($this->input->post('id'));
        $data=$this->Admin_contact_inquiry_model->get_result('contact_inquiry', $where);
        echo json_encode($data[0]);
    }

     /**
     * Function is used to perform Send Mail & Update Status
     */
    public function reply(){
        //------ For Email Template -----------
        /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
        $html_content=mailer('contact_inquiry','AccountActivation'); 
        $username= $this->input->post('name');
        $html_content = str_replace("@USERNAME@",$username,$html_content);
        $html_content = str_replace("@MESSAGE@",$this->input->post('message'),$html_content);
        //--------------------------------------

        $email_config = mail_config();
        $this->email->initialize($email_config);
        $subject=config('site_name').' - Contact Inquiry Reply';
        $this->email->from(config('contact_email'), config('sender_name'))
                    ->to($this->input->post('email'))
                    ->subject($subject)
                    ->message($html_content);

        if($this->email->send()){
            $where = 'id = ' . $this->db->escape($this->input->post('id'));
            $update_array = array(
                'status' => 1
                );
            $this->Admin_contact_inquiry_model->update_record('contact_inquiry', $where, $update_array);
            $this->session->set_flashdata('message',['message'=>'Replied to Contact Inquiry successfully !','class'=>'success']);
        }else{
            $this->session->set_flashdata('message',['message'=>'Error Into Contact Inquiry Reply.Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/contact_inquiry'));
    }



}
