<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotional_code extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Promotional_code_model']);
       
    }

    /**
     * Function load view of Promotional Code list.
     */
    public function index() {

        $data['subview'] = 'admin/promotional_code/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Promotional Code list page
     */
    public function list_promotionalcode() {

        $final['recordsTotal'] = $this->Promotional_code_model->get_promotionalcode_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Promotional_code_model->get_all_promotionalcode();
        echo json_encode($final);
        

    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $code_id) {

        $where = 'id = ' . decode($this->db->escape($code_id));
        $check_code = $this->Promotional_code_model->get_result('promotional_code', $where);
        if ($check_code) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Promotional Code successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Promotional Code successfully blocked!','class'=>'success']);
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message',['message'=>'Promotional Code successfully unblocked!','class'=>'success']);
            }
            $this->Promotional_code_model->update_record('promotional_code', $where, $update_array);
        } else {
            $this->session->set_flashdata('message',['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect('admin/promotional_code');
    }

    /**
     *  Load view for Edit Promotional Code
     * */
    public function edit() {

        $code_id = decode($this->uri->segment(4));
        if (is_numeric($code_id)) {
            $where = 'id = ' . $this->db->escape($code_id);
            $check_code = $this->Promotional_code_model->get_result('promotional_code', $where);
            if ($check_code) {
                $data['record'] = $check_code[0];
                $data['title'] = 'Admin Edit Promotional Code';
                $data['heading'] = 'Edit Promotional Code';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {
            $date=explode("-",$this->input->post('code_date'));
            $start_date=date("Y-m-d",strtotime($date[0]));
            $end_date=date("Y-m-d",strtotime($date[1]));
             $update_array = [
                'title'           => $this->input->post('title'),
                'code'            => $this->input->post('code'),
                'start_date'      => $start_date,
                'end_date'        => $end_date,
                'discount'        => $this->input->post('discount'),
                'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Promotional_code_model->update_record('promotional_code', $where, $update_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Promotional Code successfully updated!','class'=>'success']);
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Update Promotional Code!','class'=>'danger']);
            }               
            redirect('admin/promotional_code');
            
        }
        $data['subview'] = 'admin/promotional_code/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

     /**
     * Load view for Add Promotional Code 
     * */

     public function add() {

         $data['title'] = 'Admin Add Promotional Code';
         $data['heading'] = 'Add Promotional Code';
         if ($this->input->post()) {
            $date=explode("-",$this->input->post('code_date'));
            $start_date=date("Y-m-d",strtotime($date[0]));
            $end_date=date("Y-m-d",strtotime($date[1]));
            $insert_array = [
                'title'         => $this->input->post('title'),
                'code'          => $this->input->post('code'),
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'discount'      => $this->input->post('discount'),
                'created_at'    => date("Y-m-d H:i:s a"),
                'is_blocked'    => $this->input->post('is_blocked'),
            ];

            $result=$this->Promotional_code_model->insert_record('promotional_code',$insert_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Promotional Code successfully Inserted!','class'=>'success']);
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Insert Promotional Code!','class'=>'danger']);
            }       
            redirect('admin/promotional_code');
        }
        $data['subview'] = 'admin/promotional_code/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Promotional Code Already Exist or Not
     * */
    public function check_promotional_code_exists($id = 0,$field){
        if (array_key_exists($field, $_POST)) {
            $where = $field." = '".$this->input->post($field)."'";
            if ($this->Promotional_code_model->CheckExist($where, $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

}
