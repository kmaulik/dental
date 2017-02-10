<?php

class Blogs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in blog list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_blogs() {        
        
        $this->db->select('id,blog_title,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('blog_title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('blog')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of blogs based on datatable in blog list page
     * @param : @table 
     * @author : HPA
     */
    public function get_blogs_count() {
       
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('blog_title LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        
        $res_data = $this->db->get('blog')->num_rows();
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
     * @param : @table, @blog_id, @blog_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $blog_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $blog_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @blog_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $blog_array) {
        if ($this->db->insert($table, $blog_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to check blog title exist or not
     * @param : @Title, @blog_id  
     * @author : DHK
     */
    public function CheckExist($Title, $BlogId = 0) {
        $this->db->from('blog');
        $this->db->where('blog_title', $Title);
        $this->db->where('id !=' . $BlogId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * @uses : this function is used to count rows of blogs based on datatable in blog list page
     * @param : @table 
     * @author : HPA
     */
    public function get_blogs_front_count($where) {
        $this->db->where($where);
        $res_data = $this->db->get('blog')->num_rows();
        return $res_data;
    }

    public function get_front_result($table, $condition = null,$limit,$offset) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get($table);
        return $query->result_array();
    }


     /**
     * @uses : this function is used to next and previous button in blog details
     * @param : @table 
     * @author : DHK
     */
    public function get_result_prev_next($table, $condition = null,$order='asc') {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $this->db->order_by('id',$order);
        $query = $this->db->get($table);
        return $query->row_array();
    }

}

?>