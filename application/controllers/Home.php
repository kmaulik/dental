<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['Testimonial_model','Notification_model','Users_model','Reminders_model','Rfp_model']);
		$this->load->helper('paypal_helper');
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

	public function fetch_notification(){
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');

		$all_noti_cnt = get_total_noti_count();

		$ret_data = get_notifications($limit,$offset);		
		$new_str = '';

		if(!empty($ret_data)){
			foreach($ret_data as $noti){				
				$li_class = '';
				if($noti['is_read'] == '1'){ $li_class = 'read'; }
				$new_str .= '<li style="cursor:pointer" id="li_'.$noti['id'].'" class="'.$li_class.'">';
                $new_str .= '<a onclick="notification_action('.$noti['id'].')">';
                $new_str .= '<p class="notifly_head">'.$noti['noti_msg'].'</p>';
                $new_str .= '<p class="notifly_ago">'.time_ago($noti['created_at']).'</p></a></li>';
			}
		}

		echo json_encode(['status'=>'success','new_str'=>$new_str,'all_noti_cnt'=>$all_noti_cnt,'offset'=>(int)$offset]);
	}

	public function reset_notification(){
		$res_data = $this->session->userdata('client');
		$client_id = $res_data['id'];
		$this->Rfp_model->update_record('notifications',['to_id'=>$client_id],['is_read'=>'1']);
		$this->session->set_flashdata('success','All Notifications has been cleared.');
		redirect('dashboard');
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

	// -----------------------------------------------------------------------
	// For create Manual Agreement
	// ------------------------------------------------------------------------

	public function create_manual_agreement(){
		$returnURL = base_url().'home/create_manual_agreement_success';
       	$cancelURL = base_url().'home/create_manual_agreement_error';
        //-------------------------------------------------
       	$resArray = CallShortcutExpressCheckout('45',$returnURL, $cancelURL);

        $ack = strtoupper($resArray["ACK"]);

    	if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
        	RedirectToPayPal($resArray["TOKEN"]);
    	} else {
        	$this->session->set_flashdata('error','Something goes wrong. Please try again');
        	redirect('dashboard');
        }
	}

	public function create_manual_agreement_success(){

		if (isset($_REQUEST['token'])) {

			$token = $_REQUEST['token'];
        	$payer_id = $_REQUEST['PayerID'];

        	$ret_arr = CreateBillingAgreement($token); // Create Billing agreement return billing agreement ID        	
        	$ack_agreement = strtoupper($ret_arr['ACK']);

        	if ($ack_agreement == "SUCCESS" || $ack_agreement == "SUCCESSWITHWARNING") {
        		$billing_id = $ret_arr['BILLINGAGREEMENTID'];

        		$all_details = get_detail_billing_agreement($billing_id);
        		$all_details_json = json_encode($all_details);

				$u_data = $this->session->userdata('client');
				$agreement_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$u_data['id']],true);
				if(!empty($agreement_data)){
					//--- For Check if agreement id is same then not cancel billing agreement (Create same account agreement then occur this situation) 
					if($agreement_data['billing_id'] != $billing_id){
						cancel_billing_agreement($agreement_data['billing_id']);
					}	
					$this->Rfp_model->delete_record('billing_agreement',['id'=>$agreement_data['id']]);
				}

				$ins_data = array(
									'doctor_id'=>$u_data['id'],
									'billing_id'=>$billing_id,							
									'status'=>'1',
									'meta_arr'=>$all_details_json,
									'created_at'=>date('Y-m-d H:i:s')
								);
				$this->Rfp_model->insert_record('billing_agreement',$ins_data);	
				$this->session->set_flashdata('success','Congratulations to your new agreement.');
	        	redirect('dashboard/edit_profile?tab=payment_method');
			}	
		}
	}

	public function create_manual_agreement_error(){
		
	}

	// ------------------------------------------------------------------------
	// ENDS
	// ------------------------------------------------------------------------
 
}
