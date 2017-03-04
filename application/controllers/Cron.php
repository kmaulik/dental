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
				} // END of IF condition

			}
		}
	}

	public function check_agreement_status(){
		// B-4JG22401JU920743V

		// get_detail_billing_agreement
		$res_data = $this->Rfp_model->get_result('billing_agreement',['status'=>'1']);		
		// pr($res_data,1);

		if(!empty($res_data)){
			foreach($res_data as $res){
				
				$billing_detail = get_detail_billing_agreement($res['billing_id']);				
				$billing_detail_json = json_encode($billing_detail);
				$ack_billing = strtoupper($billing_detail['ACK']);				

				if($ack_billing == "SUCCESS" || $ack_billing == "SUCCESSWITHWARNING") {

					$billing_status = $billing_detail['BILLINGAGREEMENTSTATUS'];

					if($billing_status != 'Active'){
						$billing_detail_json;
						$this->Rfp_model->update_record('billing_agreement',['id'=>$res['id']],
																			['status'=>'0','cancel_arr'=>$billing_detail_json]);
					}					
				}

			} // End of Foreach Loop
		}

	}

	public function get_payments(){
		$all_data = $this->Rfp_model->get_result('billing_schedule',['next_billing_date'=>date('Y-m-d'),'transaction_id is null'=>null]);
		// qry();
		// pr($all_data,1);
		if(!empty($all_data)){
			foreach($all_data as $a_data){
				
				$due_amt = $a_data['price'];

				//fetch agreement data for doctor (only active agreements)
				$res_data = $this->Rfp_model->get_result('billing_agreement',['doctor_id'=>$a_data['doctor_id'],'status'=>'1'],true);
				if(!empty($res_data)){
					$billing_id = $res_data['billing_id'];
					
					$ret_arr = DoReferenceTransaction($billing_id,$due_amt);
					$ret_arr_json = json_encode($ret_arr);

					$ack_reference = strtoupper($ret_arr['ACK']);

					if($ack_reference == "SUCCESS" || $ack_reference == "SUCCESSWITHWARNING") {
						$payment_status = strtoupper($ret_arr['PAYMENTSTATUS']);
						
						$db_status = '0';
						if($payment_status == 'COMPLETED'){
							$db_status = '1';
						}

						//Check status update in billing schedule
						$this->Rfp_model->update_record('billing_schedule',['id'=>$a_data['id']],
																		   ['status'=>$db_status,
																		   'transaction_id'=>$ret_arr['TRANSACTIONID']]);

						// ------------------------------------------------------------------------
						$transaction_arr =  array(
	        							'user_id'=>$a_data['doctor_id'],
	        							'rfp_id'=>$a_data['rfp_id'],
	        							'actual_price'=>'',
	        							'payable_price'=>$due_amt,
	        							'discount'=>'',
	        							'promotional_code_id'=>'',
	        							'paypal_token'=>$ret_arr['TRANSACTIONID'],
	        							'meta_arr'=>$ret_arr_json,
	        							'status'=>$db_status,
	        							'created_at'=>date('Y-m-d H:i:s')
	        						);
	        			$this->Rfp_model->insert_record('payment_transaction',$transaction_arr);
	        			// ------------------------------------------------------------------------

					}else{


					}

					pr($ret_arr);
					pr($a_data);
					// pr($res_data);
				}

			} // ForEACH ENs here
		}

	}

}

/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */