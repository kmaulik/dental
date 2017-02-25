<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public $name = '';
    public $subscription_price = 50.75;

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

        pr($_REQUEST,1);
        if (isset($_REQUEST['token'])) {
            $token = $_REQUEST['token'];
            //echo "Token => ".$token."<br/>";
              $resarr=CreateBillingAgreement($token);
              //$resarr11=GetShippingDetails($token);
              pr($resarr,1);          
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
        //$refarray1=DoReferenceTransaction($resArray1);
        // $this->paypal_info($resArray1['TRANSACTIONID']);
        $resArray = CreateRecurringPaymentsProfile();
        //pr($refarray1,1);
        $ack = strtoupper($resArray["ACK"]);
        if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
	       pr($resArray);
        }
    }

    public function get_detail(){

        $res = GetRecurringPaymentsProfileDetails('I-S1AT56H23RXL');
        pr($res,1);

    }


    public function paypal_info($token='3LC62956B2785522X'){
        $data=GetTransactionDetails($token);
        pr($data,1);
    }

    public function google_map(){
        $this->load->library('googlemaps');

        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'myPlaceTextBox';

        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport

        $config['placesAutocompleteOnChange'] = 'alert(\'You selected a place\');';
        
        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        pr($data);

        $this->load->view('test_view', $data);
    }

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */