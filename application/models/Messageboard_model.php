<?php

class Messageboard_model extends CI_Model {

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
     * @uses : This function is used to update record
     * @param : @table, @data_id, @data_array = array of update  
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
     * @uses : this function is used to count rows of message list
     * @param : @table 
     * @author : DHK
     */
    public function get_message_count($table,$where) {
        $this->db->where($where);
        $res_data = $this->db->get($table)->num_rows();
        return $res_data;
    }

    public function get_message_result($table, $condition = null,$limit,$offset) {
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

?>