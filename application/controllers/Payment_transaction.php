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

		if($this->session->userdata('client')['role_id'] == 4) {
			
			$config['base_url'] = base_url().'payment_transaction/history?search='.$search_data.'&date='.$date_data.'&sort='.$sort_data;
			$config['total_rows'] = $this->Payment_transaction_model->get_payment_transaction_doctor_count($search_data,$date_data);
			$config['per_page'] = 10;
			$offset = $this->input->get('per_page');
			$config = array_merge($config,pagination_front_config());		
			$this->pagination->initialize($config);
			$data['transaction_list']=$this->Payment_transaction_model->get_payment_transaction_doctor_result($config['per_page'],$offset,$search_data,$date_data,$sort_data);	
			//pr($data['transaction_list'],1);
			$data['subview']="front/payment/doctor_payment_history";
			$this->load->view('front/layouts/layout_main',$data);

		}else if($this->session->userdata('client')['role_id'] == 5){
		
			$config['base_url'] = base_url().'payment_transaction/history?search='.$search_data.'&date='.$date_data.'&sort='.$sort_data;
			$config['total_rows'] = $this->Payment_transaction_model->get_payment_transaction_patient_count($search_data,$date_data);
			$config['per_page'] = 10;
			$offset = $this->input->get('per_page');
			$config = array_merge($config,pagination_front_config());		
			$this->pagination->initialize($config);
			$data['transaction_list']=$this->Payment_transaction_model->get_payment_transaction_patient_result($config['per_page'],$offset,$search_data,$date_data,$sort_data);	
			$data['subview']="front/payment/patient_payment_history";
			$this->load->view('front/layouts/layout_main',$data);

		}

		
	}


	public function download_invoice($transaction_id){

		$data['transaction_detail'] = $this->Payment_transaction_model->get_invoice_data(decode($transaction_id));
		//pr($data['transaction_detail'],1);
		if(!empty($data['transaction_detail'])){

			$html =$this->load->view('front/invoice_sample', $data, true);
			//echo $html;die;
			$this->load->library('m_pdf');

			$mpdf = $this->m_pdf->load();
			 
			$mpdf->SetDisplayMode('fullpage');
			 		 
			$mpdf->WriteHTML($html);
			   
			//$mpdf->Output();   

			$mpdf->Output('Invoice.pdf','D');
		}else{
			show_404();
		}

	}


}
