<?php

class Promotional_code_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in Promotional Code list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_promotionalcode() {        
        
        $this->db->select('id,title,code,discount,DATE_FORMAT(start_date,"%d %b %Y") AS start_date,DATE_FORMAT(end_date,"%d %b %Y") AS end_date,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" OR code LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('promotional_code,(SELECT @a:= 0) AS a')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of Promotional Code based on datatable in Promotional Code list page
     * @param : @table 
     * @author : HPA
     */
    public function get_promotionalcode_count() {
        $this->db->where('is_deleted !=', 1);
        $res_data = $this->db->get('promotional_code')->num_rows();
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
     * @uses : This function is used to update record
     * @param : @table, @code_id, @code_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $code_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $code_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @code_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $code_array) {
        if ($this->db->insert($table, $code_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to check Code title exist or not
     * @param : @Title, @code_id  
     * @author : DHK
     */
    public function CheckExist($where, $CodeId = 0) {
        $this->db->from('promotional_code');
        $this->db->where($where);
        $this->db->where('id !=' . $CodeId);
        $query = $this->db->get();
        return $query->num_rows();
    }



}

?>