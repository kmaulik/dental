<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Treatment_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Treatment_category_model']);
    }

    /**
     * Function load view of Treatment Category list.
     */
    public function index() {

        $data['subview'] = 'admin/treatment_category/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Treatment Category list page
     */
    public function list_treatment_category() {

        $final['recordsTotal'] = $this->Treatment_category_model->get_treatment_category_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Treatment_category_model->get_all_treatment_category();
        echo json_encode($final);
        

    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $cat_id) {

        $where = 'id = ' . decode($this->db->escape($cat_id));
        $check_cat = $this->Treatment_category_model->get_result('treatment_category', $where);
        if ($check_cat) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully blocked!','class'=>'success']);
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully unblocked!','class'=>'success']);
            }
            $this->Treatment_category_model->update_record('treatment_category', $where, $update_array);
        } else {
            $this->session->set_flashdata('message',['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect('admin/treatment_category');
    }

    /**
     *  Load view for Edit Treatment Category 
     * */
    public function edit() {

        $cat_id = decode($this->uri->segment(4));
        if (is_numeric($cat_id)) {
            $where = 'id = ' . $this->db->escape($cat_id);
            $check_cat = $this->Treatment_category_model->get_result('treatment_category', $where);
            if ($check_cat) {
                $data['record'] = $check_cat[0];
                $data['title'] = 'Admin Edit Treatment Category';
                $data['heading'] = 'Edit Treatment Category';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {

             $update_array = [
                'title'          => $this->input->post('title'),
                'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Treatment_category_model->update_record('treatment_category', $where, $update_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully updated!','class'=>'success']);
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Update Treatment Category!','class'=>'danger']);
            }               
            redirect('admin/treatment_category');
            
        }
        $data['subview'] = 'admin/treatment_category/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

     /**
     * Load view for Add Treatment Category 
     * */

     public function add() {

         $data['title'] = 'Admin Add Treatment Category';
         $data['heading'] = 'Add Treatment Category';
         if ($this->input->post()) {

            $insert_array = [
            'title'          => $this->input->post('title'),
            'created_at'     => date("Y-m-d H:i:s a"),
            'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Treatment_category_model->insert_record('treatment_category',$insert_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully Inserted!','class'=>'success']);
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Insert Treatment Category!','class'=>'danger']);
            }       
            redirect('admin/treatment_category');
        }
        $data['subview'] = 'admin/treatment_category/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Treatment Category Title Already Exist or Not
     * */
    public function check_cat_title_exists($id = 0){
        if (array_key_exists('title', $_POST)) {
            if ($this->Treatment_category_model->CheckExist($this->input->post('title'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

}
