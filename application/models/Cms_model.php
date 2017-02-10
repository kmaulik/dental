<?php

class Cms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in cms list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_cms() {        
        
        $this->db->select('id,title,seo_title,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" OR seo_title LIKE "%'.$keyword['value'].'%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('cms_page,(SELECT @a:= 0) AS a')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of cms based on datatable in cms list page
     * @param : @table 
     * @author : HPA
     */
    public function get_cms_count() {
        
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" OR seo_title LIKE "%'.$keyword['value'].'%"', NULL);
        }
        $res_data = $this->db->get('cms_page')->num_rows();
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
     * @param : @table, @cms_id, @cms_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $cms_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $cms_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @cms_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $cms_array) {
        if ($this->db->insert($table, $cms_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to check cms title exist or not
     * @param : @Title, @cms_id   
     * @author : DHK
     */
    public function CheckExist($Title, $CmsId = 0) {
        $this->db->from('cms_page');
        $this->db->where('title', $Title);
        $this->db->where('id !=' . $CmsId);
        $query = $this->db->get();
        return $query->num_rows();
    }



}

?>