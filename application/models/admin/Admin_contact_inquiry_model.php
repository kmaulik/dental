<?php

class Admin_contact_inquiry_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in Contact Inquiry list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_inquiry() {        
        
        $this->db->select('id,name,email,subject,status,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%" OR email LIKE "%'.$keyword['value'].'%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('contact_inquiry,(SELECT @a:= 0) AS a')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of inquiry based on datatable in Contact Inquiry list page
     * @param : @table 
     * @author : HPA
     */
    public function get_inquiry_count() {

        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%" OR email LIKE "%'.$keyword['value'].'%"', NULL);
        }
        $res_data = $this->db->get('contact_inquiry')->num_rows();
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
     * @param : @table, @inquiry_id, @inquiry_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $inquiry_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $inquiry_array)) {
            return 1;
        } else {
            return 0;
        }
    }

     /**
     * @uses : This function is used to insert record
     * @param : @table, @inquiry_array = array of insert  
     * @author : HPA
     */
    public function insert_record($table, $inquiry_array) {
        if ($this->db->insert($table, $inquiry_array)) {
            return 1;
        } else {
            return 0;
        }
    }

}

?>