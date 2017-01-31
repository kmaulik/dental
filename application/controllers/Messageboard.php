<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messageboard extends CI_Controller {

	 public function __construct() {
        parent::__construct(); 
        if(!isset($this->session->userdata['client']))redirect('login');            
        $this->load->model(array('Messageboard_model'));
    }
	public function index()
	{
		
		$data['messages']=$this->Messageboard_model->get_rfp_message();
		// $this->load->library('pagination');
		// $where=['rfp_id' => $this->session->userdata['client']['id'],'is_deleted' => '0'];
		// $config['base_url'] = base_url().'messageboard/index';
		// $config['total_rows'] = $this->Messageboard_model->get_message_count('rfp_bid',$where);
		// $config['per_page'] = 10;
		// $offset = $this->input->get('per_page');
		// $config = array_merge($config,pagination_front_config());       
		// $this->pagination->initialize($config);
		// $data['messages']=$this->Messageboard_model->get_message_result('rfp_bid',$where,$config['per_page'],$offset);

		// $where=['to_id' => $this->session->userdata['client']['id'],'status' => '0','is_deleted' => '0'];
		// $data['count_inbox']=$this->Messageboard_model->get_message_count('msg_inbox',$where);
		$data['subview']="front/messageboard/message_list";
		$this->load->view('front/layouts/layout_main',$data);
	}

	public function message($rfp_id,$user_id){
		
		$data['message_data']=$this->Messageboard_model->fetch_messages(decode($rfp_id),decode($user_id));
		if($this->input->post('submit'))
		{
			$data=array(
			    		'rfp_id' => decode($rfp_id),
			    		'from_id' => $this->session->userdata('client')['id'],
			    		'to_id' => decode($user_id),
			    		'message' => $this->input->post('message'),
			    		'created_at'	=> date("Y-m-d H:i:s")
			    	);
    		$data=$this->Messageboard_model->insert_record('messages',$data);
    		if($data)
    		{
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
		    }
		    else{
		    	$this->session->set_flashdata('error', 'Error Into Send Message'); 
		    }   
		    redirect('messageboard/message/'.$rfp_id.'/'.$user_id);       
		}
		$data['subview']="front/messageboard/message";
		$this->load->view('front/layouts/layout_main',$data);
	}

}
