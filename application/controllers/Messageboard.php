<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messageboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
        if(!isset($this->session->userdata['client']))redirect('login');
        $this->load->model(array('Messageboard_model','Notification_model'));
    }

	public function index(){

		$where = [
                    'u.is_deleted' => 0,
                    'u.is_blocked' => 0,
                    'rfp.is_deleted' => 0,
                    'rfp.is_blocked' => 0,
                    'rb.is_deleted' => 0,
                    'rb.is_chat_started' => 1
                ];

		//---------- For Search Data --------------
		$search_data= $this->input->get('search') ? $this->input->get('search') :'';
		//---------- /For Search Data --------------
		
		$this->load->library('pagination');
		$config['base_url'] = base_url().'messageboard/index?search='.$search_data;
		$config['total_rows'] = $this->Messageboard_model->get_rfp_message_count($where,$search_data);
		$config['per_page'] = 10;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());       
		$this->pagination->initialize($config);
		$data['messages']=$this->Messageboard_model->get_rfp_message($where,$config['per_page'],$offset,$search_data);
		//pr($data['messages'],1);
		$data['subview']="front/messageboard/message_list";
		$this->load->view('front/layouts/layout_main',$data);
	}

	public function message($rfp_id,$user_id){
		
		//------------ For Update status Unread to read -------------
		$condition=[
					'rfp_id' => decode($rfp_id),
					'from_id' => decode($user_id),
					'to_id' => $this->session->userdata('client')['id']
				];
		$this->Messageboard_model->update_record('messages',$condition,['status' => '1']);
		//------------ End Update status Unread to read -------------

		$data['message_data']=$this->Messageboard_model->fetch_messages(decode($rfp_id),decode($user_id));
		//pr($data['message_data'],1);
		if($this->input->post('submit')){			
			$data=array(
			    		'rfp_id' => decode($rfp_id),
			    		'from_id' => $this->session->userdata('client')['id'],
			    		'to_id' => decode($user_id),
			    		'message' => $this->input->post('message'),
			    		'created_at'	=> date("Y-m-d H:i:s")
			    	);
    		
    		$data=$this->Messageboard_model->insert_record('messages',$data);

    		if($data){

    			// v! insert data notifications table
				$noti_data = [
								'from_id'=>$this->session->userdata('client')['id'],
								'to_id'=>decode($user_id),
								'rfp_id' => decode($rfp_id),
								'noti_type'=>'message',
								'noti_url'=>'messageboard'								
							];
														
				$this->Notification_model->insert_notification($noti_data);				

		    	$user_data=$this->Messageboard_model->get_result('users',['id' => decode($user_id)],'1');
		    	$rfp_data=$this->Messageboard_model->get_result('rfp',['id' => decode($rfp_id)],'1');
		    	//------------ Send Mail Config-----------------
		    	$html_content=mailer('contact_inquiry','AccountActivation'); 
		        $username= $user_data['fname']." ".$user_data['lname'];
		        $html_content = str_replace("@USERNAME@",$username,$html_content);
		        $html_content = str_replace("@MESSAGE@",$this->input->post('message'),$html_content);
		       
		        $email_config = mail_config();
		        $this->email->initialize($email_config);
		        $from_name =$this->session->userdata('client')['fname']." ".$this->session->userdata('client')['lname'];
		        $subject=config('site_name').' - Message For '.$rfp_data['title'].' RFP From '.$from_name;    
		        $this->email->from(config('contact_email'), config('sender_name'))
		                    ->to($user_data['email_id'])
		                    ->subject($subject)
		                    ->message($html_content);
		        $this->email->send();
		        //------------ End Send Mail Config----------------- 
		        $this->session->set_flashdata('success', 'Message Send Successfully'); 
		    
		    }else{		    	
		    	$this->session->set_flashdata('error', 'Error Into Send Message'); 
		    }   
		    redirect('messageboard/message/'.$rfp_id.'/'.$user_id);       
		}
		$data['subview']="front/messageboard/message";
		$this->load->view('front/layouts/layout_main',$data);
	}

}
