<?php

class Testimonial_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in Testimonial list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_testimonial() {        
        
        $this->db->select('id,auther,designation,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('auther LIKE "%' . $keyword['value'] . '%" OR designation LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('testimonial')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of Testimonials based on datatable in Testimonial list page
     * @param : @table 
     * @author : HPA
     */
    public function get_testimonial_count() {
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('auther LIKE "%' . $keyword['value'] . '%" OR designation LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('testimonial')->num_rows();
        return $res_data;
    }


     public function fetch_testimonial() {
        $this->db->select('*');
        $this->db->where(['is_deleted !='=> 1,'is_blocked'=>'0']);        
        $res_data = $this->db->get('testimonial')->result_array();
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
     * @param : @table, @testimonial_id, @testimonial_array = array of update  
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
     * @param : @table, @testimonial_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $data_array) {
        if ($this->db->insert($table, $data_array)) {
            return 1;
        } else {
            return 0;
        }
    }



}

?>