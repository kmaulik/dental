<?php
	$CI = & get_instance();  //get instance, access the CI superobject
	
	/********************************************
	PayPal API Module
	 
	Defines all the global variables and the wrapper functions 
	********************************************/
	define('PROXY_HOST', '127.0.0.1');
	define('PROXY_PORT', '808');

	define('SandboxFlag', true);

	//'------------------------------------
	//' PayPal API Credentials
	//' Replace <API_USERNAME> with your API Username
	//' Replace <API_PASSWORD> with your API Password
	//' Replace <API_SIGNATURE> with your Signature
	//'------------------------------------
	
	define('API_UserName', 'demo.narolainfotech_api1.gmail.com');
	define('API_Password', 'AWK63L4MBFD4VW8L');
	define('API_Signature', 'AFcWxV21C7fd0v3bYYYRCpSSRl31ACJYWuU2SkL5peZ0DszYoNa9AnDc');

	// define('API_UserName', 'vpa_api1.narola.email');
	// define('API_Password', 'SHZWUBFGFA3VCM7L');
	// define('API_Signature', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AI-OweKZBd-QsDk51yu3WG39Jc5i');	

	// BN Code 	is only applicable for partners
	define('sBNCode', 'PP-ECWizard');
	
	
	/*	
	' Define the PayPal Redirect URLs.  
	' 	This is the URL that the buyer is first sent to do authorize payment with their paypal account
	' 	change the URL depending if you are testing on the sandbox or the live PayPal site
	'
	' For the sandbox, the URL is       https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
	' For the live site, the URL is        https://www.paypal.com/webscr&cmd=_express-checkout&token=
	*/
	
	if (SandboxFlag == true) {
		define('API_Endpoint', 'https://api-3t.sandbox.paypal.com/nvp');
		define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=');
	}else{
		define('API_Endpoint', 'https://api-3t.paypal.com/nvp');
		define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=');
	}

	define('USE_PROXY', false);
	define('version', '64');

	// 100$ 50$ x 2 
	
	
	//define('SUBSCRIPTION_PRICE', 1.35);

	/* An express checkout transaction starts with a token, that
	   identifies to PayPal your transaction
	   In this example, when the script sees a token, the script
	   knows that the buyer has already authorized payment through
	   paypal.  If no token was found, the action is to send the buyer
	   to PayPal to first authorize payment
	   */

	/*   2FCCXHFE6LQ92
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
	' Inputs:  
	'		paymentAmount:  	Total value of the shopping cart
	'		currencyCodeType: 	Currency code value the PayPal API
	'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
	'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
	function CallShortcutExpressCheckout($amt,$returnURL, $cancelURL , $desc = 'Dental Payments'){
		global $CI;	
		//------------------------------------------------------------------------------------------------------------------------------------
		// Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation

		$nvpstr="&AMT=".$amt;
		$nvpstr = $nvpstr . "&PAYMENTACTION=Sale";
		$nvpstr = $nvpstr . "&BILLINGAGREEMENTDESCRIPTION=".urlencode($desc);
		$nvpstr = $nvpstr . "&BILLINGTYPE=MerchantInitiatedBillingSingleAgreement";
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&CURRENCYCODE=USD";
		$nvpstr = $nvpstr . "&NOSHIPPING=1";		
				 
		//'--------------------------------------------------------------------------------------------------------------- 
		//' Make the API call to PayPal
		//' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.  
		//' If an error occured, show the resulting errors
		//'---------------------------------------------------------------------------------------------------------------
		$resArray=hash_call("SetExpressCheckout", $nvpstr);
	    return $resArray;
	}

	/*
	'-------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the GetExpressCheckoutDetails API Call.
	'
	' Inputs:  
	'		None
	' Returns: 
	'		The NVP Collection object of the GetExpressCheckoutDetails Call Response.
	'-------------------------------------------------------------------------------------------
	*/
	function GetShippingDetails( $token )
	{
		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
	   
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
	    $nvpstr="&TOKEN=" . $token;

		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, aGetExpressnd provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
	    $resArray=hash_call("GetExpressCheckoutDetails",$nvpstr);
	    $ack = strtoupper($resArray["ACK"]);

		if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{	
			$_SESSION['payer_id'] =	$resArray['PAYERID'];
			$_SESSION['email'] =	$resArray['EMAIL'];
			$_SESSION['firstName'] = $resArray["FIRSTNAME"]; 
			$_SESSION['lastName'] = $resArray["LASTNAME"]; 
			$_SESSION['shipToName'] = $resArray["SHIPTONAME"]; 
			$_SESSION['shipToStreet'] = $resArray["SHIPTOSTREET"]; 
			$_SESSION['shipToCity'] = $resArray["SHIPTOCITY"];
			$_SESSION['shipToState'] = $resArray["SHIPTOSTATE"];
			$_SESSION['shipToZip'] = $resArray["SHIPTOZIP"];
			$_SESSION['shipToCountry'] = $resArray["SHIPTOCOUNTRYCODE"];
		} 
		return $resArray;
	}
	
	/*
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the GetExpressCheckoutDetails API Call.
	'
	' Inputs:  
	'		sBNCode:	The BN code used by PayPal to track the transactions from a given shopping cart.
	' Returns: 
	'		The NVP Collection object of the GetExpressCheckoutDetails Call Response.
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
	function ConfirmPayment( $FinalPaymentAmt )
	{
		/* Gather the information to make the final call to
		   finalize the PayPal payment.  The variable nvpstr
		   holds the name value pairs
		   */
		

		//Format the other parameters that were stored in the session from the previous calls	
		$token 		= urlencode($_SESSION['TOKEN']);
		$paymentType 		= urlencode($_SESSION['PaymentType']);
		$currencyCodeType 	= urlencode($_SESSION['currencyCodeType']);
		$payerID 		= urlencode($_SESSION['payer_id']);

		$serverName 		= urlencode($_SERVER['SERVER_NAME']);

		$nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTACTION=' . $paymentType . '&AMT=' . $FinalPaymentAmt;
		$nvpstr .= '&CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName; 

		 /* Make the call to PayPal to finalize payment
		    If an error occured, show the resulting errors
		    */
		$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);

		//$_SESSION['billing_agreemenet_id']	= $resArray["BILLINGAGREEMENTID"];

		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		$ack = strtoupper($resArray["ACK"]);

		return $resArray;
	}
	
	function CreateRecurringPaymentsProfile(){

		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
		$token 		= urlencode($_SESSION['TOKEN']);
		$email 		= urlencode($_SESSION['email']);
		$shipToName		= urlencode($_SESSION['shipToName']);
		$shipToStreet		= urlencode($_SESSION['shipToStreet']);
		$shipToCity		= urlencode($_SESSION['shipToCity']);
		$shipToState		= urlencode($_SESSION['shipToState']);
		$shipToZip		= urlencode($_SESSION['shipToZip']);
		$shipToCountry	= urlencode($_SESSION['shipToCountry']);
                
        //Temprary test
        if($email == 'hid.narola%40narolainfotech.com'){
            $shipToCountry = 'US';
        }
                
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
		$nvpstr="&TOKEN=".$token;
		#$nvpstr.="&EMAIL=".$email;
		$nvpstr.="&SHIPTONAME=".$shipToName;
		$nvpstr.="&SHIPTOSTREET=".$shipToStreet;
		$nvpstr.="&SHIPTOCITY=".$shipToCity;
		$nvpstr.="&SHIPTOSTATE=".$shipToState;
		$nvpstr.="&SHIPTOZIP=".$shipToZip;
		$nvpstr.="&SHIPTOCOUNTRY=".$shipToCountry;
		//$nvpstr.="&SHIPTOCOUNTRY=US";
		
		$nvpstr.="&PROFILESTARTDATE=".urlencode("2017-02-25T03:05:00Z");

		$nvpstr.="&DESC=".urlencode("Inventory Subscription($" . SUBSCRIPTION_PRICE . " monthly)");
		$nvpstr.="&BILLINGPERIOD=Day";
		$nvpstr.="&BILLINGFREQUENCY=1";
		$nvpstr.="&TOTALBILLINGCYCLES=1";		
		$nvpstr.="&AMT=".SUBSCRIPTION_PRICE;

		$nvpstr.="&CURRENCYCODE=USD";
		$nvpstr.="&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];
		
		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, and provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
		$resArray=hash_call("CreateRecurringPaymentsProfile",$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}
	
	
	function UpdateRecurringPaymentsProfile($data)
	{
		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
		$token 		= urlencode($_SESSION['TOKEN']);
		$email 		= urlencode($_SESSION['email']);
		$shipToName		= urlencode($_SESSION['shipToName']);
		$shipToStreet		= urlencode($_SESSION['shipToStreet']);
		$shipToCity		= urlencode($_SESSION['shipToCity']);
		$shipToState		= urlencode($_SESSION['shipToState']);
		$shipToZip		= urlencode($_SESSION['shipToZip']);
		$shipToCountry	= urlencode($_SESSION['shipToCountry']);
	   
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------

		// Profileid == Array ( [PROFILEID] => I-51FEBYY79CBH [PROFILESTATUS] => ActiveProfile [TIMESTAMP] => 2015-11-08T07:42:00Z [CORRELATIONID] => ff08c6493c578 [ACK] => Success [VERSION] => 64 [BUILD] => 000000 ) Thank you for your payment.
		// $action = array('Cancel', 'Suspend', 'Reactivate');
		
		$profile_id	= urlencode($data['profile_id']);
		$action	= urlencode($data['action']);
		$note	= urlencode($data['note']);
		
		$nvpstr="&PROFILEID=".$profile_id;
		$nvpstr.="&ACTION=".$action;
		$nvpstr.="&NOTE=".$note;
		
		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, and provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
		$resArray=hash_call("UpdateRecurringPaymentsProfile",$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}
	
	function GetRecurringPaymentsProfileDetails($profileid)
	{
		$nvpstr="&PROFILEID=" . $profileid;
		
		//'---------------------------------------------------------------------------
		$resArray=hash_call("GetRecurringPaymentsProfileDetails",$nvpstr);
		//$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}
	
	function ManageRecurringPaymentsProfileStatus($data=array())
	{
		//$action = array('Cancel','Suspend','Reactivate');
		$nvpstr="&PROFILEID=" . $data['profile_id'];
		$nvpstr.="&ACTION=" . $data['action'];
		$nvpstr.="&NOTE=" . $data['note'];
		
		//'---------------------------------------------------------------------------
		$resArray=hash_call("ManageRecurringPaymentsProfileStatus",$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}
	
	function TransactionSearch($data=array())
	{
		$nvpstr="&STARTDATE=" . $data['startdate'];
		$nvpstr.="&PROFILEID=" . $data['profile_id'];
		
		//'---------------------------------------------------------------------------
		$resArray=hash_call("TransactionSearch",$nvpstr);
		//$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}

	// v! do not make changes into below function 
	/*------------- Get Transaction Details based on transaction Id ------------ */
	function GetTransactionDetails($token){
		$nvpstr="&TRANSACTIONID=" . $token;		
		//'---------------------------------------------------------------------------
		$resArray=hash_call("GetTransactionDetails",$nvpstr);
		//$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}

	/*
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	This function makes a DoDirectPayment API call
	'
	' Inputs:  
	'		paymentType:		paymentType has to be one of the following values: Sale or Order or Authorization
	'		paymentAmount:  	total value of the shopping cart
	'		currencyCode:	 	currency code value the PayPal API
	'		firstName:			first name as it appears on credit card
	'		lastName:			last name as it appears on credit card
	'		street:				buyer's street address line as it appears on credit card
	'		city:				buyer's city
	'		state:				buyer's state
	'		countryCode:		buyer's country code
	'		zip:				buyer's zip
	'		creditCardType:		buyer's credit card type (i.e. Visa, MasterCard ... )
	'		creditCardNumber:	buyers credit card number without any spaces, dashes or any other characters
	'		expDate:			credit card expiration date
	'		cvv2:				Card Verification Value 
	'		
	'-------------------------------------------------------------------------------------------
	'		
	' Returns: 
	'		The NVP Collection object of the DoDirectPayment Call Response.
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/


	function DirectPayment( $paymentType, $paymentAmount, $creditCardType, $creditCardNumber,
							$expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, 
							$countryCode, $currencyCode )
	{
		//Construct the parameter string that describes DoDirectPayment
		$nvpstr = "&AMT=" . $paymentAmount;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $currencyCode;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&CREDITCARDTYPE=" . $creditCardType;
		$nvpstr = $nvpstr . "&ACCT=" . $creditCardNumber;
		$nvpstr = $nvpstr . "&EXPDATE=" . $expDate;
		$nvpstr = $nvpstr . "&CVV2=" . $cvv2;
		$nvpstr = $nvpstr . "&FIRSTNAME=" . $firstName;
		$nvpstr = $nvpstr . "&LASTNAME=" . $lastName;
		$nvpstr = $nvpstr . "&STREET=" . $street;
		$nvpstr = $nvpstr . "&CITY=" . $city;
		$nvpstr = $nvpstr . "&STATE=" . $state;
		$nvpstr = $nvpstr . "&COUNTRYCODE=" . $countryCode;
		$nvpstr = $nvpstr . "&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];

		$resArray=hash_call("DoDirectPayment", $nvpstr);

		return $resArray;
	}



	/**
	  *'-------------------------------------------------------------------------------------------------------------------------------------------
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	  *'-------------------------------------------------------------------------------------------------------------------------------------------
	*/
	function hash_call($methodName,$nvpStr)
	{
		//declaring of global variables
		//global $API_Endpoint, $version, $API_UserName, $API_Password, $API_Signature;
		//global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
		//global $gv_ApiErrorURL;
		//global $sBNCode;
		
		//echo " ### ".$version;exit;

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if(USE_PROXY)
			curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST. ":" . PROXY_PORT); 

		//NVPRequest for submitting to server
		$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode(version) . "&PWD=" . urlencode(API_Password) . "&USER=" . urlencode(API_UserName) . "&SIGNATURE=" . urlencode(API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode(sBNCode);
		
		//var_dump($nvpreq);
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

		//getting response from server
		$response = curl_exec($ch);
		
		//echo "####";
		//print_r($response);echo "####";
		//echo $nvpreq;exit;

		//convrting NVPResponse to an Associative Array
		$nvpResArray=deformatNVP($response);
		$nvpReqArray=deformatNVP($nvpreq);		
		
		if (curl_errno($ch)) 
		{
			// moving to display page to display curl errors
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);

			  //Execute the Error handling module to display errors. 
		} 
		else 
		{
			 //closing the curl
		  	curl_close($ch);
		}

		return $nvpResArray;
	}

	/*'----------------------------------------------------------------------------------
	 Purpose: Redirects to PayPal.com site.
	 Inputs:  NVP string.
	 Returns: 
	----------------------------------------------------------------------------------
	*/
	function RedirectToPayPal ( $token )
	{
		// Redirect to paypal.com here
		$payPalURL = PAYPAL_URL . $token;
		header("Location: ".$payPalURL);
	}

	
	/*'----------------------------------------------------------------------------------
	 * This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	   ----------------------------------------------------------------------------------
	 */
	function deformatNVP($nvpstr)
	{
		$intial=0;
	 	$nvpArray = array();

		while(strlen($nvpstr))
		{
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}
	
	function convertUTC($time)
	{
		$utc = $time;
		$dt = new DateTime($utc);
		$tz = new DateTimeZone('GMT'); // or whatever zone you're after

		$dt->setTimezone($tz);
		$time = $dt->format('Y-m-d H:i:s');
		
		return $time;
	}
	
	function generateAccountNo($length = 6) {
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		//return 'INV'.$randomString;
		return $randomString;
	}

	 //---------------- CreateBillingAgreement @DHK -------
	function CreateBillingAgreement($token){
		$nvpstr="&TOKEN=" . $token;
		$nvpstr .="&VERSION=86";
		//'---------------------------------------------------------------------------
		$resArray=hash_call("CreateBillingAgreement",$nvpstr);
		//$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}

	// v! Do not make any changes into this function
	//---------------- DoExpressCheckoutPayment @DHK -------
	function DoExpressCheckoutPayment($payer_id,$token,$amt){

		$nvpstr ="&PAYERID=" . $payer_id;
		$nvpstr .="&PAYMENTREQUEST_0_PAYMENTACTION=Sale";
		$nvpstr .="&PAYMENTREQUEST_0_AMT=".$amt;
		$nvpstr .="&VERSION=86";
		$nvpstr .="&TOKEN=".$token;
		
		//'---------------------------------------------------------------------------
		$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);
		//$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}

	// v! Do not make any changes into this function
	//---------------- DoReferenceTransaction @DHK --------
	function DoReferenceTransaction($bill_id,$amt='42'){

		$nvpstr ="&VERSION=86";
		$nvpstr .="&AMT=".$amt;
		$nvpstr .="&CURRENCYCODE=USD";		
		$nvpstr .="&PAYMENTACTION=SALE";
		$nvpstr .="&REFERENCEID=".$bill_id;		

		$resArray=hash_call("DoReferenceTransaction",$nvpstr);		
		return $resArray;
	}

	// v! Do not make any changes into this function
	//----------------Cancel Billing Agreement - BillAgreementUpdate @DHK -----------
	function get_detail_billing_agreement($REFERENCEID,$STATUS=''){

		$nvpstr ="&VERSION=86";
		$nvpstr .="&REFERENCEID=".$REFERENCEID;
		//$nvpstr .="&BILLINGAGREEMENTSTATUS=Canceled";
		$nvpstr .="&BILLINGAGREEMENTSTATUS=".$STATUS;
		$resArray=hash_call("BillAgreementUpdate",$nvpstr);
		return $resArray;
	}

	// v! Do not make any changes into this function
	//----------------Cancel Billing Agreement - BillAgreementUpdate @DHK -----------
	function cancel_billing_agreement($REFERENCEID='B-94X10474A33445353'){

		$nvpstr ="&VERSION=86";
		$nvpstr .="&REFERENCEID=".$REFERENCEID;
		$nvpstr .="&BILLINGAGREEMENTSTATUS=Canceled";		
		$resArray=hash_call("BillAgreementUpdate",$nvpstr);
		return $resArray;
	}

	//B-34X69770KM776381D

?>
