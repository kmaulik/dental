<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refund extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_admin_login();
        $this->load->model(['Refund_model']);
    }

    /**
     * Function load view of refund list.
     */
    public function index() {
       
        $data['subview'] = 'admin/payment/refund';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in refund list page
     */
    public function list_refund() {
     
        $final['recordsTotal'] = $this->Refund_model->get_refund_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Refund_model->get_all_refund();
        echo json_encode($final);
        

    }

     /**
     * Function is used to fetch refund data usinf refund id
     */
    public function fetch_refund_data(){
        $data=$this->Refund_model->fetch_refund_data($this->input->post('id'));
        echo json_encode($data);
    }

    /*
    *   Function for change refund status
    */
    public function change_status(){

        /* ----------- Refund Process Here using Paypal----- */

        /* ------------------End Refund Process ------------- */ 
        
        $where = ['id' => $this->input->post('id')];
        $data = ['status' => $this->input->post('refund_status')];
        $res=$this->Refund_model->update_record('refund',$where,$data);
        if($res){
            $this->session->set_flashdata('message', ['message'=>'Refund Status Updated Successfully','class'=>'success']);
        }else{
            $this->session->set_flashdata('message', ['message'=>'Error Into Update Refund Status','class'=>'danger']);
        }
        redirect('admin/refund');
    }

}
