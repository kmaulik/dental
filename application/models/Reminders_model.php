<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminders_model extends CI_Model {


	public function get_reminders($where){
		$this->db->where($where);
		$res = $this->db->get('reminders')->result_array();
		return $res;
	}
	
	public function insert_data($data){
		$this->db->insert('reminders',$data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

	public function update_data($where,$data){
		$this->db->where($where);
		$this->db->update('reminders',$data);
		$res = $this->db->affected_rows();
		return $res;
	}

}

/* End of file Reminders_model.php */
/* Location: ./application/models/Reminders_model.php */