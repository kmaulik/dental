<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Email_template_model']);
        check_admin_login();
    }

    /**
     * Function load view of Email Template list.
     */
    public function index() {
     
        $data['subview'] = 'admin/email_template/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Email Template page
     */
    public function list_email() {
     
        $final['recordsTotal'] = $this->Email_template_model->get_email_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Email_template_model->get_all_emails();
        echo json_encode($final);
        

    }

    /**
     *  Load view for Edit Email Template 
     * */
    public function edit() {
        
        $email_id = decode($this->uri->segment(4));
        if (is_numeric($email_id)) {
            $where = 'id = ' . $this->db->escape($email_id);
            $check_email = $this->Email_template_model->get_result('email_template', $where);
            if ($check_email) {
                $data['record'] = $check_email[0];
                $data['title'] = 'Admin edit email template';
                $data['heading'] = 'Edit email template';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {
            $update_array = [
                'title'        => $this->input->post('title'),
                'description'  => $this->input->post('description'),
            ];

            $result=$this->Email_template_model->update_record('email_template', $where, $update_array);
            if($result){
                 $this->session->set_flashdata('message', ['message'=>'Email Template successfully updated!','class'=>'success']);
            }
            else{
  
                 $this->session->set_flashdata('message', ['message'=>'Error Into Update Email Template!','class'=>'danger']);
            } 
                      
        redirect('admin/email_template');
    }
    $data['subview'] = 'admin/email_template/manage';
    $this->load->view('admin/layouts/layout_main', $data);
}

     /**
     * Load view for Add Email Template 
     * */

     public function add() {
        
       $data['title'] = 'Admin email template';
       $data['heading'] = 'Add email template';
       if ($this->input->post()) {
           
                $insert_array = [
                    'title'             => $this->input->post('title'),
                    'description'       => $this->input->post('description'),
                    'created_at'        => date("Y-m-d H:i:s a"),
                ];
                $result=$this->Email_template_model->insert_record('email_template',$insert_array);
                if($result){
                     $this->session->set_flashdata('message', ['message'=>'Email Template successfully Inserted!','class'=>'success']);
                }
                else{
                     $this->session->set_flashdata('message', ['message'=>'Error Into Insert Email Template!','class'=>'danger']);
                }       
            
            redirect('admin/email_template');
        }
        
        $data['subview'] = 'admin/email_template/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Email Template Title Already Exist or Not
     * */
    public function check_email_title_exists($id = 0){
        if (array_key_exists('title', $_POST)) {
            if ($this->Email_template_model->CheckExist($this->input->post('title'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

    /**
     * Fetch Default Email Template Using Template Id
     * */
    public function get_template_desc(){
        $where = 'id = ' . $this->input->post('template_id');
        $check_email = $this->Email_template_model->get_result('email_template', $where);
        if(isset($check_email[0])){
            echo $check_email[0]['default_description'];
        }
        echo false;
    }

}
