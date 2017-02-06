<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model(['Rfp_model']);
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

    public function admin_action_rfp(){

    }

}
