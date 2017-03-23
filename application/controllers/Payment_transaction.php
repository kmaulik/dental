<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_transaction extends CI_Controller {

	public function __construct() {
        parent::__construct();          
        if(!isset($this->session->userdata['client'])) redirect('login');   
        $this->load->model(array('Payment_transaction_model'));
    }

	public function history(){
		
		//------- Filter Transaction ----
		$search_data= $this->input->get('search') ? $this->input->get('search') :'';
		$date_data= $this->input->get('date') ? $this->input->get('date') :'';
		$sort_data= $this->input->get('sort') ? $this->input->get('sort') :'desc';
		//------- /Filter RFP ----

		$this->load->library('pagination');	 
		$config['base_url'] = base_url().'payment_transaction/history?search='.$search_data.'&date='.$date_data.'&sort='.$sort_data;
		$config['total_rows'] = $this->Payment_transaction_model->get_payment_transaction_front_count($search_data,$date_data);
		$config['per_page'] = 10;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());		
		$this->pagination->initialize($config);
		$data['transaction_list']=$this->Payment_transaction_model->get_payment_transaction_front_result($config['per_page'],$offset,$search_data,$date_data,$sort_data);	
		$data['subview']="front/payment/payment_history";
		$this->load->view('front/layouts/layout_main',$data);
	}


}
