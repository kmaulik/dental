<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    /*
      v! Function will check if user is exist or not (spark id - vpa)
      check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
     */
    public function check_if_user_exist($data = array(), $is_total_rows = false, $is_single = false,$where_in = false) {
    
        $this->db->where($data);

        if(!empty($where_in)){
            $this->db->where_in('role_id',$where_in);
        }
       // $this->db->where('(is_blocked != 1 AND is_deleted != 1)');
        $this->db->where('(is_deleted != 1)');
        if ($is_total_rows == true) {
            $res_data = $this->db->get('users')->num_rows();
        } else {
            if ($is_single == true) {
                $res_data = $this->db->get('users')->row_array();
            } else {
                $res_data = $this->db->get('users')->result_array();
            }
        }
        return $res_data;
    }

    /* v! Insert data into users table */

    public function insert_user_data($data) {
        $this->db->insert('users', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_data($data,$is_single = false){
        $this->db->where($data);        
        if($is_single == true){            
            return $this->db->get('users')->row_array();
        }else{
            return $this->db->get('users')->result_array();    
        }
    }

    /* v! Update data into users table */
    public function update_user_data($id, $data) {
        //$data['modified_date'] = date('Y-m-d H:i:s');
        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $this->db->where(['id' => $id]);
        }
        return $this->db->update('users', $data);
    }
 
    /*  Check For User Account Verify or Not */
    public function CheckActivationCode($code){
        $this->db->where('activation_code',$code);
        $query = $this->db->get('users');   
        if ($query->num_rows() > 0)
        {   
            return true;
        }
        else
        { 
            return false;
        }
    }

    public function check_if_user_unique($username){
        $res = $this->db->get_where('users',['email_id'=>$username])->num_rows();
        return $res;
    }

    // ------------------------------------------------------------------------
    // Patient Section
    // ------------------------------------------------------------------------
    
    public function get_all_patients(){
        $this->db->select('id,id AS test_id,fname,lname,email_id,DATE_FORMAT(last_login,"%d %b %Y <br> %l:%i %p") AS last_login,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_at,is_blocked', false);

        $this->db->where('role_id', 5); // Role id - 5 recognise as patient Id
        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('fname LIKE "%' . $keyword['value'] . '%" OR lname LIKE "%' . $keyword['value'] . '%" OR email_id LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('users')->result_array();
        return $res_data;
    }

    public function get_patients_count(){
        $this->db->where('role_id', 5); // Role id - 5 recognise as patient Id
        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('fname LIKE "%' . $keyword['value'] . '%" OR lname LIKE "%' . $keyword['value'] . '%" OR email_id LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('users')->num_rows();
        return $res_data;
    }

    // ------------------------------------------------------------------------
    // Doctor Section
    // ------------------------------------------------------------------------
    public function get_all_doctors(){
        $this->db->select('id,id AS test_id,fname,lname,email_id,DATE_FORMAT(last_login,"%d %b %Y <br> %l:%i %p") AS last_login,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_at,is_blocked', false);

        $this->db->where('role_id', 4); // Role id - 5 recognise as patient Id
        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('fname LIKE "%' . $keyword['value'] . '%" OR lname LIKE "%' . $keyword['value'] . '%" OR email_id LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('users')->result_array();
        return $res_data;
    }

    public function get_doctors_count(){
        $this->db->where('role_id', 4); // Role id - 5 recognise as patient Id
        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('fname LIKE "%' . $keyword['value'] . '%" OR lname LIKE "%' . $keyword['value'] . '%" OR email_id LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('users')->num_rows();
        return $res_data;
    }    

}

