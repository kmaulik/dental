<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('paypal');
		$this->load->model(['Rfp_model']);
	}
	
	public function index(){
		
	}

	public function check_status(){

		$res_data = $this->Rfp_model->get_result('billing_schedule',['status'=>'0']);
		// pr($res_data,1);
		if(!empty($res_data)){
			$return_arr = [];

			foreach($res_data as $res){
				$return_arr = GetTransactionDetails($res['transaction_id']);
				$return_json = json_encode($return_arr);
				$ack_transaction = strtoupper($return_arr['ACK']);
				
				if($ack_transaction == "SUCCESS" || $ack_transaction == "SUCCESSWITHWARNING") {
					if($return_arr['PAYMENTSTATUS'] == 'Completed'){
						$this->Rfp_model->update_record('billing_schedule',['id'=>$res['id']],['status'=>'1']);
						$this->Rfp_model->update_record('payment_transaction',
														['paypal_token'=>$res['transaction_id']],
														['status'=>'1','meta_arr'=>$return_json]);

					}
				}

			}
		}
	}

}

/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */