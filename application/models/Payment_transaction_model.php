<?php

class Payment_transaction_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
     /**
     * @uses : this function is used to get result based on datatable in transaction list page [For Admin Side]
     * @param : @table 
     * @author : HPA
     */
    public function get_all_transaction() {        
        
        $this->db->select('pt.id as payment_id,paypal_token,r.role_name as role_name,CONCAT(u.fname," ",u.lname) as user_name,rfp.id as rfp_id,rfp.title as rfp_title,actual_price,payable_price,discount,DATE_FORMAT(pt.created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        $this->db->join('rfp','pt.rfp_id=rfp.id');       
        $this->db->join('users u','pt.user_id=u.id');       
        $this->db->join('role r','u.role_id=r.id');       
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('paypal_token LIKE "%' . $keyword['value'] . '%" OR role_name LIKE "%' . $keyword['value'] . '%" OR user_name LIKE "%' . $keyword['value'] . '%" OR rfp_title LIKE "%' . $keyword['value'] . '%" OR actual_price LIKE "%' . $keyword['value'] . '%" OR payable_price LIKE "%' . $keyword['value'] . '%" OR discount LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        if($this->session->userdata('date_filter') != ''){
            $this->db->where('date_format(pt.created_at,"%m/%d/%Y") >=', $this->session->userdata['date_filter']['from_date']);
            $this->db->where('date_format(pt.created_at,"%m/%d/%Y") <=', $this->session->userdata['date_filter']['to_date']);
        }
        $this->db->order_by('pt.created_at','desc');
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('payment_transaction pt')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of transaction based on datatable in transaction list page [For Admin Side]
     * @param : @table 
     * @author : HPA
     */
    public function get_transaction_count() {

        $this->db->select('pt.id as payment_id,paypal_token,r.role_name as role_name,CONCAT(u.fname," ",u.lname) as user_name,rfp.title as rfp_title,actual_price,payable_price,discount,DATE_FORMAT(pt.created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        $this->db->join('rfp','pt.rfp_id=rfp.id');       
        $this->db->join('users u','pt.user_id=u.id');       
        $this->db->join('role r','u.role_id=r.id');       
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
       
        if (!empty($keyword['value'])) {
            $this->db->having('paypal_token LIKE "%' . $keyword['value'] . '%" OR role_name LIKE "%' . $keyword['value'] . '%" OR user_name LIKE "%' . $keyword['value'] . '%" OR rfp_title LIKE "%' . $keyword['value'] . '%" OR actual_price LIKE "%' . $keyword['value'] . '%" OR payable_price LIKE "%' . $keyword['value'] . '%" OR discount LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        if($this->session->userdata('date_filter') != ''){
            $this->db->where('date_format(pt.created_at,"%m/%d/%Y") >=', $this->session->userdata['date_filter']['from_date']);
            $this->db->where('date_format(pt.created_at,"%m/%d/%Y") <=', $this->session->userdata['date_filter']['to_date']);
        }
        $this->db->order_by('pt.created_at','desc');
        $res_data = $this->db->get('payment_transaction pt')->num_rows();
        return $res_data;
    }


    /**
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : HPA
     */
    public function get_result($table, $condition = null) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @payment_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $data_array) {
        if ($this->db->insert($table, $data_array)) {
            return 1;
        } else {
            return 0;
        }
    }


     /**
     * @uses : this function is used to count rows of payment history based on table in transaction list page For Patient User
     * @param : @table 
     * @author : DHK
     */
    public function get_payment_transaction_patient_count($search_data,$date_data) {
        $this->db->select('pt.*,rfp.title as rfp_title,CONCAT(rfp.fname," ",rfp.lname) as patient_name');
        $this->db->join('rfp','pt.rfp_id=rfp.id');
        
        if ($search_data != '') {
            $this->db->having('rfp.title LIKE "%' . $search_data . '%" OR pt.paypal_token LIKE "%'. $search_data .'%" OR patient_name LIKE "%'. $search_data .'%"', NULL);
        }

        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('user_id',$this->session->userdata['client']['id']);
        $res_data = $this->db->get('payment_transaction pt')->num_rows();
        return $res_data;
    }

    public function get_payment_transaction_patient_result($limit,$offset,$search_data,$date_data,$sort_data) {
        $this->db->select('pt.*,rfp.title as rfp_title,CONCAT(rfp.fname," ",rfp.lname) as patient_name');
        $this->db->join('rfp','pt.rfp_id=rfp.id');
         if ($search_data != '') {
            $this->db->having('rfp.title LIKE "%' . $search_data . '%" OR pt.paypal_token LIKE "%'. $search_data .'%" OR patient_name LIKE "%'. $search_data .'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('user_id',$this->session->userdata['client']['id']);
        $this->db->order_by('id',$sort_data);
        $this->db->limit($limit,$offset);
        $query = $this->db->get('payment_transaction pt');

        // qry(1);
        
        return $query->result_array();
    }


       /**
     * @uses : this function is used to count rows of payment history based on table in transaction list page For Doctor User
     * @param : @table 
     * @author : DHK
     */
    public function get_payment_transaction_doctor_count($search_data,$date_data) {
        $this->db->select('pt.*,rfp.title as rfp_title,CONCAT(rfp.fname," ",rfp.lname) as patient_name,rb.amount as bid_amt');
        $this->db->join('rfp','pt.rfp_id=rfp.id');
        $this->db->join('rfp_bid rb','pt.rfp_id=rb.rfp_id and pt.user_id=rb.doctor_id');
        $this->db->join('billing_schedule bs','pt.rfp_id=bs.rfp_id and pt.user_id=bs.doctor_id and transaction_id IS NULL');
        
        if ($search_data != '') {
            $this->db->having('rfp.title LIKE "%' . $search_data . '%" OR pt.paypal_token LIKE "%'. $search_data .'%" OR patient_name LIKE "%'. $search_data .'%"', NULL);
        }

        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('user_id',$this->session->userdata['client']['id']);
        $res_data = $this->db->get('payment_transaction pt')->num_rows();
        return $res_data;
    }

    public function get_payment_transaction_doctor_result($limit,$offset,$search_data,$date_data,$sort_data) {
        $this->db->select('pt.*,rfp.title as rfp_title,CONCAT(rfp.fname," ",rfp.lname) as patient_name,rb.amount as bid_amt,bs.price as remain_amt');
        $this->db->join('rfp','pt.rfp_id=rfp.id');
        $this->db->join('rfp_bid rb','pt.rfp_id=rb.rfp_id and pt.user_id=rb.doctor_id');
        $this->db->join('billing_schedule bs','pt.rfp_id=bs.rfp_id and pt.user_id=bs.doctor_id and transaction_id IS NULL','LEFT');

         if ($search_data != '') {
            $this->db->having('rfp.title LIKE "%' . $search_data . '%" OR pt.paypal_token LIKE "%'. $search_data .'%" OR patient_name LIKE "%'. $search_data .'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(pt.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('user_id',$this->session->userdata['client']['id']);
        $this->db->order_by('id',$sort_data);
        $this->db->limit($limit,$offset);
        $query = $this->db->get('payment_transaction pt');

        //qry(1);
        
        return $query->result_array();
    }
}
