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

    public function paypal_info($token='6GK839763R027910J'){
        $data=GetTransactionDetails($token);
        pr($data,1);
    }
            
}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */