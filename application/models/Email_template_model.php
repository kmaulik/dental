<?php

class Email_template_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in Email Template list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_emails() {        
        
        $this->db->select('id,title,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('email_template')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of Email Template based on datatable in Email Template list page
     * @param : @table 
     * @author : HPA
     */
    public function get_email_count() {
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('email_template')->num_rows();
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
     * @param : @table, @email_id, @email_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $email_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $email_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @email_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $email_array) {
        if ($this->db->insert($table, $email_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to check Email Template title exist or not
     * @param : @Title, @email_id  
     * @author : DHK
     */
    public function CheckExist($Title, $EmailId = 0) {
        $this->db->from('email_template');
        $this->db->where('title', $Title);
        $this->db->where('id !=' . $EmailId);
        $query = $this->db->get();
        return $query->num_rows();
    }



}

?>