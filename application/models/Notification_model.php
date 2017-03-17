<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

	public function insert_notification($data){
		
		$rfp_id = $data['rfp_id'];
		$from_id = $data['from_id'];
		$to_id = $data['to_id'];
		$noti_type = $data['noti_type'];
		$data['created_at'] = date('Y-m-d H:i:s');
		
		$noti_data = $this->db->get_where('notifications',['rfp_id'=>$rfp_id,'from_id'=>$from_id,'to_id'=>$to_id,'noti_type'=>$noti_type])
						      ->row_array();
		if(!empty($noti_data)){			
			$last_id = $noti_data['id'];
			if($noti_data['is_read'] == 1){
				$this->db->delete('notifications',['id'=>$noti_data['id']]);
				$this->db->insert('notifications',$data);
				// $this->db->update('notifications',['is_read'=>'0'],['id'=>$noti_data['id']]);
			}
		}else{
			$this->db->insert('notifications',$data);
			$last_id = $this->db->insert_id();
		}
		return $last_id;
	}	

	// this func will insert notification for the Admin action for the approve or disapprove RFp
	// this ill be only use for the insert 
	public function insert_rfp_notification($data){
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert('notifications',$data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

	public function get_all_notifications($user_id,$limit,$offset){
		$this->db->order_by('created_at','desc');
		$this->db->select('notifications.*,u1.fname as from_fname,u1.lname as from_lname,u2.fname as to_fname,u2.lname as to_lname,rfp.title');
		
		$this->db->join('users as u1','notifications.from_id = u1.id');
		$this->db->join('users as u2','notifications.to_id = u2.id');
		
		$this->db->join('rfp','notifications.rfp_id = rfp.id','left');

		$this->db->where(['notifications.to_id'=>$user_id]);

		if(!empty($limit) && !empty($offset)){
			$this->db->limit($limit,$offset);
		}else{
			$this->db->limit($limit);
		}

		$res_array = $this->db->get('notifications')->result_array();

		return $res_array;
	}

	public function get_all_notifications_count($user_id){
		$this->db->order_by('created_at','desc');
		$this->db->select('notifications.*,u1.fname as from_fname,u1.lname as from_lname,u2.fname as to_fname,u2.lname as to_lname,rfp.title');
		$this->db->join('users as u1','notifications.from_id = u1.id');
		$this->db->join('users as u2','notifications.to_id = u2.id');
		$this->db->join('rfp','notifications.rfp_id = rfp.id','left');
		$this->db->where(['notifications.to_id'=>$user_id]);
		$res_array = $this->db->get('notifications')->num_rows();
		return $res_array;
	}

	public function get_unread_cnt($user_id){
		$res = $this->db->get_where('notifications',['to_id'=>$user_id,'is_read'=>'0'])->num_rows();
		return $res;
	}

	public function get_noti_data($data){
		$this->db->where($data);
		$res = $this->db->get('notifications')->row_array();
		return $res;
	}

	public function update_notification($cond,$data){
		$this->db->where($cond);
		$this->db->update('notifications',$data);
	}


}

/* End of file Notification_model.php */
/* Location: ./application/models/Notification_model.php */