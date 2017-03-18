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
        
        $this->db->select('id,title,code,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $order = $this->input->get('order');
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" or code LIKE "%'.$keyword['value'].'%"', NULL);
        }

        if(!empty($order)){
            $key = $order[0]['column'];
            $columns = $this->input->get('columns');
            $this->db->order_by($columns[$key]['data'],$order[0]['dir']);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('treatment_category')->result_array();
        return $res_data;
    }
 
    public function get_treatment_category_count() {
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" or code LIKE "%'.$keyword['value'].'%"', NULL);
        }
        $res_data = $this->db->get('treatment_category')->num_rows();
        return $res_data;
    }
 
    public function get_result($table, $condition = null) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }

        if($table == 'treatment_category'){
            $this->db->order_by('code');
        }

        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function update_record($table, $condition, $treatment_category_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $treatment_category_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insert_record($table, $treatment_category_array) {
        if ($this->db->insert($table, $treatment_category_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function CheckExist($Title, $CatId = 0) {
        $this->db->from('treatment_category');
        $this->db->where('title', $Title);
        $this->db->where('id !=' . $CatId);
        $query = $this->db->get();
        return $query->num_rows();
    }



}

?>