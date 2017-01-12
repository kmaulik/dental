<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        
    }
    /*
      v! Function will check if user is exist or not (spark id - vpa)
      check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
     */
    public function check_if_user_exist($data = array(), $is_total_rows = false, $is_single = false) {
        $this->db->where($data);
        $this->db->where('(is_blocked != 1 AND is_deleted != 1)');
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

    /* v! Update data into users table */

    public function update_user_data($id, $data) {
        //$data['modified_date'] = date('Y-m-d H:i:s');
        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $this->db->where(['id' => $id]);
        }
        $this->db->update('users', $data);
        $last_id = $this->db->affected_rows();
        return $last_id;
    }

    // -------------------------------------------------------- Table - forgot_pass----------------------------------------------------

    public function check_if_user_forgot_pass($data = array(), $is_total_rows = false, $is_single = false) {
        $this->db->where($data);
        if ($is_total_rows == true) {
            $res_data = $this->db->get('forgot_pass')->num_rows();
        } else {
            if ($is_single == true) {
                $res_data = $this->db->get('forgot_pass')->row_array();
            } else {
                $res_data = $this->db->get('forgot_pass')->result_array();
            }
        }
        return $res_data;
    }

    /* v! Insert data into forgot_pass table */
    public function insert_forgot_pass_data($data) {
        $user_id = $data['user_id'];
        $all_rows_no = $this->db->get_where('forgot_pass', ['user_id' => $user_id])->row_array();

        if (count($all_rows_no) == 0) {
            $this->db->insert('forgot_pass', $data);
            $user_id = $this->db->insert_id();
        } else {
            $this->db->where('user_id', $user_id);
            $this->db->update('forgot_pass', $data);
        }
        return $user_id;
    }

}

/* End of file User_model.php */
/* Location: ./application/models/Users_model.php */