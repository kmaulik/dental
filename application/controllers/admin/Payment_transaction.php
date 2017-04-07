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
    public function paypal_transaction() {
        //------- For Date picker range -----------
        if($this->input->post('date_search') != ''){
            $date= explode(" - ",$this->input->post('date_filter'));
            $search_data = $this->input->post('filter_search');
            $this->session->set_userdata('date_filter',array(
                'from_date' => trim($date[0]),
                'to_date'   => trim($date[1]),
                'filter_data' => $search_data,
            ));
        }else{
            $this->session->unset_userdata('date_filter');
        }
        
      
        //------- End Date picker range -----------

        $data['subview'] = 'admin/payment/paypal_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in transaction list page
     */
    public function list_paypal_transaction() {
     
        $final['recordsTotal'] = $this->Payment_transaction_model->get_paypal_transaction_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Payment_transaction_model->get_all_paypal_transaction();
        echo json_encode($final);
    }


    public function manual_transaction() {
        //------- For Date picker range -----------
        if($this->input->post('date_search') != ''){
            $date= explode(" - ",$this->input->post('date_filter'));
            $search_data = $this->input->post('filter_search');
            $this->session->set_userdata('date_filter',array(
                'from_date' => trim($date[0]),
                'to_date'   => trim($date[1]),
                'filter_data' => $search_data,
            ));
        }else{
            $this->session->unset_userdata('date_filter');
        }
              
        //------- End Date picker range -----------
        $data['subview'] = 'admin/payment/manual_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in transaction list page
     */
    public function list_manual_transaction() {
     
        $final['recordsTotal'] = $this->Payment_transaction_model->get_manual_transaction_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Payment_transaction_model->get_all_manual_transaction();
        echo json_encode($final);
    }


     /**
     * Function is used to perform manual payment action (Confirm)
     */
    public function manual_action($action, $transaction_id) {

        $where = 'id = ' . decode($this->db->escape($transaction_id));
        $check_payment = $this->Payment_transaction_model->get_result('payment_transaction', $where);
        if ($check_payment) {
            if ($action == 'confirm_payment') {
                $update_array = array(
                    'status' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Payment Confirm Successfully!','class'=>'success']);
            } 
            $this->Payment_transaction_model->update_record('payment_transaction', $where, $update_array);
        } else {
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/payment_transaction/manual_transaction'));
    }


    /**
     * Function is used to perform Export Csv for manual transaction
     */
    function manual_export_csv(){

        $from_date = '';
        $to_date ='';
        $search_data = $this->input->post('pay_search');      
        if($this->input->post('pay_date') != ''){ 
            $date= explode(" - ",$this->input->post('pay_date'));
            $from_date = trim($date[0]);
            $to_date   = trim($date[1]);
        }

        $payment_data = $this->Payment_transaction_model->fetch_manual_payment_csv_data($search_data,$from_date,$to_date);
        // pr($payment_data,1);
        if(!empty($payment_data)){

            $data['worksheet_name'] = "Manual payment sheet";
            $data['filename'] = "Manual_transaction_report.xls";
            //------------------
            $title_array[0] = array(
                       'payment_id'     => 'Payment ID',
                       'role_name'      => 'Role',
                       'user_name'      => 'User Name',
                       'email_id'       => 'Email ID',
                       'phone'          => 'Phone',
                       'street'         => 'Street',
                       'city'           => 'City',
                       'state_name'     => 'State',
                       'rfp_id'         => 'Request ID',
                       'rfp_title'      => 'Request Title',
                       'actual_price'   => 'Actual Price',
                       'payable_price'  => 'Payable Price',
                       'discount'       => 'Discount(%)',
                       'status'         => 'Payment Status',
                       'created_date'   => 'Created Date',
                    );   
            $new_payment_array=array_merge($title_array,$payment_data);
           //------------------
            $this->load->library('Excel');
            $this->excel->createExcelFileForPayment($new_payment_array,$data);

        }else{
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect('admin/payment_transaction/manual_transaction');
    }


     /**
     * Function is used to perform Export Csv for paypal transaction
     */
    function paypal_export_csv(){

        $from_date = '';
        $to_date ='';
        $search_data = $this->input->post('pay_search');      
        if($this->input->post('pay_date') != ''){ 
            $date= explode(" - ",$this->input->post('pay_date'));
            $from_date = trim($date[0]);
            $to_date   = trim($date[1]);
        }

        $payment_data = $this->Payment_transaction_model->fetch_paypal_payment_csv_data($search_data,$from_date,$to_date);
        // pr($payment_data,1);
        if(!empty($payment_data)){

            $data['worksheet_name'] = "Paypal payment sheet";
            $data['filename'] = "Paypal_transaction_report.xls";
            //------------------
            $title_array[0] = array(
                       'payment_id'     => 'Payment ID',
                       'paypal_token'   => 'Transaction ID',
                       'role_name'      => 'Role',
                       'user_name'      => 'User Name',
                       'email_id'       => 'Email ID',
                       'phone'          => 'Phone',
                       'street'         => 'Street',
                       'city'           => 'City',
                       'state_name'     => 'State',
                       'rfp_id'         => 'Request ID',
                       'rfp_title'      => 'Request Title',
                       'actual_price'   => 'Actual Price',
                       'payable_price'  => 'Payable Price',
                       'discount'       => 'Discount(%)',
                       'status'         => 'Payment Status',
                       'created_date'   => 'Created Date',
                    );   
            $new_payment_array=array_merge($title_array,$payment_data);
           //------------------
            $this->load->library('Excel');
            $this->excel->createExcelFileForPayment($new_payment_array,$data);

        }else{
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect('admin/payment_transaction/paypal_transaction');
    }


}
