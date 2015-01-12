<?php 

include 'paypal.class.php';

global $wp_query, $wpdb, $current_user;
$action = $_GET['action'];
foreach($_GET as $loc=>$qid)
    $_GET[$loc] = urldecode(base64_decode($qid));

$qid 		= $_GET['pay_order_by_paypal'];
$owner_uid 	= $_GET['uid'];
$SubTotal 	= $_GET['Stot'];

logging1($uid,'Accepted',$qid);
		require '../rentscan/wp-content/themes/Walleto/connectPDO.php';

		$query_result = $DBH->prepare("SELECT qheader.QUOTE_ID, qheader.STATUS FROM wp_quote_headers qheader WHERE QUOTE_ID = '$qid'");
		$query_result->execute($parms10); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$qStatus = $row['STATUS'];
						}
						if($qStatus == 'PAID'){
							
							echo 'Payment for this quote has already been placed.';
							header('Location: ./my-account/');
							die;
						}


		global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;

$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url

//---------------------

$Walleto_paypal_enable_sdbx = get_option('Walleto_paypal_enable_sdbx');
if($Walleto_paypal_enable_sdbx == "yes")
$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';     // paypal url

//--------------------
 
$this_script = get_bloginfo('siteurl').'/?pay_order_by_paypal='.$qid.'&bid_id='.$owner_uid;

$post = get_post($pid);
$paypal_email = get_user_meta($owner_uid, 'paypal_email', true);


	//$opt = get_option('Walleto_only_admins_post_auctions');
	$opt = "yes";
	if($opt == "yes")
	{
		$paypal_email = get_option('Walleto_paypal_email');
	}


if(empty($paypal_email)) { die('ERROR-DEBUG-> Missing Paypal Email of user.'); exit; }

if(empty($action)) $action = 'process';   

 

switch ($action) {


   case 'process':      // Process and order...
	
	get_currentuserinfo();
	//$total = walleto_get_total_of_order_for_user($oid, $owner_uid);
	
	if(!empty($qid))
	{
		$total = $SubTotal; 	
	}
	else
	{
	$total = walleto_get_total_for_order($qid);
	$shipping = get_post_meta($pid, 'shipping', true);
	if(is_numeric($shipping) && $shipping > 0 && !empty($shipping))
			$shipping = $shipping;
					else $shipping = 0;
	 
	 $total += $shipping; 
	}
	 
//------------------------------------------------------
	
		
      $p->add_field('business', $paypal_email);
	  
	  $p->add_field('currency_code', get_option('Walleto_currency'));
	  $p->add_field('no_shipping', 1);
	//$p->add_field('cbt', "Click here to complete your purchase");
	  $p->add_field('cbt', "Click here to return to RentScan site");

	  $p->add_field('return', $this_script.'&action=success');
      $p->add_field('cancel_return', $this_script.'&action=cancel');
      $p->add_field('notify_url', $this_script.'&action=ipn');
      $p->add_field('item_name', sprintf(__('#%s','Walleto'), $qid));
	  $p->add_field('custom', $qid.'|'. $owner_uid. '|'.current_time('timestamp',0)."|".$current_user->ID );
      $p->add_field('amount', Walleto_formats_special($total,2));

      $p->submit_paypal_post(); // submit the fields to paypal

     break;

   case 'success':      // Order was successful...
	sync_logging ('Case PDT', 'PDT CALLED');

	//$pd = current_time('timestamp',0);
	//$s = "update ".$wpdb->prefix."walleto_orders set paid='1', paid_on='$pd' where id='$oid'";
	//$wpdb->query($s);
	
	WALLETO_ipn_notif_news();
	
	$using_perm 	= Walleto_using_permalinks();
	$paid_items_id 	= get_option('Walleto_my_account_not_shipped_page_id');
			
	if($using_perm)	$paid_itms_m = get_permalink($paid_items_id). "?";
	else $paid_itms_m = get_bloginfo('siteurl'). "/?page_id=". $paid_items_id. "&";	


	header('Location: ./wp-content/themes/Walleto/confirmation.php/?paid=1');
	die;
	wp_redirect($paid_itms_m . "paid_ok=1");
	die;
	
	break;
	
	case 'ipn':
	sync_logging ('Case IPN', 'IPN CALLED');
    if ($p->validate_ipn())
	{
		WALLETO_ipn_notif_news();
	  // This is ipn section which runs in the backend. You can call all the return values from here including transaction id, custom value etc. You can update the database from here.
	}
   break;

   case 'cancel':       // Order was canceled...

	//wp_redirect(walleto_show_payment_link_for_order($oid));
	header( 'Location: ../rentscan/my-account/');

       break;
     



 } 

								
 function WALLETO_ipn_notif_news()
 {
	 
	parse_str(file_get_contents("php://input"), $_POST);
	
	if(isset($_POST['custom']))
	{
	
		global $wpdb;
		
		$cust 					= $_POST['custom'];

		$cust 					= explode("|",$cust);
		$quoteid				= $cust[0];

		$uid 					= $cust[1];
		$datemade 				= $cust[2];
		$the_buyer 				= $cust[3];
		$sellerTranID 			= $_POST['txn_id'];
		$PaypalAmountpaid		= $_POST['mc_gross'];
		$PaypalTranDate			= $_POST['payment_date'];

$timestamp = date('Y-m-d H:i:s');



		$BuyerFname				= $_POST['first_name'];
		$BuyerLname				= $_POST['last_name'];
		$BuyerEmail				= $_POST['payer_email'];
		global $current_user;
logging($uid, 'Payment', 'my_account.php');
sync_logging ('Pay Pal Transcation ID received', $sellerTranID); 
 

		//$s = "select * from ".$wpdb->prefix."walleto_order_contents cnt, $wpdb->posts posts where cnt.orderid='$oid' AND cnt.paid='0' AND posts.post_author='$uid' AND posts.ID=cnt.pid";

		//echo ('Id' . $oid);
		//echo ('uid' . $uid);
		//echo ( 'Count' . count($r));
		//die();
		require '../rentscan/wp-content/themes/Walleto/connectPDO.php';
		
		$query_result = $DBH->prepare("SELECT QUOTE_ID FROM wp_walleto_order_header orders WHERE QUOTE_ID = '$quoteid' AND CUSTOMER_ID = '$uid'");
		$query_result->execute($parms10); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$matchingQuote = $row['QUOTE_ID'];
						}
						
		$query_result = $DBH->prepare("SELECT SELLER_TRANSACTION_ID FROM wp_walleto_order_header orders WHERE QUOTE_ID = '$quoteid' AND CUSTOMER_ID = '$uid'");
		$query_result->execute($parms10); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$transactionID = $row['SELLER_TRANSACTION_ID'];
						}
						//if (isset($transactionID) || $transactionID != NULL){
						if ($transactionID == $sellerTranID){

						sync_logging ('Transaction ID confirmation', $sellerTranID);
							$using_perm 	= Walleto_using_permalinks();
							$paid_items_id 	= get_option('Walleto_my_account_not_shipped_page_id');
									
							if($using_perm)	$paid_itms_m = get_permalink($paid_items_id). "?";
							else $paid_itms_m = get_bloginfo('siteurl'). "/?page_id=". $paid_items_id. "&";	
							header('Location: ./wp-content/themes/Walleto/confirmation.php');
							die;

							
							wp_redirect($paid_itms_m . "paid_ok=1");
							die;
						
						} else {
						sync_logging ('Before getting quote headers', $sellerTranID);
						}
			//$idso = $row->orderid;


			//$idso2 = $row->id;
			//$wpdb->query("update ".$wpdb->prefix."walleto_order_contents  set paid='1', paid_on='$datemade' where id='$idso2'");
			//echo ('Order ID' . $idso);
			//echo ('TranID' . $sellerTranID );
			//Die();
			//echo ('Paypal Amount'. $PaypalAmountpaid);
			//echo ('Paypal Date'. $PaypalTranDate);
			//echo ('Buyer First Name'.$BuyerFname);
			//echo ('Buyer Last Name'.$BuyerLname);
			//echo ('Buyer Email'.$BuyerEmail);	
			//	Die(); 
			/*
			$s = "select * from ".$wpdb->prefix."quote_detail quote,".$wpdb->prefix."walleto_orders orders, wp_quote_lines line WHERE line.QUOTE_ID = quote.QUOTE_ID AND quote.QUOTE_ID = orders.QUOTE_ID AND orders.id = $oid";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
 
                                $model       	= $row1->MODEL_NUMBER;
								$serial			= $row1->SERIAL_NUMBER;
								$part			= $row1->PART_NUMBER;
								$quant			= $row1->QUANTITIY;
								$prod			= $row1->PRODUCT_AMOUNT;
								$freight		= $row1->FREIGHT_AMOUNT;
								$duration		= $row1->DURATION;
								$discount		= $row1->DISCOUNT;
								
			$query_result = $DBH->prepare("INSERT INTO `wp_walleto_order_lines` VALUES ('',:oid,:serial,
					:model,'', :quantity,
					:single_products_amount,
					:single_freight_amount, '$timestamp', '$timestamp', '$timestamp', 'ACTIVE', '', :duration, :discount)");

					$parms[':oid'] = $oid;
					$parms[':serial'] = $serial;
					$parms[':model'] = $model;
					$parms[':quantity'] = $quant;

					$parms[':single_products_amount'] = $prod;
					$parms[':single_freight_amount'] = $freight;

					$parms[':duration'] = $duration;
					$parms[':discount'] = $discount;


					$query_result->execute($parms);     
                                }
								*/
					sync_logging ('Before getting quote headers', $quoteid);			
					$query_result = $DBH->prepare("SELECT * FROM wp_quote_headers WHERE QUOTE_ID = '$quoteid' AND CUSTOMER_ID = '$uid'");


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
						sync_logging ('AFter getting header data', $sellerTranID);
						
				  if ($PaypalAmountpaid <=0)
		           				$negOrder = 'Refund for quote# '.$quoteid .' has been placed. Refunded amount '.$PaypalAmountpaid;
				else
					$negOrder = 'Additional transaction for quote# '.$quoteid.' has been placed.';

			              if(($PaypalAmountpaid != $matchTotalAmount) && ($matchingQuote == $quoteid)){
				      echo 'Payment for this quote has already been placed.';
				      $message1 = "Hi {$firstname},\n\n Seller Transaction ID: {$sellerTranID} \n\n {$negOrder} \n\n Have a great day, \n The RentScan By Fujitsu Team"; 
            if ($PaypalAmountpaid <=0)                   
			Walleto_send_email1($user_email, $subject = "RentScan Paypal additional transaction for Quote #: {$quoteid}", $message1, 'ship_create', 'inside_sales'); 
			else
 			Walleto_send_email1('', $subject = "RentScan Paypal additional transaction for Quote #: {$quoteid}", $message1, 'ship_create', 'inside_sales'); 
			
			sync_logging ('RentScan Paypal additional transaction for Quote #:'.$quoteid, $sellerTranID); 
			header('Location: ./my-account/');
			die;
		}

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
			sync_logging ('Get sales first name', $sellerTranID);
			$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$sales_ID'");


					$query_result->execute($saleslastname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$salesLast = $row['meta_value'];
			}
			sync_logging ('Get sales last name', $sellerTranID);
		sync_logging ('Before Header Insert', $sellerTranID);	
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
					$parms9[':bfirst'] = $BuyerFname;
					$parms9[':blast'] = $BuyerLname;
					$parms9[':first'] = $firstname;
					$parms9[':last'] = $lastname;
					$parms9[':company'] = $company;
					$parms9[':phone'] = $phone;
					$parms9[':bemail'] = $BuyerEmail;
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
sync_logging ('Entered Header Data', $sellerTranID);
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
sync_logging ('Before Lines', $sellerTranID);			
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
					}}

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
sync_logging ('After Lines', $sellerTranID);
include ('./wp-content/themes/Walleto/lib/my_account/eulapdf.php');
sync_logging ('Before PDF', $sellerTranID);
generatepdf($shiptype, $uid, $quoteid, $quoteDate, $company, $firstname, $lastname, $description, 
$user_email, $phone, $start_date, $industry, $newp, 
				$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry, 
				$shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry, 
				$po, $billname, $shipname, $discount, $arrivaldate, $billattn, $shipattn, 
				$totalTax, $PaypalAmountpaid, $serialDB, 0, 1, $salesFullName, $salesEmail, $salesPhone, $preparedFullName, $preparedEmail, $preparedPhone, $timestamp, $oid);
sync_logging ('After pdf', $sellerTranID);
			//BuyerEmail='$BuyerEmail'
			//PaypalAmountPaid='$PaypalAmountpaid', Paypal Transaction Date='$PaypalTranDate'
			//$wpdb->query("update ".$wpdb->prefix."walleto_orders  set paid='1', paid_on='$datemade', PaypalSellerTransactionID ='$sellerTranID', PaypalAmountPaid='$PaypalAmountpaid', PaypalTransactionDate='$PaypalTranDate', BuyerFirstName='$BuyerFname', BuyerLastName='$BuyerLname', BuyerEmail='$BuyerEmail' where id='$idso'");
			//$pids 	= $row->pid;
			//$oid 	= $idso;
			//$digital_good = get_post_meta($pids, 'digital_good',true);
							
			//if($digital_good == "1")
			//{
			//	$tm = current_time('timestamp',0);
			//	$er_s = "update ".$wpdb->prefix."walleto_order_contents set shipped='1', shipped_on='$tm' where orderid='$oid' and pid='$pids' ";
			//	$wpdb->query($er_s);
								

			//	$er_s = "update ".$wpdb->prefix."walleto_orders set shipped_on='$tm', partially_shipped='1', fully_shipped='1' where id='$oid'";
			//	$wpdb->query($er_s);
								 
			//}
		
		
		$s = "select users.user_email from  ".$wpdb->prefix."users users WHERE users.ID = '$uid'";
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
		
	} 
 }
   

?>