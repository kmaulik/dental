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

}
