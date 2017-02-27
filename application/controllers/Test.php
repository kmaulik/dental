<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public $name = '';
    public $subscription_price = 20;

	public function __construct(){
		parent::__construct();
		$this->load->helper(['paypal_helper']);	
        $this->load->library('unirest');
        // $this->session->sess_destroy();
        // pr($this->session->all_userdata(),1);
	}
		
	public function index(){
		
		$data['subscribe'] = base_url().'test/subscribe';
		$this->load->view('test/newtest',$data);
	}


	public function subscribe(){

       	$paymentAmount = $this->subscription_price;
        
        $data = array('Payment_Amount' => $this->subscription_price );

        $this->session->set_userdata($data);

        $currencyCodeType = "USD";
        $paymentType = "Sale";        
        $returnURL = base_url().'test/review';
        $cancelURL = base_url().'test/';

        //'-------------------------------------------------
        $resArray = CallShortcutExpressCheckout($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);

        // pr($resArray,1);
        $ack = strtoupper($resArray["ACK"]);
    	if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
            RedirectToPayPal($resArray["TOKEN"]);
        } else {

        }
	}

	public function review() {
        $data = array();

        $PayerID = $this->input->get('PayerID');

        $data['back'] = base_url().'test';
        $data['subscribe'] = base_url().'test/subscribe';


        if (isset($_REQUEST['token'])) {
            $token = $_REQUEST['token'];
            
            $ret_arr = CreateBillingAgreement($token);
            if($ret_arr != ''){
                $payer_id = $_REQUEST['PayerID'];
                $token= $_REQUEST['token'];
                $res1= DoExpressCheckoutPayment($payer_id,$token);
                echo "Billing Agreement : <br>";
                pr($ret_arr);
                echo "Payment Transaction : <br>";
                pr($res1);
                $retttt = DoReferenceTransaction($ret_arr['BILLINGAGREEMENTID']);
                echo "RefrenceTransaction : <br>";
                pr($retttt,1);
            }
            
            // $express_ret = DoExpressCheckoutPayment($PayerID,$token);            
            //pr($retttt);
        }

        // If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.
        if ($token != "") {
            $resArray = GetShippingDetails($token);
            $ack = strtoupper($resArray["ACK"]);
            if ($ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") {
            	$data['confirm'] = base_url().'test/confirm';
                $this->load->view('test/testreview', $data);
            }else{
            	echo "ELSE";
            }
        } // END of IF Condition for the $token

    }

    public function confirm() {
    	$data = array();
        $data['back'] = base_url().'test';
        $data['subscribe'] = base_url().'test/subscribe';
        $finalPaymentAmount = $this->subscription_price;
        $resArray1 = ConfirmPayment($finalPaymentAmount);
        $resArray = CreateRecurringPaymentsProfile();        
        $ack = strtoupper($resArray["ACK"]);
        if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
	       pr($resArray);
        }else{
            pr('ERRROR');
        }
    }

    public function get_detail(){
        $res = GetRecurringPaymentsProfileDetails('B-0GP68457DN280314Y');
        pr($res);

    }

    public function new_test(){
        $str = 'B-8D922687M2395522M';
        // B-8D922687M2395522M
        $res = DoReferenceTransaction($str);
        pr($res,1);
    }

    public function paypal_info($token='1CS826997L8535421'){
        $data=GetTransactionDetails($token);
        pr($data,1);
    }

    public function dhk_test(){
        $test=DoReferenceTransaction("B-0GP68457DN280314Y");
        pr($test,1);
    }

    /* ------- Cancel Billing Agreement ------------- */
    public function BillAgreementUpdate($REFERENCEID='B-99F95324GS1942214'){
        $cancel_bill=BillAgreementUpdate($REFERENCEID);
        pr($cancel_bill,1);
    }


}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */