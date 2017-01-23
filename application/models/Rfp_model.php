<?php

class Rfp_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


     /**
     * @uses : this function is used to get result based on datatable in rfp list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_rfp() {        
        
        $this->db->select('id,title,CONCAT(fname," ",lname) as patient_name,dentition_type,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" OR patient_name LIKE "%'.$keyword['value'].'%" OR dentition_type LIKE "%'.$keyword['value'].'%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('rfp')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of rfps based on datatable in rfp list page
     * @param : @table 
     * @author : HPA
     */
    public function get_rfp_count() {
        $this->db->where('is_deleted !=', 1);
        $res_data = $this->db->get('rfp')->num_rows();
        return $res_data;
    }


     /**
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : HPA
     */
    public function get_result($table, $condition = null,$single='') {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);
        if($single){
            return $query->row_array();
        }else{ 
            return $query->result_array();
        }
    }


     /**
     * @uses : This function is used to insert record
     * @param : @table, @data_array = array of update  
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
     * @param : @table, @record_id, @data_array = array of update  
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
     * @uses : this function is used to count rows of rfp based on  rfp list page
     * @param : @table , @where Condition
     * @author : HPA
     */
    public function get_rfp_front_count($table,$where) {
        $this->db->where($where);
        $res_data = $this->db->get($table)->num_rows();
        return $res_data;
    }

    public function get_rfp_front_result($table, $condition = null,$limit,$offset) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get($table);
        return $query->result_array();
    }

}    
