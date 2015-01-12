<?php 
	/*
	* Call to GetExpressCheckoutDetails and DoExpressCheckoutPayment APIs
	*/

	require_once ("paypal_functions.php"); 

	/*
	* The paymentAmount is the total value of the shopping cart(in real apps), here it was set 
    * in paypalfunctions.php in a session variable 
	*/
	
	$finalPaymentAmount =  $_SESSION["Payment_Amount"];
	if(!isset($_SESSION['payer_id']))
	{
		$_SESSION['payer_id'] =	$_GET['PayerID'];
	}


	// Check to see if the Request object contains a variable named 'token'	or Session object contains a variable named TOKEN 
	$token = "";
	
	if (isset($_REQUEST['token']))
	{
		$token = $_REQUEST['token'];
	} else if(isset($_SESSION['TOKEN']))
	{
		$token = $_SESSION['TOKEN'];
	}
	
	// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.	
	if ( $token != "" )
	{
		/*
		* Calls the GetExpressCheckoutDetails API call
		*/
		$resArrayGetExpressCheckout = GetShippingDetails( $token );
		$ackGetExpressCheckout = strtoupper($resArrayGetExpressCheckout["ACK"]);	 
		if( $ackGetExpressCheckout == "SUCCESS" || $ackGetExpressCheckout == "SUCESSWITHWARNING") 
		{
			/*
			* The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review 
			* page		
			*/
			$email 				= $resArrayGetExpressCheckout["EMAIL"]; // ' Email address of payer.
			$payerId 			= $resArrayGetExpressCheckout["PAYERID"]; // ' Unique PayPal customer account identification number.
			$payerStatus		= $resArrayGetExpressCheckout["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
			$firstName			= $resArrayGetExpressCheckout["FIRSTNAME"]; // ' Payer's first name.
			$lastName			= $resArrayGetExpressCheckout["LASTNAME"]; // ' Payer's last name.
			$cntryCode			= $resArrayGetExpressCheckout["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
			//$shipToName			= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
			$quoteid			= $resArrayGetExpressCheckout["L_PAYMENTREQUEST_0_NUMBER0"];
			//$shipToStreet		= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
			//$shipToCity			= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
			//$shipToState		= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
			//$shipToCntryCode	= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code. 
			//$shipToZip			= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
			//$addressStatus 		= $resArrayGetExpressCheckout["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal 
			$totalAmt   		= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_AMT"]; // ' Total Amount to be paid by buyer
			$currencyCode       = $resArrayGetExpressCheckout["CURRENCYCODE"]; // 'Currency being used 
			$shippingAmt        = $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPPINGAMT"]; // 'Shipping amount 
			/*
			* Add check here to verify if the payment amount stored in session is the same as the one returned from GetExpressCheckoutDetails API call
			* Checks whether the session has been compromised
			*/
			if($_SESSION["Payment_Amount"] != $totalAmt || $_SESSION["currencyCodeType"] != $currencyCode)
			exit("Parameters in session do not match those in PayPal API calls");
		} 
		else  
		{
			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			$ErrorCode = urldecode($resArrayGetExpressCheckout["L_ERRORCODE0"]);
			$ErrorShortMsg = urldecode($resArrayGetExpressCheckout["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = urldecode($resArrayGetExpressCheckout["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = urldecode($resArrayGetExpressCheckout["L_SEVERITYCODE0"]);

			echo "GetExpressCheckoutDetails API call failed. ";
			echo "Detailed Error Message: " . $ErrorLongMsg;
			echo "Short Error Message: " . $ErrorShortMsg;
			echo "Error Code: " . $ErrorCode;
			echo "Error Severity Code: " . $ErrorSeverityCode;
		}
	}
	/* Review block start */
	
	if(!USERACTION_FLAG && !isset($_SESSION['EXPRESS_MARK'])){
	if(isset($_POST['shipping_method']))
		$new_shipping = $_POST['shipping_method']; //need to change this value, just for testing
		if($shippingAmt > 0){
			$finalPaymentAmount = ($totalAmt + $new_shipping) - $_SESSION['shippingAmt'];
			$_SESSION['shippingAmt'] = $new_shipping;
		}
	}
	
	/* Review block end */
	/*
	* Calls the DoExpressCheckoutPayment API call
	*/
	//$resArrayDoExpressCheckout = ConfirmPayment ( $newTotalAmt );
	$resArrayDoExpressCheckout = ConfirmPayment ( $finalPaymentAmount );
	$ackDoExpressCheckout = strtoupper($resArrayDoExpressCheckout["ACK"]);
	include('header.php');

	session_unset();   // free all session variables
	session_destroy(); //destroy session
	if( $ackDoExpressCheckout == "SUCCESS" || $ackDoExpressCheckout == "SUCCESSWITHWARNING" )
	{
		$sellerTranID		= $resArrayDoExpressCheckout["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
		$transactionType 	= $resArrayDoExpressCheckout["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
		$paymentType		= $resArrayDoExpressCheckout["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
		$orderTime 			= $resArrayDoExpressCheckout["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
		$PaypalAmountpaid	= $resArrayDoExpressCheckout["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
		$currencyCode		= $resArrayDoExpressCheckout["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
		/*
		* Status of the payment: 
		* Completed: The payment has been completed, and the funds have been added successfully to your account balance.
		* Pending: The payment is pending. See the PendingReason element for more information. 
		*/
		
		$paymentStatus	= $resArrayDoExpressCheckout["PAYMENTINFO_0_PAYMENTSTATUS"]; 

		/*
		* The reason the payment is pending 
		*/
		$pendingReason	= $resArrayDoExpressCheckout["PAYMENTINFO_0_PENDINGREASON"];  

		/*
		* The reason for a reversal if TransactionType is reversal 
		*/
		$reasonCode		= $resArrayDoExpressCheckout["PAYMENTINFO_0_REASONCODE"];   
		?>
			<span class="span4">
    		</span>
    		<span class="span5">
    			<div class="hero-unit">
    			<!-- Display the Transaction Details-->
    			<h4> <?php echo($firstName); ?>
    				<?php echo($lastName); ?> , Thank you for your Order </h4>
    			
    			<p>ID: <?php  echo($quoteid);?> </p>
				<p>Transaction ID: <?php  echo($sellerTranID);?> </p>
    			<p>Transaction Type: <?php  echo($transactionType);?> </p>
    			<p>Payment Total Amount: <?php  echo($PaypalAmountpaid);?> </p>
    			<p>Currency Code: <?php  echo($currencyCode);?> </p>
    			<p>Payment Status: <?php  echo($paymentStatus);?> </p>
    			<p>Payment Type: <?php  echo($paymentType);?> </p>
    			<h3> Click <a href='index.php'>here </a> to return to Home Page</h3>
    			</div>
    		</span>
    		<span class="span3">
    		</span>
		<?php


$error = 'Could not connect. Please contact server Admin.';
require '../../../../../wp-config.php';
try {

  # MySQL with PDO_MYSQL
  $DBH = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

}
catch(PDOException $e) {
    echo $e->getMessage();
    echo "PDO doesn't work";
}

global $wpdb;

$timestamp = date('Y-m-d H:i:s');

global $current_user;

		
$query_result = $DBH->prepare("SELECT QUOTE_ID FROM wp_walleto_order_header orders WHERE QUOTE_ID = '$quoteid'");
$query_result->execute($parms10); 
			
			$data = $query_result->fetchAll();           
				foreach($data as $row){
					$matchingQuote = $row['QUOTE_ID'];
				}
			
$query_result = $DBH->prepare("SELECT * FROM wp_quote_headers WHERE QUOTE_ID = '$quoteid'");


$query_result->execute($parms10); 

$data = $query_result->fetchAll();           
foreach($data as $row){}
$usertype = $row['USER_TYPE'];
$quote_ID = $row['QUOTE_ID'];
$billID = $row['BILL_TO_ADDRESS_ID']; 
$billname = $row['BILL_TO_CUSTOMER'];
$billattn = $row['BILL_TO_ATTENTION'];
$shipID = $row['SHIP_TO_ADDRESS_ID'];
$shipname = $row['SHIP_TO_CUSTOMER'];
$shipattn = $row['SHIP_TO_ATTENTION'];
$sales_ID = $row['SALESPERSON_ID'];
$oracleSalesID = $row['ORACLE_SALESREP_ID'];
$uid = $row['CUSTOMER_ID'];
$firstname = $row['FIRST_NAME'];
$lastname = $row['LAST_NAME'];
$company = $row['COMPANY'];
$phone = $row['USER_PHONE'];
$user_email = $row['USER_EMAIL'];
$billStreet1 = $row['BILL_TO_ADDRESS1'];
$billStreet2 = $row['BILL_TO_ADDRESS2'];
$billCity = $row['BILL_TO_CITY'];
$billState = $row['BILL_TO_STATE'];
$billZip = $row['BILL_TO_ZIP'];
$billCountry = $row['BILL_TO_COUNTRY'];
$shipStreet1 = $row['SHIP_TO_ADDRESS1'];
$shipStreet2 = $row['SHIP_TO_ADDRESS2'];
$shipCity = $row['SHIP_TO_CITY'];
$shipState = $row['SHIP_TO_STATE'];
$shipZip = $row['SHIP_TO_ZIP'];
$shipCountry = $row['SHIP_TO_COUNTRY'];
$eula_accept = $row['EULA_ACCEPT_STATUS'];
$eula_date = $row['EULA_DATETIME'];
$eula_uid = $row['EULA_ACCEPTANCE_UID'];
$eula_ip = $row['EULA_IP_ADDRESS'];
$arrivaldate = $row['EXPECTED_ARRIVAL_DATE'];
$qoriginal = $row['ORIGINAL_ORDER_ID'];
$reseller = $row['RESELLER_ID'];
$resellercompany = $row['RESELLER_COMPANY_NAME'];
$createdid = $row['CREATED_BY'];
$oracleRMA = $row['ORACLE_RMA_NUMBER'];
$oracleRMAHeader = $row['ORACLE_RMA_HEADER_ID'];
$totalTax = $row['TOTAL_TAX_AMOUNT'];
$quoteDate = $row['CREATION_DATE'];
$matchTotalAmount = $row['TOTAL_AMOUNT'];
	

if(($row['ORIGINAL_ORDER_ID'] == NULL) || ($row['ORIGINAL_ORDER_ID'] == 0))
	$order_status = 'WAITING_FOR_SYNC';
else{
	$order_status = 'WAITING_FOR_RENEWAL_SYNC';
}
			
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$sales_ID'");


$query_result->execute($salesfirstname); 
					
$data = $query_result->fetchAll();           
	foreach($data as $row){
		$salesFirst = $row['meta_value'];
	}
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$sales_ID'");


$query_result->execute($saleslastname); 
					
$data = $query_result->fetchAll();           
	foreach($data as $row){
		$salesLast = $row['meta_value'];
	}
	
$salesFullName = $salesLast.', '.$salesFirst;
if ($salesFirst == NULL)
	$salesFullName = 'No Sales Credit';
	$query_result = $DBH->prepare("INSERT INTO `wp_walleto_order_header` 
	(`ORDER_ID`, `QUOTE_ID`,`TOTAL_TAX_AMOUNT`, `TOTAL_AMOUNT`, `SALESPERSON_ID`, `ORACLE_SALESREP_ID`, `SALESPERSON_NAME`,`CUSTOMER_ID`, `RESELLER_ID`, `RESELLER_COMPANY_NAME`,
	`BILL_TO_ID`, `BILL_TO_CUSTOMER`, `BILL_TO_ATTENTION`, `BILL_TO_ADDRESS1`, `BILL_TO_ADDRESS2`, `BILL_TO_CITY`, `BILL_TO_STATE`, `BILL_TO_ZIP`, `BILL_TO_COUNTRY`, 
	`SHIP_TO_ID`, `SHIP_TO_CUSTOMER`, `SHIP_TO_ATTENTION`, `SHIP_TO_ADDRESS1`, `SHIP_TO_ADDRESS2`, `SHIP_TO_CITY`, `SHIP_TO_STATE`, `SHIP_TO_ZIP`, `SHIP_TO_COUNTRY`, 
	`EXPECTED_ARRIVAL_DATE`, `EULA_ACCEPT_STATUS`, `EULA_DATETIME`, `EULA_ACCEPTANCE_UID`, `EULA_IP_ADDRESS`, 
	`BUYER_EMAIL`, `BUYER_FIRST_NAME`, `BUYER_LAST_NAME`, 
	`SELLER_TRANSACTION_ID`, `TRANSACTION_DATE`, `PAID`, `PAID_DATE`, `AMOUNT_PAID`, `SHIPPED_STATUS`,
	`PO_NUMBER`, `PO_FILE_NAME`, `PAYMENT_RECEIVED_FLAG`, 
	`FIRST_NAME`, `LAST_NAME`, `COMPANY`, `USER_PHONE`, `USER_EMAIL`, `USER_TYPE`, 
	`ORIGINAL_ORDER_ID`, `CURRENT_ORDER_ID`, `ORACLE_ORDER_NUMBER`, `ORACLE_ORDER_HEADER_ID`, `ORACLE_RMA_NUMBER`, `ORACLE_RMA_HEADER_ID`, 
	`SHIPMENT_EMAIL_SENT_DATE`, `FINAL_DELIVERED_DATE`, `AGING_FLAG`, `STATUS`, `PROCESS_STATUS`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATE_BY`) 
	VALUES
	('', :quote, :totalTaxAmount, :total_amount, :salesid, :oracleSalesID, :salesFullName,:uid, :reseller, :resellercompany,
	:billID, :billname, :billattn, :billStreet1, :billStreet2, :billCity, :billState, :billZip, :billCountry, 
	:shipID, :shipname, :shipattn, :shipStreet1, :shipStreet2, :shipCity, :shipState, :shipZip, :shipCountry, 
	:arrivaldate, :eula_accept, :eula_date, :eula_uid, :eula_ip, 
	:bemail, :bfirst, :blast, :seller_id, '$timestamp', 1, '$timestamp', :total_amount, 'NOT_SHIPPED', '', '', 1, :first, :last, :company, :phone, :email, :usertype, 
	:qoriginal, '', :oracleRMA, :oracleRMAHeader, '', '', '$timestamp', '', '', 'PAID', '$order_status', '$timestamp', :createdid, '', '')
	");
		
	$parms9[':usertype'] = $usertype;
	$parms9[':billID'] = $billID;
	$parms9[':billname'] = $billname;
	$parms9[':billattn'] = $billattn;
	$parms9[':shipID'] = $shipID;
	$parms9[':shipname'] = $shipname;
	$parms9[':shipattn'] = $shipattn;
	$parms9[':quote'] = $quote_ID;
	$parms9[':total_amount'] = $PaypalAmountpaid;
	$parms9[':salesid'] = $sales_ID;
	$parms9[':oracleSalesID'] = $oracleSalesID;
	$parms9[':salesFullName'] = $salesFullName;
	$parms9[':uid'] = $uid;
	$parms9[':bfirst'] = $firstname;
	$parms9[':blast'] = $lastname;
	$parms9[':first'] = $firstname;
	$parms9[':last'] = $lastname;
	$parms9[':company'] = $company;
	$parms9[':phone'] = $phone;
	$parms9[':bemail'] = $user_email;
	$parms9[':email'] = $user_email;
	$parms9[':billStreet1'] = $billStreet1;
	$parms9[':billStreet2'] = $billStreet2;
	$parms9[':billCity'] = $billCity;
	$parms9[':billState'] = $billState;
	$parms9[':billZip'] = $billZip;
	$parms9[':billCountry'] = $billCountry;
	$parms9[':shipStreet1'] = $shipStreet1;
	$parms9[':shipStreet2'] = $shipStreet2;
	$parms9[':shipCity'] = $shipCity;
	$parms9[':shipState'] = $shipState;
	$parms9[':shipZip'] = $shipZip;
	$parms9[':shipCountry'] = $shipCountry;
	$parms9[':arrivaldate'] = $arrivaldate;
	$parms9[':eula_accept'] = $eula_accept;
	$parms9[':eula_date'] = $eula_date;
	$parms9[':eula_uid'] = $eula_uid;
	$parms9[':eula_ip'] = $eula_ip;
	$parms9[':seller_id'] = $sellerTranID;
	$parms9[':qoriginal'] = $qoriginal;
	$parms9[':reseller'] = $reseller;
	$parms9[':resellercompany'] = $resellercompany;
	$parms9[':createdid'] = $createdid;
	$parms9[':oracleRMA'] = $oracleRMA;
	$parms9[':oracleRMAHeader'] = $oracleRMAHeader;
	$parms9[':totalTaxAmount'] = $totalTax;

	$query_result->execute($parms9); 

$query_result = $DBH->prepare("SELECT ord.ORDER_ID, quote.* 
								FROM wp_walleto_order_header ord, wp_quote_lines quote
								WHERE ord.QUOTE_ID = '$quote_ID' AND quote.QUOTE_ID = '$quote_ID'");


$query_result->execute($parms11); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$oid = $row['ORDER_ID'];
	$quoteline = $row['QUOTE_LINE_ID'];
	$model = $row['MODEL_NUMBER'];
	$part = $row['PART_NUMBER'];
	$rentnumber = $row['RENTAL_PART_NUMBER'];
	$post = $row['POST_ID'];
	$unit = $row['UNIT_PRICE'];
	$uom = $row['UOM'];
	$quant = $row['QUANTITY'];
	$dur = $row['DURATION'];
	$prod = $row['PRODUCT_AMOUNT'];
	$freight = $row['FREIGHT_AMOUNT'];
	$tax = $row['TAX_AMOUNT'];
	//$quoteline = $row['TAX_EXEMPT_CERTIFICATE'];
	$discount = $row['DISCOUNT_AMOUNT'];
	$totalline = $row['TOTAL_LINE_AMOUNT'];

	$shiptype = $row['SHIP_TYPE'];
	$shipsku = $row['SHIP_SKU'];
	$origordline = $row['ORIGINAL_ORDER_LINE_ID'];
	$serialDB = $row['SERIAL_NUMBER'];
	$rmaDB = $row['ORACLE_RMA_LINE_ID'];
	$createdid = $row['CREATED_BY'];
	
if ($qoriginal != NULL){
	$query_result = $DBH->prepare("SELECT ord.RETURN_DATE
									FROM wp_walleto_order_lines ord
									WHERE ord.ORDER_LINE_ID = '$origordline'");


	$query_result->execute($parms12); 

	
	$data = $query_result->fetchAll();           
		foreach($data as $row2){
			$rdate = $row2['RETURN_DATE'];
		}
						 

	if($uom == 'MTH'){
						 $newDuration = $dur * 30;	 
	}
	if($uom == 'WK'){
						 $newDuration = $dur * 7;	 
	}
	$newdate = strtotime ( $newDuration.' days' , strtotime ( $rdate ) ) ;
	$newdate = date('Y-m-d H:i:s', $newdate);

	$query_result = $DBH->prepare("UPDATE  `wp_walleto_order_lines` SET  
									RETURN_DATE = :newdate, 
									PROCESS_STATUS = 'WAITING_FOR_RETURN' 
									WHERE `ORDER_LINE_ID` = :origordline");
	$parm10[':origordline'] = $origordline;
	$parm10[':newdate'] = $newdate;
	$query_result->execute($parm10); 


	$query_result = $DBH->prepare("UPDATE  `wp_walleto_order_header` SET  
								`CURRENT_ORDER_ID` = :oid
								WHERE `ORDER_ID` = :qoriginal");
	$updateOrder[':oid'] = $oid;
	$updateOrder[':qoriginal'] = $qoriginal;
	
	$query_result->execute($updateOrder); 
}
			

$x=0;	
		
for($x=0; $x < $quant; $x++)	{								
				
	$query_result = $DBH->prepare("INSERT INTO `wp_walleto_order_lines` 
	(`ORDER_LINE_ID`, `ORDER_ID`, `QUOTE_LINE_ID`, `POST_ID`,`MODEL_NUMBER`, `PART_NUMBER`, `RENTAL_PART_NUMBER`, `SERIAL_NUMBER`, `UNIT_PRICE`, 
	`UOM`, `QUANTITY`, `DURATION`, `PRODUCT_AMOUNT`, `FREIGHT_AMOUNT`, `TAX_AMOUNT`, `TAX_EXEMPT_CERTIFICATE`, `DISCOUNT_AMOUNT`, 
	`TOTAL_LINE_AMOUNT`, `SHIP_TYPE`, `SHIP_SKU`,`PROMOTION_CODE`, `SCHEDULED_SHIP_DATE`, `SHIPPED_DATE`, `DELIVERED_DATE`,`RETURN_DATE`, `RECEIVED_DATE`, 
	`WAYBILL_NUMBER`, `RETURN_WAYBILL_NUMBER`, `CARRIER`, `ORACLE_RMA_LINE_ID`, `ORACLE_ORDER_LINE_ID`, 
	`STATUS`, `PROCESS_STATUS`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATE_BY`) 
	VALUES
	('', :oid, :quoteline, :post, :model, :part, :rentnumber, :serialDB, :unit, :uom, 
	1, :dur, :prod, :freight, :tax, '', :discount, :totalline, :shiptype, :shipsku, '', 
	'', '', '','', '', '', '', '', '', :rmaDB, 'PAID', '$order_status', '$timestamp', :createdid, '', '')");

	$parms12[':quoteline'] = $quoteline;
	$parms12[':oid'] = $oid;
	
	$parms12[':model'] = $model;
	$parms12[':part'] = $part;
	$parms12[':rentnumber'] = $rentnumber;
	$parms12[':post'] = $post;
	
	$parms12[':unit'] = $unit;
	$parms12[':uom'] = $uom;
	
	$parms12[':dur'] = $dur;
	$parms12[':prod'] = $prod / $quant;
	$parms12[':freight'] = $freight / $quant;
	$parms12[':tax'] = $tax / $quant;
	$parms12[':discount'] = $discount / $quant;
	$parms12[':totalline'] = $totalline / $quant;
	
	$parms12[':createdid'] = $createdid;
	$parms12[':shiptype'] = $shiptype;
	$parms12[':shipsku'] = $shipsku;
	$parms12[':serialDB'] = $serialDB;
	$parms12[':rmaDB'] = $rmaDB;
	
	
	
	$query_result->execute($parms12); 
	}
}

$query_result = $DBH->prepare("UPDATE  `wp_quote_lines` SET  STATUS = 'ORDER_CREATED' WHERE `QUOTE_ID` = :qid");
$parm2[':qid'] = $quote_ID;
$query_result->execute($parm2);    
				
$wpdb->query("update ".$wpdb->prefix."quote_headers set STATUS='PAID' where QUOTE_ID='$quote_ID'");	

							
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$sales_ID'");


$query_result->execute($salesfirstname); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$salesFirst = $row['meta_value'];
}
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$sales_ID'");


$query_result->execute($saleslastname); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$salesLast = $row['meta_value'];
}
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'user_phone' AND user_id = '$sales_ID'");


$query_result->execute($salesPhoneCheck); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$salesPhone = $row['meta_value'];
}
$query_result = $DBH->prepare("SELECT user_email FROM wp_users WHERE ID = '$sales_ID'");


$query_result->execute($saleslastname); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$salesEmail = $row['user_email'];
}
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$createdid'");


$query_result->execute($preparefirstname); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$preparedFirst = $row['meta_value'];
}
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'user_phone' AND user_id = '$createdid'");


$query_result->execute($preparePhone); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$preparedPhone = $row['meta_value'];
}
$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$createdid'");


$query_result->execute($preparelastname); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$preparedLast = $row['meta_value'];
}
$query_result = $DBH->prepare("SELECT user_email FROM wp_users WHERE ID = '$createdid'");


$query_result->execute($preparelastname); 

$data = $query_result->fetchAll();           
foreach($data as $row){
	$preparedEmail = $row['user_email'];
}

$preparedFullName = $preparedFirst.' '.$preparedLast;	
if ($salesFirst == NULL)
	$salesFullName = ' ';
else
	$salesFullName = $salesFirst.' '.$salesLast;
echo hello;
include ('../../../../../wp-content/themes/Walleto/lib/my_account/eulapdf.php');
echo hello1;
generatepdf($shiptype, $uid, $quoteid, $quoteDate, $company, $firstname, $lastname, $description, 
			$user_email, $phone, $start_date, $industry, $newp, 
			$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry, 
			$shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry, 
			$po, $billname, $shipname, $discount, $arrivaldate, $billattn, $shipattn, 
			$totalTax, $PaypalAmountpaid, $serialDB, 0, 1, $salesFullName, $salesEmail, $salesPhone, $preparedFullName, $preparedEmail, $preparedPhone, $timestamp, $oid, 1);

echo hello2;
$s = "select users.user_email from  ".$wpdb->prefix."users wpusers WHERE users.ID = '$uid'";
$r = $wpdb->get_results($s);     
foreach($r as $row2)
			{
	if($sales_ID !=0){   
		$user_email = $row2->user_email;
	}

$s = "select users.user_email from  ".$wpdb->prefix."users users,
".$wpdb->prefix."walleto_order_header oid WHERE users.ID = oid.SALESPERSON_ID AND oid.ORDER_ID = '$oid'";
$r = $wpdb->get_results($s);     

foreach($r as $row2)
				{
   
	$sales_email = $row2->user_email;

							}
	$user_email = $user_email.', '.$sales_email;
}
$message = "Hi {$firstname},\n\nThank you for your payment.\n\nIf you are beginning your rental, then everything has been processed and you will receive a shipping confirmation email, with tracking information, when your order ships.\n\nIf you are extending your rental, then everything has been processed and your rental has been extended an additional 30 days.\n\nIf you have any questions, please give us a call at (888) 425-8228.\n\nPlease share this email with everyone that will be working on the project.  If you need assistance, then please call us at (888) 425-8228 for Sales or (800) 626-4686 for Technical Support.\n\nWe appreciate your business and the opportunity to help you complete your scanning project.\n\nHave a great day,\n\nThe RentScan By Fujitsu Team";

Walleto_send_email1($user_email, $subject = "Your RentScan Payment Has Been Received - Order #: {$oid}", $message, 'ship_create', 'inside_sales'); 
$walleto_check_if_order_is_paid_fully = walleto_check_if_order_is_paid_fully($oid);

if($walleto_check_if_order_is_paid_fully == false)
{
	$wpdb->query("update ".$wpdb->prefix."walleto_orders set paid='0', partially_paid='1' where id='$oid'");	
}
else
{
	$wpdb->query("update ".$wpdb->prefix."walleto_orders set paid='1', partially_paid='1', paid_on='$datemade'  where id='$oid'");
}

$opt = get_option('my_updated_walleto_paid_' .$datemade. $oid);

if(empty($opt))
{

	update_option('my_updated_walleto_paid_' .$datemade. $oid , "1");
	
	walleto_prepare_rating($uid, $the_buyer, $oid);
	walleto_prepare_rating($the_buyer, $uid, $oid);
	
}
	header('Location: ../../../../../wp-content/themes/Walleto/confirmation.php');	
	}
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal

		$ErrorCode = urldecode($resArrayDoExpressCheckout["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArrayDoExpressCheckout["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArrayDoExpressCheckout["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArrayDoExpressCheckout["L_SEVERITYCODE0"]);

		if($ErrorCode == 10486)  //Transaction could not be completed error because of Funding failure. Should redirect user to PayPal to manage their funds.
		{
			?>
			<!--<div class="hero-unit">
    			 Display the Transaction Details
    			<h4> There is a Funding Failure in your account. You can modify your funding sources to fix it and make purchase later. </h4>
    			Payment Status:-->
    			<?php  //echo($resArrayDoExpressCheckout["PAYMENTINFO_0_PAYMENTSTATUS"]);
						RedirectToPayPal ( $resArray["TOKEN"] );
    			?>
    			<!--<h3> Click <a href='https://www.sandbox.paypal.com/'>here </a> to go to PayPal site.</h3> <!--Change to live PayPal site for production-->
    		<!--</div>-->
			<?php
		}
		else
		{
			echo "DoExpressCheckout API call failed. ";
			echo "Detailed Error Message: " . $ErrorLongMsg;
			echo "Short Error Message: " . $ErrorShortMsg;
			echo "Error Code: " . $ErrorCode;
			echo "Error Severity Code: " . $ErrorSeverityCode;
		}
	}		
?>
<?php include('footer.php'); ?>