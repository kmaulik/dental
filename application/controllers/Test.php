<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public $name = '';
    public $subscription_price = 25.99;

	public function __construct(){
		parent::__construct();
		$this->load->helper(['paypal_helper']);	
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
        $ack = strtoupper($resArray["ACK"]);
    	if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
            RedirectToPayPal($resArray["TOKEN"]);
        } else {

        }
	}

	public function review() {
        $data = array();

        $data['back'] = base_url().'test';
        $data['subscribe'] = base_url().'test/subscribe';

        if (isset($_REQUEST['token'])) {
            $token = $_REQUEST['token'];
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
	        echo "IFF";
        }
    }

    public function get_detail(){

        $res = GetRecurringPaymentsProfileDetails('I-H285BA9SF95D');
        pr($res);

    }

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */