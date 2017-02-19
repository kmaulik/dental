<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['Testimonial_model','Notification_model','Users_model','Reminders_model','Rfp_model']);
	}

	public function index(){
		$data['subview']="front/home";
		$data['all_testimonials'] = $this->Testimonial_model->fetch_testimonial();		
		$this->load->view('front/layouts/layout_main',$data);
	}
	 
	public function read_notification(){
		$noti_id = $this->input->post('noti_id');
		$res = $this->Notification_model->get_noti_data(['id'=>$noti_id]);
		
		$ret_arr = [];
		$ret_arr['unread']='no';
		$ret_arr['noti_data'] = $res;		

		if($res['is_read'] == '0'){
			$this->Notification_model->update_notification(['id'=>$noti_id],['is_read'=>'1']);
			$ret_arr['unread']='yes';
		}		
		
		$ret_arr['unread_cnt'] = get_notifications_unread_count();

		echo json_encode($ret_arr);
	}


	// ------------------------------------------------------------------------
	// v! - Reminders Module
	// ------------------------------------------------------------------------

	public function reminders(){
		$loc_arr = array();
        $user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
        $data['db_data'] = $this->Users_model->get_data(['id'=>$user_id],true);
        $data['tab'] = 'info';

        $data['reminders_data'] = $this->Rfp_model->get_result('reminders',['user_id'=>$user_id,'is_deleted'=>'0']);
        // pr($res,1);
		$data['subview']="front/profile/reminders";
        $this->load->view('front/layouts/layout_main',$data);
	}

	public function add_reminder(){
		$reminder_title = $this->input->post('reminder_title');
		$reminder_date = $this->input->post('reminder_date');
		
		$reminder_time = $this->input->post('reminder_time');
		$reminder_time_arr = explode(':',$reminder_time);
		$r_time = $reminder_date.' '.trim($reminder_time_arr[0]).':'.trim($reminder_time_arr[1]).':00';

		$is_active = $this->input->post('is_active');
		$active_val = '0';
		if($is_active == 'on'){
			$active_val = '1';
		}
		
		$reminder_id_hidden = $this->input->post('reminder_id_hidden');

		$ins_data = array(
							'user_id'=>$this->session->userdata('client')['id'],
							'reminder_title'=>$reminder_title,
							'reminder_time'=>$r_time,
							'is_active'=>$active_val,
							'created_at'=>date('Y-m-d H:i:s')
						);
		if(empty($reminder_id_hidden)){
			$this->Reminders_model->insert_data($ins_data);
		}else{
			$this->Reminders_model->update_data(['id'=>$reminder_id_hidden],$ins_data);
		}
		$this->session->set_flashdata('success','New Reminder has been successfully created.');
		redirect('home/reminders');
	}
	
	public function get_reminder_data(){
		$user_data = $this->session->userdata('client');
        $user_id = $user_data['id'];
		$reminder_id = $this->input->post('reminder_id');
		$reminders_data = $this->Rfp_model->get_result('reminders',
															  ['user_id'=>$user_id,'is_deleted'=>'0','id'=>$reminder_id],true);
		
		$reminders_data['only_date'] = date('Y-m-d',strtotime($reminders_data['reminder_time']));
		$reminders_data['only_time'] = date('H:i',strtotime($reminders_data['reminder_time']));
		echo json_encode($reminders_data);
	}

	public function delete_reminder($reminder_id){
		$this->Rfp_model->update_record('reminders',['id'=>$reminder_id],['is_deleted'=>'1']);
		$this->session->set_flashdata('success','Reminder has been deleted successfully.');
		redirect('home/reminders');
	}

	// ------------------------------------------------------------------------
	// ENDS
	// ------------------------------------------------------------------------
 
}
