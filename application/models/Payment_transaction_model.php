<?php

class Payment_transaction_model extends CI_Model {

    function __construct() {
        parent::__construct();
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
     * @uses : this function is used to count rows of payment history based on table in trnasaction list page
     * @param : @table 
     * @author : HPA
     */
    public function get_payment_transaction_count($search_data,$date_data) {
        $this->db->join('rfp','pt.rfp_id=rfp.id');
        if ($search_data != '') {
            $this->db->where('rfp.title LIKE "%' . $search_data . '%" OR pt.paypal_token LIKE "%'. $search_data .'%"', NULL);
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

    public function get_payment_transaction_result($limit,$offset,$search_data,$date_data,$sort_data) {
        $this->db->select('pt.*,rfp.title as rfp_title');
        $this->db->join('rfp','pt.rfp_id=rfp.id');
         if ($search_data != '') {
            $this->db->where('rfp.title LIKE "%' . $search_data . '%" OR pt.paypal_token LIKE "%'. $search_data .'%"', NULL);
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
        return $query->result_array();
    }


}

?>