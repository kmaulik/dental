<?php

class Treatment_category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in Treatment Category list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_treatment_category() {        
        
        $this->db->select('id,title,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('treatment_category')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of treatment_category based on datatable in Treatment Category list page
     * @param : @table 
     * @author : HPA
     */
    public function get_treatment_category_count() {
        $this->db->where('is_deleted !=', 1);
        $res_data = $this->db->get('treatment_category')->num_rows();
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
     * @param : @table, @treatment_category_id, @treatment_category_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $treatment_category_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $treatment_category_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @treatment_category_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $treatment_category_array) {
        if ($this->db->insert($table, $treatment_category_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to check Treatment Category title exist or not
     * @param : @Title, @treatment_category_id   
     * @author : DHK
     */
    public function CheckExist($Title, $CatId = 0) {
        $this->db->from('treatment_category');
        $this->db->where('title', $Title);
        $this->db->where('id !=' . $CatId);
        $query = $this->db->get();
        return $query->num_rows();
    }



}

?>