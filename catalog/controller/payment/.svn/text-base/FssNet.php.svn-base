<?php
/**
 * Client class for the FssNet payment page.
 *
 */ 
 
class ControllerPaymentFssNet extends Controller {

	protected function index() {
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('Inside ControllerPaymentFssNet::index() method');
		}		
		
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

        $this->data['action'] = $this->getLink('payment/FssNet/paymentredirect', '', 'SSL');

		$this->load->model('checkout/order');
		
		$this->id       = 'payment';
        $templateFile   = "FssNet.tpl";
        
        if ($this->request->get['route'] != 'checkout/guest_step_3') {
        	$this->data['back'] = $this->getLink('checkout/payment', '', 'SSL');
        } 
        else {
        	$this->data['back'] = $this->getLink('checkout/guest_step_2', '', 'SSL');
        }
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/' . $templateFile)) {
			$this->template = $this->config->get('config_template') . '/template/payment/' . $templateFile;
		} else {
			$this->template = 'default/template/payment/' . $templateFile;
		}
				
		$this->render();	
	}	
	
	public function paymentredirect(){
		//$respURL = "http://opencart.ramchandramission.org/hdfcpgresponse/callback";
		//$errorURL = "http://opencart.ramchandramission.org/hdfcpgfailure/callback";
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('paymentredirect:::: ResponURL  =  '  . $this->config->get('FssNet_RedirectURL'));
			$this->log->write('paymentredirect:::: ErrorURL   =  ' . $this->config->get('FssNet_ErrorURL'));
		}
		
		$respURL = $this->config->get('FssNet_RedirectURL');
		$errorURL = $this->config->get('FssNet_ErrorURL');
		
		$this->load->model('checkout/order');
		
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('Inside FssNet::paymentdirect() method ::: order_id = ' . $this->session->data['order_id']);
		}		
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		if($this->config->get('FssNet_debuglog')){		
			$this->log->write('FssNet::paymentdirect_order_info : ' . print_r($order_info, true));
		}
		
		//$url = "https://securepg.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet"; //production URL
		//$url = "https://securepgtest.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet"; //test URL
		$param= "id=" . $this->config->get('FssNet_MID') . 
				"&password=" . $this->config->get('FssNet_Password') . 
				"&action=" . $this->config->get('FssNet_action_code') . 
				"&langid=" . $this->config->get('FssNet_tran_lang') . 
				"&currencycode=" . $this->config->get('FssNet_currency_code') . 
				"&amt=" . trim(number_format($order_info['total'], 1, '.', '')) . 
				"&responseURL=" . $respURL . 
				"&errorURL=" . $errorURL . 
				"&trackid=" . $order_info['order_id'] . 
				"&udf1=" . "new_order" . 
			    "&udf2=" . $order_info['total'] .
				"&udf3=" . $order_info['telephone'] . 
				"&udf4=" . preg_replace("/[^a-zA-Z]/", "", $order_info['payment_city']);
				//"&udf5=" . "Test5";
				
			 /*       "&udf1=Test1" .
				"&udf2=" . $order_info['email'] . 
			        "&udf3=Test3" .
			        "&udf4=Test4" .
			        "&udf5=Test5";  */

		/*Hashing Logic - Start*/
		$hashTID = trim($this->config->get('FssNet_MID'));
		$hashTrackID = trim($order_info['order_id']);
		$hashAmt = trim(number_format($order_info['total'], 1, '.', ''));
		$hashCurrency = trim($this->config->get('FssNet_currency_code'));
		$hashAction = trim($this->config->get('FssNet_action_code'));
		
		//Creating hashing string 
		$str = trim($hashTID . $hashTrackID . $hashAmt . $hashCurrency . $hashAction);
		
		//Hash method will return Hashed valued of above string
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('controller_payment_fssnet::::paymentDirection >>>>>> --- hashString before hashing= ' . $str);
		}
		
		$hashString= hash('sha256', $str);
		
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('controller_payment_fssnet::::paymentDirection >>>>>> --- hashString after hashing= ' . $hashString);
		}
		
		$udf5="&udf5=" . $hashString; // Pass Calculated Hashed Value in UDF5 Field		
		/*Hashing Logic - End*/
		
		$param = $param . $udf5;
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('FssNet:: param = ' . $param);
		}
		
		$this->prepareTransaction($param, $order_info['order_id']);
	}
	
	public function prepareTransaction($param, $order_id) {
		$this->load->model('checkout/order');
		
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('Inside FssNet::prepareTransaction() method');
		}

		if (!$this->config->get('FssNet_test')) {
			$url = "https://securepg.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet"; //Production URL
		} else {
			$url = "https://securepgtest.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet"; //test URL
		}
		
		if($this->config->get('FssNet_debuglog')){
			$this->log->write(' ssNet::prepareTransaction :::: SecurePG URL =  ' . $url);
		}
		
		//$url = "https://securepg.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet"; //Production URL
		//$url = "https://securepgtest.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet"; //test URL
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('prepareTransaction :: param = ' . $param);
		}
	
		$ch = curl_init() or die(curl_error());
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$param);
		curl_setopt($ch, CURLOPT_PORT, 443); // port 443
		curl_setopt($ch, CURLOPT_URL,$url);// here the request is sent to payment gateway
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0); //create a SSL connection object server-to-server
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		$data1=curl_exec($ch) or die(curl_error());
	
		curl_close($ch);
	
		$response = $data1;
	
		try
		{
			$index = strpos($response,"!-");
			$ErrorCheck = substr($response, 1, $index-1);//This line will find Error Keyword in response
			 
			/*$TranTrackid=isset($_POST['MTrackid']) ? $_POST['MTrackid'] : '';
			$TranAmount=isset($_POST['MAmount']) ? $_POST['MAmount'] : '';*/
			if($this->config->get('FssNet_debuglog')){ 
				$this->log->write('FssNet::paymentredirect::: ErrorCheck ' . $ErrorCheck);
			}
			 
			if($ErrorCheck == 'ERROR')//This block will check for Error in response
			{
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::paymentredirect::: ErrorCheck - Inside ErrorCheck if loop');
				}
				 
				//$errorMsg = "Message=Transaction Failed&ResTrackId=" . $TranTrackid . "&ResAmount=" . $TranAmount . "&ResError= " . $response;
				$response1 = substr($response, $index+2, strlen($response));
				$errorMsg = "&Message= " . $response1;
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::paymentredirect::: ErrorCheck - order_id = ' . $order_id);
				}
				
				$this->model_checkout_order->cancelOrder($order_id, $this->config->get('FssNet_failed_status_id'));
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::paymentredirect::: ErrorCheck - errorMsg = ' . $errorMsg);
				}
				$this->redirect($this->url->link('checkout/failure', $errorMsg, 'SSL'));
				
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::paymentredirect::: ErrorCheck - after calling check/failure ');
				}
				/*$failedurl='https://shpt.in/hdfcpg/FailedTRAN.php?Message=Transaction Failed&ResTrackId='.$TranTrackid.'&ResAmount='.$TranAmount.'&ResError='.$response;
				 header("location:". $failedurl );*/
			}
			else
			{
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::paymentredirect::: ErrorCheck - Inside ErrorCheck ELSE loop');
				}
				//echo $response;
				// If Payment Gateway response has Payment ID & Pay page URL
				$i =  strpos($response,":");
				// Merchant MUST map (update) the Payment ID received with the merchant Track Id in his database at this place.
				$paymentId = substr($response, 0, $i);
				//Store payment id in order table for future reference
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('Before calling FssNet->updatePaymentID() method ---- order_id = ' . $order_id);
					$this->log->write('Before calling FssNet->updatePaymentID() method   --- paymentid = ' . $paymentId);
				}
				$this->model_checkout_order->updatePaymentID($order_id, $paymentId);
				
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('After calling FssNet->updatePaymentID() method');
				}
				$paymentPage = substr( $response, $i + 1);
				// here redirecting the customer browser from ME site to Payment Gateway Page with the Payment ID
				$r = $paymentPage . "?PaymentID=" . $paymentId;
	
				header("location:". $r );
			}
	
			return true;
		}
		catch(Exception $e)
		{
			var_dump($e->getMessage());
		}
	
		return false;
	}
	
	//Response callback function triggered when FSS Net sends a response
    public function responseCallback(){
    	if($this->config->get('FssNet_debuglog')){
    		$this->log->write('controller_payment_fssnet:::: Inside responseCallback function');
			$this->log->write('controller_payment_fssnet:::: _POST == ' . print_r($_POST, TRUE));
    	}

		// Get the IP address of the sender's page and make sure its from the Payment Gateway
		//$strResponseIPAdd = getenv('REMOTE_ADDR');
		$strResponseIPAdd = $this->get_remote_ip();
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('controller_payment_fssnet:::: IP Address == ' . $strResponseIPAdd);		
			$this->log->write('controller_payment_fssnet:::: strResponseIPAdd  =    ' . $strResponseIPAdd);
		}
	
		$this->load->model('checkout/order');

    	/* LIST OF PARAMETERS RECEIVED BY MERCHANT FROM PAYMENT GATEWAY START HERE */
    	$ResErrorText= isset($_POST['ErrorText']) ? $_POST['ErrorText'] : ''; 	//Error Text/message
    	$ResPaymentId = isset($_POST['paymentid']) ? $_POST['paymentid'] : '';	//Payment Id
    	$ResTrackID = isset($_POST['trackid']) ? $_POST['trackid'] : '';        //Merchant Track ID
    	$ResErrorNo = isset($_POST['Error']) ? $_POST['Error'] : '';            //Error Number

    	//To collect transaction result
    	$ResResult = isset($_POST['result']) ? $_POST['result'] : '';           //Transaction Result
    	$ResPosdate = isset($_POST['postdate']) ? $_POST['postdate'] : '';      //Postdate
    	
    	//To collect Payment Gateway Transaction ID, this value will be used in dual verification request
    	$ResTranId = isset($_POST['tranid']) ? $_POST['tranid'] : '';           //Transaction ID
    	$ResAuth = isset($_POST['auth']) ? $_POST['auth'] : '';                 //Auth Code
    	$ResAVR = isset($_POST['avr']) ? $_POST['avr'] : '';                    //TRANSACTION avr
    	$ResRef = isset($_POST['ref']) ? $_POST['ref'] : '';                    //Reference Number also called Seq Number
    	
    	//To collect amount from response
    	$ResAmount = isset($_POST['amt']) ? $_POST['amt'] : '';                 //Transaction Amount
    	
    	$Resudf1 = isset($_POST['udf1']) ? $_POST['udf1'] : '';                  //UDF1
    	$Resudf2 = isset($_POST['udf2']) ? $_POST['udf2'] : '';                  //UDF2
    	$Resudf3 = isset($_POST['udf3']) ? $_POST['udf3'] : '';                  //UDF3
    	$Resudf4 = isset($_POST['udf4']) ? $_POST['udf4'] : '';                  //UDF4
    	$Resudf5 = isset($_POST['udf5']) ? $_POST['udf5'] : '';                  //UDF5
    	/* LIST OF PARAMETERS RECEIVED BY MERCHANT FROM PAYMENT GATEWAY ENDS HERE */

    	if (!$this->config->get('FssNet_test')) {
    		$valid_ips = array('221.134.101.187', '221.134.101.175', '221.134.101.166'); //production IPs
    	}
    	else{
    		$valid_ips = array('221.134.101.174', '221.134.101.169'); // test IPs
    	}

    	if(in_array( $strResponseIPAdd, $valid_ips))
    	{
    		//Save response received from FSSNet into fssnet_response table
    		if($this->config->get('FssNet_debuglog')){
    			$this->log->write('controller_payment_fssnet:::: before calling saveFssNetResponse function');
    		}
    		$this->model_checkout_order->saveFSSNetResponse($strResponseIPAdd, $ResErrorNo, $ResErrorText, $ResPaymentId, $ResTrackID, $ResResult, $ResTranId, $ResAmount);
    		
    		//Check for Errors
    		if ( $ResErrorNo == '' ) {
    			//check result is captured or approved i.e. successful
    			if ($ResResult == 'CAPTURED' || $ResResult == 'APPROVED')
    			{
    				//==================PARAMETER VALIDATION CODE ===================================================
    				/*
    				 //The Below condition will check the Required Parameter From PG side Blank or not,if any field is blank
    				//in the below condition then it will redirected to Failed pages with proper message.
    				*/
    				if ($ResPaymentId == '' || $ResTrackID == '' || $ResTranId == '' || $ResAuth == '' || $ResRef == '' || $ResAmount == '')
    				{
    					$this->model_checkout_order->cancelOrder($ResTrackID, $this->config->get('FssNet_failed_status_id'));
    					$errorMsg = "Message=PARMETER VALIDATION FAILED";
    					$this->redirect($this->url->link('checkout/failure', $errorMsg, 'SSL'));
    				}
    				else
    				{
    					if($this->config->get('FssNet_debuglog')){
    						$this->log->write('controller_payment_fssnet:::: parameter validation is successful. Calling Dual verification');
    					}
    					
    					$hashTraportalID = $this->config->get('FssNet_MID');
    					//$this->log->write('controller_payment_fssnet:::: Dual verification -- hashTraportalID = ' . $hashTraportalID);
    					$hashPassword = $this->config->get('FssNet_Password');
    					//$this->log->write('controller_payment_fssnet:::: Dual verification -- hashPassword = ' . $hashPassword);
    					
    					//===================PARAMETER VALIDATION CONDITION END=========================================
    					//If result is CAPTURED or APPROVED then below Code is execute for dual inquiry    					
    					//ID given by bank to Merchant (Tranportal ID), same iD that was passed in initial request
    					$ReqTranportalId = "<id>" . $hashTraportalID . "</id>";
    					
    					//Password given by bank to merchant (Tranportal Password), same password that was passed in initial request
    					$ReqTranportalPassword = "<password>" . $hashPassword . "</password>";
    					
    					// Pass DUAL VERIFICATION action code, always pass "8" for DUAL VERIFICATION
    					$INQAction = "<action>8</action>";
    					
    					//Pass PG Transaction ID for Dual Verification
    					$INQTransId  = "<transid>" . $ResTranId . "</transid>";
    					
    					//create string for request of input parameters
    					$INQRequest = $ReqTranportalId . $ReqTranportalPassword . $INQAction . $INQTransId;
    					
    					if($this->config->get('FssNet_debuglog')){
    						$this->log->write(' ssNet::prepareTransaction :::: Dual INQRequest =  ' . $INQRequest);
    					}
    					
    					//DUAL VERIFIACTION URL, this is test environment URL, contact bank for production DUAL Verification URL
    					if (!$this->config->get('FssNet_test')) {
    						$INQUrl = "https://securepg.fssnet.co.in/pgway/servlet/TranPortalXMLServlet"; //Production URL
    					} else {
    						$INQUrl = "https://securepgtest.fssnet.co.in/pgway/servlet/TranPortalXMLServlet"; //test URL
    					}
    					
    					if($this->config->get('FssNet_debuglog')){
    						$this->log->write(' ssNet::prepareTransaction :::: Dual INQUrl =  ' . $INQUrl);
    					}
    					//$INQUrl = "https://securepgtest.fssnet.co.in/pgway/servlet/TranPortalXMLServlet";
    					
    					//PHP FUNCTION for connection and posting the request ..starts here
    					$dvreq = curl_init() or die(curl_error());
    					curl_setopt($dvreq, CURLOPT_POST,1);
    					curl_setopt($dvreq, CURLOPT_POSTFIELDS,$INQRequest);
    					curl_setopt($dvreq, CURLOPT_URL,$INQUrl);
    					curl_setopt($dvreq, CURLOPT_PORT, 443);
    					curl_setopt($dvreq, CURLOPT_RETURNTRANSFER, 1);
    					curl_setopt($dvreq, CURLOPT_SSL_VERIFYHOST,0);
    					curl_setopt($dvreq, CURLOPT_SSL_VERIFYPEER,0);
    					$dataret=curl_exec($dvreq) or die(curl_error());
    					curl_close($dvreq);
    					//PHP FUNCTION for connection and posting the request ..ends here
    					
    					//XML response received for DUAL VERIFICATION
    					$TranInqResponse = $dataret;
    					$GEnXMLForm="<xmltg>" . $TranInqResponse . "</xmltg>";
    					$xmlSTR = simplexml_load_string( $GEnXMLForm, null, true);
    					 
    					//Collect DUAL VERIFICATION RESULT
    					$INQCheck = $xmlSTR->result;
    					if($this->config->get('FssNet_debuglog')){
    						$this->log->write('controller_payment_fssnet::::responseCallback --- INQCheck = ' . $INQCheck);
    					}
    					
    					//If DUAL VERIFICATION RESULT is CAPTURED or APPROVED or SUCCESS
    					if ($INQCheck == 'CAPTURED' || $INQCheck == 'APPROVED' || $INQCheck == 'SUCCESS')
    					{
    						//Collect DUAL VERIFICATION RESULT
    					
    						$INQResResult 	= $xmlSTR->result;//It will give DualInquiry Result
    						$INQResAmount 	= $xmlSTR->amt;//It will give Amount
    						$INQResTrackId 	= $xmlSTR->trackid;//It will give TrackID ENROLLED
    						$INQResPayid 	= $xmlSTR->payid;//It will give payid
    						$INQResRef 		= $xmlSTR->ref;//It will give Ref.NO.
    						$INQResTranid 	= $xmlSTR->tranid;//It will give tranid
    						
    						$INQResAutht 	= $xmlSTR->auth;//It will give Auth
    						$INQResAvr 		= $xmlSTR->avr;//It will give AVR
    						$INQResPostdate = $xmlSTR->postdate;//It will give  postdate
    						$INQResUdf1 	= $xmlSTR->udf1;//It will give udf1
    						$INQResUdf2 	= $xmlSTR->udf2;//It will give udf2
    						$INQResUdf3 	= $xmlSTR->udf3;//It will give udf3
    						$INQResUdf4 	= $xmlSTR->udf4;//It will give udf4
    						$INQResUdf5 	= $xmlSTR->udf5;//It will give udf5
    						
    						$hashTraportalID = $this->config->get('FssNet_MID');
    						if($this->config->get('FssNet_debuglog')){
    							$this->log->write('controller_payment_fssnet::::responseCallback --- hashTraportalID = ' . $hashTraportalID);
    						}
    						$hashString = ""; //declaration of Hashing String
    						
    						$hashString = trim($hashTraportalID);
    							
    						//Below code creates the Hashing String. Also it will check NULL and blank parmeters and exclude from the hashing string
    						if ($ResTrackID != '' && $ResTrackID != null )
    							$hashString = trim($hashString) . trim($ResTrackID);
    						if ($ResAmount != '' && $ResAmount != null )
    							$hashString = trim($hashString) . trim($ResAmount);
    						$hashString = trim($hashString). trim($this->config->get('FssNet_currency_code'));
    						$hashString = trim($hashString). trim($this->config->get('FssNet_action_code'));
    						
    						if($this->config->get('FssNet_debuglog')){
    							$this->log->write('controller_payment_fssnet::::responseCallback --- hashString = ' . $hashString);
    						}
    						/*if ($ResResult != '' && $ResResult != null )
    							$hashString = trim($hashString) . trim($ResResult);
    						if ($ResPaymentId != '' && $ResPaymentId != null )
    							$hashString = trim($hashString) . trim($ResPaymentId);
    						if ($ResRef != '' && $ResRef != null )
    							$hashString = trim($hashString) . trim($ResRef);
    						if ($ResAuth != '' && $ResAuth != null )
    							$hashString = trim($hashString) . trim($ResAuth);
    						if ($ResTranId != '' && $ResTranId != null )
    							$hashString = trim($hashString) . trim($ResTranId);*/
    						
    						//Use sha256 method which is defined below for Hashing. It will return Hashed value of above string
    						$hashValue= hash('sha256', $hashString);
    						if($this->config->get('FssNet_debuglog')){
    							$this->log->write('controller_payment_fssnet::::responseCallback --- hashString after hasing= ' . $hashValue);
    						}
    						
    						if($hashValue == $Resudf5)
    						{
    							//$REDIRECT = 'REDIRECT=http://shpt.in/index.php?route=payment/FssNet/callback' . "&result=" . $INQResResult . "&track_id=" . $INQResTrackId . "&amount=" . $INQResAmount . "&payment_id=" . $INQResPayid . "&ref=" . $INQResRef . "&tran_id=" . $INQResTranid . "&error=" . $ResErrorText;
    							//echo $REDIRECT;
    							$this->processOrder($INQResResult, $INQResTrackId, $INQResAmount, $INQResPayid, $INQResRef, $INQResTranid, $ResErrorText);
    						}
    					}
    					else{
    						$this->model_checkout_order->cancelOrder($ResTrackID, $this->config->get('FssNet_failed_status_id'));
    						$redirectURL = $this->url->link ('checkout/failure', $ResResult, 'SSL');
    						if($this->config->get('FssNet_debuglog')){
    							$this->log->write('FssNet::responseCallback :::::  redirectURL =   ' . $redirectURL);
    						}
    						$REDIRECT = 'REDIRECT=' . $redirectURL;
    						echo $REDIRECT;
    					}
    				}
    			}
    			else{
    				$this->model_checkout_order->cancelOrder($ResTrackID, $this->config->get('FssNet_failed_status_id'));
    				$errorMsg = 'Message=' . $ResResult;
    				$redirectURL = $this->url->link ('checkout/failure', $errorMsg, 'SSL');
    				if($this->config->get('FssNet_debuglog')){
    					$this->log->write('FssNet::responseCallback :::::  redirectURL =   ' . $redirectURL);
    				}
    				$REDIRECT = 'REDIRECT=' . $redirectURL;
    				echo $REDIRECT;
    			}
    		}
    	}
    	// IP address of sender is not acceptable
    	else
    	{
    		if($this->config->get('FssNet_debuglog')){
    			$this->log->write('controller_payment_fssnet:::: IP Address of sender is not acceptable');
    		}
    		//Cancel the order. Set order_status to 'Cancelled'
    		$this->model_checkout_order->cancelOrder($ResTrackID, $this->config->get('FssNet_failed_status_id'));
    		$errorMsg = "Message=--IP MISSMATCH-- Error ";
    		if($this->config->get('FssNet_debuglog')){
    			$this->log->write($errorMsg);
    		}
    		//$this->redirect($this->url->link('checkout/failure', $errorMsg, 'SSL'));
    		$redirectURL = $this->url->link ('checkout/failure', $errorMsg, 'SSL');
    		if($this->config->get('FssNet_debuglog')){
    			$this->log->write('FssNet::responseCallback :::::  redirectURL =   ' . $redirectURL);
    		}
    		$REDIRECT = 'REDIRECT=' . $redirectURL;
    		echo $REDIRECT;
    		//$this->displayFailure($errorMsg);
    	}
    }

    //Response callback function triggered when FSS Net sends a response
    public function failureCallback(){
    	if($this->config->get('FssNet_debuglog')){
    		$this->log->write('controller_payment_fssnet:::: Inside failureCallback function');
    	}
    	$strMessage =  isset($_GET['Message']) ? $_GET['Message'] : '';
    	$strMTRCKID =  isset($_GET['ResTrackId']) ? $_GET['ResTrackId'] : '';
    	$strAmt =  isset($_GET['ResAmount']) ? $_GET['ResAmount'] : '';
    	$strError =  isset($_GET['ResError']) ? $_GET['ResError'] : '';
    	
    	$errorMsg = "Transaction Status = " . $strMessage . "  Merchant Reference No:[TRACK_ID] = " . $strMTRCKID; 
    	
    	$this->redirect($this->url->link('checkout/failure', $errorMsg, 'SSL'));
    	//$this->displayFailure ($errorMsg, $this->config->get('FssNet_failed_status_id'));
    }
    
    public function callback() {
    	$this->load->model('checkout/order');
    	$this->language->load('payment/FssNet');
    	 
    	$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
    	 
    	$order_id = $order_info['order_id'];
    	 
    	if($this->validateresponse($order_id)){
    		$message = "FssNet payment module:\n";
    		$message .= "Received a new transaction status callback from " . $_SERVER["REMOTE_ADDR"] . ".\n";
    
    		if(isset($_GET['payment_id'])){
    			$ResPayId = $_GET['payment_id'];
    		}
    		else{
    			$ResPayId = 0;
    		}
    		if(isset($_GET['ref'])){
    			$ResRefId = $_GET['ref'];
    		}
    		else{
    			$ResRefId = 0;
    		}
    		if(isset($_GET['tran_id'])){
    			$ResTranId = $_GET['tran_id'];
    		}
    		else{
    			$ResTranId = 0;
    		}
    		if(isset($_GET['error'])){
    			$ResError = $_GET['error'];
    		}
    		else{
    			$ResError = '';
    		}
    		$message .= "Error code: " . $ResError . "\n";
    
    		if ($ResError != '') {
    			$message .= "Error message: " . $ResError . "\n";
    			$message .= "Transaction ID: " . $ResTranId . "\n";
    			$this->model_checkout_order->confirm($order_id, $this->config->get('FssNet_failed_status_id'));
    			$this->model_checkout_order->update($order_id, $this->config->get('FssNet_failed_status_id'), $message, false);
    			$this->displayFailure ($this->language->get('error_declined'), $this->config->get('FssNet_failed_status_id'));
    		}
    		else{
    			$this->model_checkout_order->confirm($order_id, $this->config->get('FssNet_success_status_id'), 'Transaction Id: ' . $ResTranId, true, $ResPayId, $ResRefId, $ResTranId);
    			$this->model_checkout_order->update($order_id, $this->config->get('FssNet_success_status_id'), $message, false);
    			$this->debugLog($message);
    
    			// Send a response to mark this transaction as notified
    			$this->redirect( $this->getLink ('checkout/success', '', 'SSL'));
    		}
    
    		//$this->model_checkout_order->confirm($INQResTrackId, $INQResPayid);
    	}
    	else{
    		if(isset($_GET['payment_id'])){
    			$ResPayId = $_GET['payment_id'];
    		}
    		else{
    			$ResPayId = 0;
    		}
    
    		if(isset($_GET['ref'])){
    			$ResRefId = $_GET['ref'];
    		}
    		else{
    			$ResRefId = 0;
    		}
    
    		if(isset($_GET['tran_id'])){
    			$ResTranId = $_GET['tran_id'];
    		}
    		else{
    			$ResTranId = 0;
    		}
    		if(isset($_GET['error'])){
    			$ResError = $_GET['error'];
    		}
    		else{
    			$ResError = '';
    		}
    		$message = "FssNet payment module:\n";
    		$this->debugLog("FssNet payment module (callback): Unable to get order information: " . $order_id);
    		$message .= "Error message: " . $ResError . "\n";
    		$message .= "Transaction ID: " . $ResTranId . "\n";
    		$this->model_checkout_order->confirm($order_id, $this->config->get('FssNet_failed_status_id'), 'Transaction Id: ' . $ResTranId, true, $ResPayId, $ResRefId, $ResTranId);
    		$this->model_checkout_order->update($order_id, $this->config->get('FssNet_failed_status_id'), $message, false);
    		$this->displayFailure ($this->language->get('error_declined'), $this->config->get('FssNet_failed_status_id'));
    	}
    }

    public function processOrder($ResResult, $ResTrackId, $ResAmount, $ResPayId, $ResRefId, $ResTranId, $ResErrorText){
    	$this->load->model('checkout/order');
    	$this->language->load('payment/FssNet');

    	if($this->config->get('FssNet_debuglog')){
			$this->log->write('FssNet::processOrder :::::  session->data ' . print_r($this->session, true));
    	}
    	
    	$order_info = $this->model_checkout_order->getOrder($ResTrackId);   //($this->session->data['order_id']);
    	$order_id = $order_info['order_id'];
    	
    	if($ResTrackId == $order_id){
	    	if ($ResErrorText != '') {
	    		$message .= "Error message: " . $ResErrorText . "\n";
	    		$message .= "Transaction ID: " . $ResTranId . "\n";
	    		$this->model_checkout_order->confirm($order_id, $this->config->get('FssNet_failed_status_id'));
	    		$this->model_checkout_order->update($order_id, $this->config->get('FssNet_failed_status_id'), $message, false);
	    		$this->displayFailure ($this->language->get('error_declined'), $this->config->get('FssNet_failed_status_id'));
	    	}
	    	else{
				$message = "Order has been successfull!";
	    		$this->model_checkout_order->confirm($order_id, $this->config->get('FssNet_success_status_id'), 'Transaction Id: ' . $ResTranId, true, $ResPayId, $ResRefId, $ResTranId);
	    		$this->model_checkout_order->update($order_id, $this->config->get('FssNet_success_status_id'), $message, false);
	    		$this->debugLog($message);
	    	
	    		// Send a response to mark this transaction as notified
	    		if($this->config->get('FssNet_debuglog')){
	    			$this->log->write('FssNet::processOrder :::::  before calling redirect ');
	    		}
				$testURL = $this->url->link ('checkout/success', '', 'SSL');
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::processOrder :::::  testURL =   ' . $testURL);
				}
			//	$this->redirect($this->url->link ('checkout/success', '', 'SSL'));
				$REDIRECT = 'REDIRECT=' . $testURL;
				echo $REDIRECT;
				if($this->config->get('FssNet_debuglog')){
					$this->log->write('FssNet::processOrder :::::  after calling redirect ');
				}
				//$this->redirect( $this->getLink ('checkout/success', '', 'SSL'));
	    	}
	    	//$this->model_checkout_order->confirm($INQResTrackId, $INQResPayid);
    	}
    	else{
	    	$message = "FssNet payment module:\n";
    		$this->debugLog("FssNet payment module (callback): Unable to get order information: " . $order_id);
    		$message .= "Error message: " . $ResErrorText . "\n";
    		$message .= "Transaction ID: " . $ResTranId . "\n";
    		$this->model_checkout_order->confirm($order_id, $this->config->get('FssNet_failed_status_id'), 'Transaction Id: ' . $ResTranId, true, $ResPayId, $ResRefId, $ResTranId);
    		$this->model_checkout_order->update($order_id, $this->config->get('FssNet_failed_status_id'), $message, false);
    		$this->displayFailure ($this->language->get('error_declined'), $this->config->get('FssNet_failed_status_id'));
    	}
    }
    
    public function validateresponse($order_id){
    	$status = true;
    	
    	if(isset($_GET['result'])){
    		$ResResult = $_GET['result'];
    	}
    	else{
    		$ResResult = 0;
    	}
    	 
    	if(isset($_GET['track_id'])){
    		$ResTrackId = $_GET['track_id'];
    	}
    	else{
    		$ResTrackId = 0;
    	}
    	    	 
    	if(isset($_GET['error'])){
    		$ResError = $_GET['error'];
    	}
    	else{
    		$ResError = '';
    	}
    	if($ResError != ''){
    		$status = false;
    	}
    	
    	if($ResResult != 'CAPTURED' && $ResResult != 'APPROVED' && $ResResult != 'SUCCESS'){
    		$status = false;
    	}
    	
    	if($ResTrackId != $order_id){
    		$status = false;
    	}
    	
    	return $status;
    }
    
    public function testFailure(){
    	$msg = "Message=--IP MISSMATCH-- Response IP Address is: ";
    	
    	//echo $msg;
    	$this->displayFailure($msg);
    }
    
	public function displayFailure($message, $timeout="10") {
		if($this->config->get('FssNet_debuglog')){
			$this->log->write('controller_payment_fssnet:::: Inside displayFailure function');
		}
		//if ($this->config->get('fss_debuglog'))
		if($this->config->get('FssNet_debuglog'))
		{
            $log = $this->registry->get('log'); 
            if (is_object($log)) {
                $log->write(str_replace("\n", ", ", $message));
            }
        }
        /*if (version_compare(VERSION, "1.5.0", "<")) {
            $cartRoute = 'checkout/payment';
        } else {*/
            $cartRoute = 'checkout/checkout';
        //}
        
            $this->language->load('payment/FssNet');    
            
            $this->data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

            if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
                $this->data['base'] = HTTP_SERVER;
            } else {
                $this->data['base'] = HTTPS_SERVER;
            }
            if($this->config->get('FssNet_debuglog')){
            	$this->log->write('controller_payment_fssnet:::: Before setting data variable');
            }
        
            $this->data['charset'] = $this->language->get('charset');
            $this->data['language'] = $this->language->get('code');
            $this->data['direction'] = $this->language->get('direction');
        
            $this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
            
            $this->data['text_response'] = $this->language->get('text_response');
            $this->data['text_failure'] = nl2br($message);
            
            $this->data['timeout'] = $timeout * 1000;
            
            $this->data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $timeout, $this->getLink($cartRoute, '', 'SSL'));
        
            $this->data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/cart';

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/FssNet_failure.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/FssNet_failure.tpl';
            } else {
                $this->template = 'default/template/payment/FssNet_failure.tpl';
            }
            if($this->config->get('FssNet_debuglog')){
            	$this->log->write('controller_payment_fssnet:::: Before calling setOutput method');
            }
            
            //$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
            
            $this->response->setOutput($this->render());
            if($this->config->get('FssNet_debuglog')){
            	$this->log->write('controller_payment_fssnet:::: After calling setOutput method');
            }
	}
    
	private function getLink($route, $args = '', $connection = 'NONSSL') {
    
        if (version_compare(VERSION, "1.5.0", "<")) {
            if ($connection ==  'NONSSL') {
                $url = HTTP_SERVER;	
            } else {
                $url = HTTPS_SERVER;	
            }
            
            $url .= 'index.php?route=' . $route;
                
            if ($args) {
                $url .= str_replace('&', '&amp;', '&' . ltrim($args, '&')); 
            }
            return $url;
            
        } else {
      		return $this->url->link($route, $args, $connection);
        }
    
	}
	
    private function debugLog($message) {
    
    	if($this->config->get('FssNet_debuglog')){
			$this->log->write($message);
        }
    }
    
    public function fssNetCallback($INQResTrackId, $INQResPayid){
    	$this->load->model('checkout/order');
    	 
    	$this->model_checkout_order->confirm($INQResTrackId, $INQResPayid);
    	 
    }
    
    public function get_remote_ip() {
    	//Just get the headers if we can or else use the SERVER global
    	if(function_exists( 'apache_request_headers')){
    		$headers = apache_request_headers();
    	}else{
    		$headers = $_SERVER;
    	}
    	//Get the forwarded IP if it exists
    	if(array_key_exists('X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
    		$the_ip = $headers['X-Forwarded-For'];
    	}elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
    	){
    		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    	}else{
    		$the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    	}
    	return $the_ip;
    }
}
?>
