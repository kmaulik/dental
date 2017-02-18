<?php

class Refund_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
        /**
     * @uses : this function is used to get result based on datatable in refund list page [For Admin Side]
     * @param : @table 
     * @author : HPA
     */
    public function get_all_refund() {        
        
        $this->db->select('re.id as refund_id,re.description as refund_reason, re.status as refund_status,re.refund_token as refund_token,pt.id as payment_id,paypal_token,r.role_name as role_name,CONCAT(u.fname," ",u.lname) as user_name,rfp.id as rfp_id,rfp.title as rfp_title,payable_price,DATE_FORMAT(re.created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        
        $this->db->join('payment_transaction pt','re.payment_id=pt.id');
        $this->db->join('rfp','pt.rfp_id=rfp.id');        
        $this->db->join('users u','pt.user_id=u.id');       
        $this->db->join('role r','u.role_id=r.id');       
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('paypal_token LIKE "%' . $keyword['value'] . '%" OR role_name LIKE "%' . $keyword['value'] . '%" OR user_name LIKE "%' . $keyword['value'] . '%" OR rfp_title LIKE "%' . $keyword['value'] . '%" OR payable_price LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->order_by('re.created_at','desc');
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('refund re')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of refund based on datatable in refund list page [For Admin Side]
     * @param : @table 
     * @author : HPA
     */
    public function get_refund_count() {

        $this->db->select('re.id as refund_id,re.description as refund_reason, re.status as refund_status,re.refund_token as refund_token,pt.id as payment_id,paypal_token,r.role_name as role_name,CONCAT(u.fname," ",u.lname) as user_name,rfp.id as rfp_id,rfp.title as rfp_title,payable_price,DATE_FORMAT(re.created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        
        $this->db->join('payment_transaction pt','re.payment_id=pt.id');  
        $this->db->join('rfp','pt.rfp_id=rfp.id');      
        $this->db->join('users u','pt.user_id=u.id');       
        $this->db->join('role r','u.role_id=r.id');       
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('paypal_token LIKE "%' . $keyword['value'] . '%" OR role_name LIKE "%' . $keyword['value'] . '%" OR user_name LIKE "%' . $keyword['value'] . '%" OR rfp_title LIKE "%' . $keyword['value'] . '%" OR payable_price LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $this->db->order_by('re.created_at','desc');
        $res_data = $this->db->get('refund re')->num_rows();
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
     * @uses : This function is used to update record
     * @param : @table, @refund_id, @data_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $data_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $data_array)) {
            return 1;
        } else {
            return 0;
        }
    }

     /**
     * @uses : This function is used to fetch id wise refund data
     */
     public function fetch_refund_data($refund_id=''){
        
        $this->db->select('re.id as refund_id,re.description as refund_reason,r.role_name as role_name,CONCAT(u.fname," ",u.lname) as user_name,rfp.id as rfp_id,rfp.title as rfp_title,payable_price,DATE_FORMAT(re.created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        $this->db->from('refund re');
        $this->db->join('payment_transaction pt','re.payment_id=pt.id');  
        $this->db->join('rfp','pt.rfp_id=rfp.id');      
        $this->db->join('users u','pt.user_id=u.id');       
        $this->db->join('role r','u.role_id=r.id');       
        $this->db->where('re.id',$refund_id);
        $query=$this->db->get();
        return $query->row_array();
     }


}
