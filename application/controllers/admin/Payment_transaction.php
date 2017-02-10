<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_transaction extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_admin_login();
        $this->load->model(['Payment_transaction_model']);
    }

    /**
     * Function load view of transaction list.
     */
    public function index() {
        //------- For Date picker range -----------
        if($this->input->post('date_search') != ''){
            $date= explode(" - ",$this->input->post('date_filter'));
            $this->session->set_userdata('date_filter',array(
                'from_date' => trim($date[0]),
                'to_date'   => trim($date[1]),
            ));
        }else{
            $this->session->unset_userdata('date_filter');
        }
        
      
        //------- End Date picker range -----------

        $data['subview'] = 'admin/payment/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in transaction list page
     */
    public function list_transaction() {
     
        $final['recordsTotal'] = $this->Payment_transaction_model->get_transaction_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Payment_transaction_model->get_all_transaction();
        echo json_encode($final);
        

    }


}
