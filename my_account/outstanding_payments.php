<?php
/***************************************************************************
*
*	Walleto - copyright (c) - sitemile.com
*	The best wordpress premium theme for having a marketplace. Sell and buy all kind of products, including downloadable goods. 
*	Have a niche marketplace website in minutes. Turn-key solution.
*
*	Coder: Andrei Dragos Saioc
*	Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
*	More info about the theme here: http://sitemile.com/products/walleto-wordpress-marketplace-theme/
*	since v1.0.1
*
*	Dedicated to my wife: Alexandra
*
***************************************************************************/


if(!function_exists('Walleto_my_account_display_outstanding_pay_page'))
{
function Walleto_my_account_display_outstanding_pay_page()
{

	header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");

require './wp-content/themes/Walleto/connectPDO.php';
	unset($_SESSION['tempuser'], $_SESSION['renew'], $_SESSION['tempcomp'], $_SESSION['my_cart'], $_SESSION['editquote'], $_SESSION['renewal'], $_SESSION['edit'], $_SESSION['renew'], $_SESSION['shiptype']);
	global $wpdb;
	 $qcomp = $_SESSION['comp'];
	 if(isset($_POST['back']))
	 {
		header('Location: '.bloginfo('siteurl').'/rentscan/my-account/outstanding-payments/?key1=1');
		die;
	 }
unset ($_SESSION['comp']);
if (isset($_GET['q'])){
	$qcomp = $_GET['q'];
}

if((isset($_POST['submitCustom'])) || (isset($_POST['quoteInformation']))){
$required = array('customerQuoteID', 'customerTransID', 'customAmount');

// Loop over field names, make sure each one exists and is not empty
$error = false;
if(isset($_POST['submitCustom'])){
foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}
}
		$customerQuoteID = $_POST['customerQuoteID'];
		$customerTransID = $_POST['customerTransID'];
		$customAmount = $_POST['customAmount'];
if ($error) {

		echo '<font size="2" color="red"><b>&nbsp;* All fields are required.</b></font><br/>';

} else if(isset($_POST['submitCustom']) ){

		echo '<font size="2" color="Green"><b>&nbsp;* Order Processed.</b></font><br/>';
		global $wpdb;

		$quoteid				= $customerQuoteID;
		$sellerTranID 			= $customerTransID;
		$PaypalAmountpaid		= $customAmount;


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


	}
}

if (isset($_GET['order'])){
$proceed = 0;
echo Walleto_get_users_links();
?>

<table width="760" border="0" cellspacing="0" cellpadding="0">
<span class="box_title my_account_title">Create Order</span>

 <form method="post" action="<?php echo $current_file ?>">
 <tr>
	<th style="padding-left:15px;width:25%;" align="left">
	 <?php _e('Valid Quote Number:',$current_theme_locale_name) ?></th>
	 <th width="50px"><input type="text" name="customerQuoteID" style ="float:left;background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo htmlspecialchars($customerQuoteID) ?>">
	</th>
<?php

		$query_result = $DBH->prepare("SELECT COUNT(QUOTE_ID) FROM wp_quote_headers WHERE QUOTE_ID = '$customerQuoteID' AND STATUS = 'ACTIVE'");


		$query_result->execute($customeQID); 
		
		if($query_result->fetchColumn()){
			$proceed = 1;
		$query_result1 = $DBH->prepare("SELECT COMPANY, TOTAL_AMOUNT FROM wp_quote_headers WHERE QUOTE_ID = '$customerQuoteID'");


		$query_result1->execute($customeQIDTrans); 
		$data = $query_result1->fetchAll();           
		foreach($data as $row){
			$customComp = $row['COMPANY'];
			$customTotalAmount = $row['TOTAL_AMOUNT'];
		}
?>
	<th align="left" style="float:left;padding-left:15px;"><font size="2" color="Green"><b><?php _e('Customer Name:',$current_theme_locale_name) ?></th></b></font>
	<th style="float:left;padding-left:15px;"><?php echo $customComp; ?></th>
<?php
		}
?>
	
	 <?php
	 if($proceed != 1){
		if(($customerQuoteID != '') && (!isset($_POST['submitCustom']) )){
			echo '<th style="float:left;padding-left:15px;"><font size="2" color="red"><b>&nbsp;* Invalid Quote Number.</b></font></th>';
		}
	 ?>
	 </tr>
	 <tr>
	 <th style="padding-left:15px;float:left;" >
	<input name="quoteInformation" type="submit" value="Proceed"  />
	</th>
	<?php } ?>
	</tr>
<?php
	if($proceed == 1){
?>
	<tr>
	<th style="padding-left:15px;width:150px;" align="left">
	 <?php _e('PayPal Transaction ID:',$current_theme_locale_name) ?></th>
	 <th><input type="text" name="customerTransID" style ="float:left;background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo htmlspecialchars($customerTransID) ?>">
	</th>
	</tr>
	 <tr>
	<th style="padding-left:15px;width:150px;" align="left">
	 <?php _e('Amount Charged:',$current_theme_locale_name) ?></th>
	 <th><input type="text" name="customAmount" style ="float:left;background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo htmlspecialchars($customAmount) ?>">
	</th>

	<th style="float:left;padding-left:15px;"><font size="2" color="Green"><b><?php _e('Quote Amount:',$current_theme_locale_name) ?></th></b></font>
	<th style="float:left;padding-left:15px;">$<?php echo $customTotalAmount; ?></th>

	</tr>
	<tr><th style="float:left;padding-left:15px;" >
	<input name="submitCustom" type="submit" value="Create Order"  />
	</th></tr>
	</form>
	
<?php } ?>
</table>
<?php
	
	echo '<tr height="8">&nbsp;</tr>';
	get_footer();
	die;
}

	$id = $_GET['thekey'];
	if (isset($_POST['reset'])){
	

								
	
	
	
	/* $user_pass = wp_generate_password( 8, false);
	$user_pass1 = wp_hash_password($user_pass);
              $query_result = $DBH->prepare("UPDATE  `wp_users` SET user_pass = :pass WHERE user_email = '$id'");
			  $parm11[':pass'] = $user_pass1;
									$query_result->execute($parm11);   */
			  
			                                  $s = "select * from ".$wpdb->prefix."users WHERE wp_users.user_email = '$id'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $uid       = $row1->ID;
								
                                }
                                                                                                                $query_result = $DBH->prepare("UPDATE  `wp_users` SET  USER_TYPE = :reseller WHERE `ID` = $uid");
                                                                                                                $parm7[':reseller'] = $reseller;
                                                                                                                $query_result->execute($parm7);  
              

$admin_email = get_admin_email();
 /*                                                                                                               
        $message = "Hi {$first},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\nStep 2: Review your quotation\nStep 3: Click &quot;pay&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$id}\nPassword: {$user_pass}\r\n\r\nWe recommend changing your password after your initial login. Once you are logged in, under the My Account Menu click on the &rsquo;Personal Info&rsquo; link to change your password.\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
"; 
        $message1 = "Hi {$first},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\nStep 2: Review your quotation\nStep 3: Click &quot;pay&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$id}\r\n\r\nWe recommend changing your password after your initial login. Once you are logged in, under the My Account Menu click on the &rsquo;Personal Info&rsquo; link to change your password.\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
"; 
*/
	                                $message = "{$first}, \r\n\r\n      A quote has been created for you. To view your quote, Please login into your account using the information below:
                                \r\n".network_site_url('/wp-login.php')." \r\n\r\n Usename: {$user_email} \r\n Password: {$user_pass} \r\n\r\n 
                                We recommend you change your password after your initial login. Once you are logged in, under the My Account Menu click on the 'Personal Info' link to change your password..\r\n\r\n

If you experience any difficulties, please contact us at (888) 425-8228.";
                                $message1 = "{$first}, \r\n\r\n      A quote has been created for you. To view your quote, Please login into your account using the information below:
                                \r\n".network_site_url('/wp-login.php')." \r\n\r\n Usename: {$user_email} \r\n\r\n 
                                We recommend you change your password after your initial login. Once you are logged in, under the My Account Menu click on the 'Personal Info' link to change your password..\r\n\r\n

If you experience any difficulties, please contact us at (888) 425-8228.
";
                                Walleto_send_email($user_email, $subject = "RentScan Quote Approved", $message);
								/*
                                Walleto_send_email($id, $subject = "Complete Your RentScan Order", $message);
                                Walleto_send_email1($sales_email, $subject = "Complete Your RentScan Order", $message1, 'quote_create', 'inside_sales'); 
								*/
									$parm11[':pass'] = $user_pass;
									$query_result->execute($parm11);                                                                                                   
	echo 'Email Sent';
	}
	if (isset($_POST['first'])){
	
		$id = $_GET['thekey'];
																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.user_email = '$id' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'BILLING_ADDRESS'");
                                               $query_result->execute($parms70);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
																$billaddressID = $row2['ADDRESS_ID'];
																$billname = $row2['CUSTOMER_NAME'];
																$billattn = $row2['ATTENTION'];
																$billStreet1 = $row2['ADDRESS1'];
																$billStreet2 = $row2['ADDRESS2'];
																$billCity = $row2['CITY'];
																$billState = $row2['STATE'];
																$billZip = $row2['ZIP'];
																$billCountry = $row2['COUNTRY'];
																}
																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.user_email = '$id' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'SHIPPING_ADDRESS'");
                                               $query_result->execute($parms71);      
                                $data = $query_result->fetchAll();        
																foreach($data as $row2){
																$shipaddressID = $row2['ADDRESS_ID'];
																$shipname = $row2['CUSTOMER_NAME'];
																$shipattn = $row2['ATTENTION'];
																$shipStreet1 = $row2['ADDRESS1'];
																$shipStreet2 = $row2['ADDRESS2'];
																$shipCity = $row2['CITY'];
																$shipState = $row2['STATE'];
																$shipZip = $row2['ZIP'];
																$shipCountry = $row2['COUNTRY'];
																
                                                                	}
				$checkedthis = trim($_POST['checkedthis']);
				$emailSend = trim($_POST['emailSend']);
				$sales = trim($_POST['sales']);
				$description = trim($_POST['description']);
				$blackListed = trim($_POST['blackListed']);
					if ($blackListed == 'approved'){
					$blackListed = 1;
				}
				$sameshipping = trim($_POST['billingtoo']);												
				$company = trim($_POST['company']);
				$firstname = trim($_POST['first']);
				$lastname = trim($_POST['last']);

				$user_email = trim($_POST['user_email']);
				$phone = trim($_POST['phone']);
				$address10 = trim($_POST['addy']);
				$address11 = trim($_POST['addy1']);

				$industry = trim($_POST['industry']);
				
				if (($_POST['addy'] != NULL) || ($_POST['addy'] == 'New Address')){
				$billname = trim($_POST['billcustomer']);
				$billattn = trim($_POST['billattn']);

				$billStreet1 = trim($_POST['billStreet1']);
				$billStreet2 = trim($_POST['billStreet2']);

				$billCity = trim($_POST['billCity']);
				$billState = trim($_POST['billState']);

				$billZip = trim($_POST['billZip']);
				$billCountry = trim($_POST['billCountry']);
				}

				if (($_POST['addy1'] != NULL) || ($_POST['addy1'] == 'New Address')){
				$shipname = trim($_POST['shipcustomer']);
				$shipattn = trim($_POST['shipattn']);
				
				$shipStreet1 = trim($_POST['shipStreet1']);
				$shipStreet2 = trim($_POST['shipStreet2']);

				$shipCity = trim($_POST['shipCity']);
				$shipState = trim($_POST['shipState']);

				$shipZip = trim($_POST['shipZip']);
				$shipCountry = trim($_POST['shipCountry']);
				}
				$taxexempt = trim($_POST['taxexempt']);
				$poApproved = trim($_POST['poApproved']);
				if ($poApproved == 'approved'){
					$poApproved = 1;
				}
				
				$ctype = trim($_POST['ctype']);
			
if($ctype == 'Customer')
$ctype = 0;
else if ($ctype == 'Reseller')
$ctype = 2;
else if ($ctype == 'Sales')
$ctype = 3;
else if ($ctype == 'Admin')
$ctype = 4;

		$description = stripslashes($description);
$company = stripslashes($company);
$firstname = stripslashes($firstname);
$lastname = stripslashes($lastname);
$address10 = stripslashes($address10);
$address11 = stripslashes($address11);
$billname = stripslashes($billname);
$billattn = stripslashes($billattn);
$billStreet1 = stripslashes($billStreet1);
$billStreet2 = stripslashes($billStreet2);
$billCity = stripslashes($billCity);
$billState = stripslashes($billState);
$billZip = stripslashes($billZip);
$billCountry = stripslashes($billCountry);
$shipname = stripslashes($shipname);
$shipattn = stripslashes($shipattn);
$shipStreet1 = stripslashes($shipStreet1);
$shipStreet2 = stripslashes($shipStreet2);
$shipCity = stripslashes($shipCity);
$shipState = stripslashes($shipState);
$shipZip = stripslashes($shipZip);
$shipCountry = stripslashes($shipCountry);
$taxexempt = stripslashes($taxexempt);
$billaddressID = stripslashes($billaddressID);
$shipaddressID = stripslashes($shipaddressID);
				
				$errors = Walleto_register_new_user_sitemile3($fields_method, $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $newp,
				$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry = 'US', $shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry = 'US', $address10, $address11, $ctype,
				$taxexempt, $poApproved, $billname, $shipname, $billaddressID, $shipaddressID, $sameshipping, $billattn, $shipattn, $emailSend, $description, $blackListed, $sales, $checkedthis);
				}

	if (isset($_POST['company1'])){

	$qcomp = trim($_POST['company1']);
	$qcomp = stripslashes($qcomp);
	}
	
	if (isset($_GET['thekey1'])){
unset ($_SESSION['my_cart']);
 $temp = $_GET['thekey1'];
		$_SESSION['tempuser'] = $_GET['thekey1'];
		 $query_result = $DBH->prepare("SELECT wp_usermeta.meta_value FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.ID = '$temp'");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();        
                                
                                                                foreach($data1 as $row1){
																$company2 = $row1['meta_value'];
                                                                }
		$_SESSION['tempcomp'] = $company2;
		header ('Location: ../../what-we-rent');
	}
	$trig = 0;
			if(isset($_POST['newCustomer'])){
		$company = $_POST['company1'];
		$company = stripslashes($company);
		$trig = 1;
		
		}
	if ((isset($_GET['thekey'])) || ($trig == 1) || $errors == 1){
	
	?>
	                            <form method="post" action="<?php echo $current_file ?>" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
<!--<input type="hidden" name="redirect" value="http://www.myscannerrental.com/thanks-from-rentscan.html">
<input type="hidden" name="errorredirect" value="http://www.myscannerrental.com/resubmit-rentscan-quote-request.html">-->

<div id="SignUp">
<table width="900" class="signupframe1" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<input type="hidden" name="action" value="register" />
     
    </tr>
	<tr>
					
					<?php
					
					global $current_user;
					$user_email = $_GET['thekey'];
												$query_result = $DBH->prepare("SELECT wp_users.ORACLE_SALESREP_ID, wp_users.COMMENTS, wp_users.DISCREPANT_FLAG, wp_users.USER_TYPE, wp_users.PO_APPROVED FROM wp_users WHERE wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms9);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){

																$ctype = $row2['USER_TYPE'];
																$sales = $row2['ORACLE_SALESREP_ID']; 
																$poApproved = $row2['PO_APPROVED'];
																$blackListed = $row2['DISCREPANT_FLAG'];
																$description = $row2['COMMENTS'];
																}
																
?>
			
      <td valign="top" align="left">
	  <?php 
					
					
					global $wpdb;       

                               
                                $query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'industry' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();        
                                
                                                                foreach($data1 as $row1){
																$industry = $row1['meta_value'];
                                                                }

																$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'user_phone' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms4);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){

																$phone = $row2['meta_value'];
                                                                }	
																
																$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms5);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
                                                               	$company = $row2['meta_value'];
																}
																$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'first_name' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms6);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){

																$firstname = $row2['meta_value'];

                                                                }	
																$query_result = $DBH->prepare("SELECT wp_usermeta.meta_value, wp_users.USER_TYPE FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'last_name' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms7);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){

																$lastname = $row2['meta_value'];
																
																}


																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.user_email = '$user_email' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'BILLING_ADDRESS'");
                                               $query_result->execute($parms73);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
																$billID = $row2['ADDRESS_ID'];
																$billname = $row2['CUSTOMER_NAME'];
																$billattn = $row2['ATTENTION'];
																$billStreet1 = $row2['ADDRESS1'];
																$billStreet2 = $row2['ADDRESS2'];
																$billCity = $row2['CITY'];
																$billState = $row2['STATE'];
																$billZip = $row2['ZIP'];
																$billCountry = $row2['COUNTRY'];
																}
											$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.user_email = '$user_email' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'SHIPPING_ADDRESS'");
                                               $query_result->execute($parms74);      
                                $data = $query_result->fetchAll();        
																foreach($data as $row2){
																$shipID = $row2['ADDRESS_ID'];
																$shipname = $row2['CUSTOMER_NAME'];
																$shipattn = $row2['ATTENTION'];
																$shipStreet1 = $row2['ADDRESS1'];
																$shipStreet2 = $row2['ADDRESS2'];
																$shipCity = $row2['CITY'];
																$shipState = $row2['STATE'];
																$shipZip = $row2['ZIP'];
																$shipCountry = $row2['COUNTRY'];
																
                                                                	}


			
				?>

	          <?php _e('Company:',$current_theme_locale_name) ?><br />
        <?php
if(!isset($_GET['thekey'])){
?> 
        <input type="text" name="company" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $company; ?>"><br />
 <?php } else {
 ?>
 <input type="text" disabled=disabled  name="company" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $company; ?>"><br />
 <?php
 }?>
	  
        <span class="required">*</span><?php _e('First Name:',$current_theme_locale_name) ?><br />
   <input type="text" name="first" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $firstname; ?>" ><br />
      
        <span class="required">*</span><?php _e('Last Name:',$current_theme_locale_name) ?><br />
 
        <input type="text" name="last" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $lastname; ?>"><br />
  
         <span class="required">*</span><?php _e('Phone:',$current_theme_locale_name) ?> <br />
    
        <input type="text" name="phone" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: 999-999-9999" value = "<?php echo $phone; ?>"><br />
  
        <span class="required">*</span><?php _e('E-mail:',$current_theme_locale_name) ?><br />
     <?php
if(!isset($_GET['thekey'])){
?>
        <input type="text" name="user_email" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: sample@example.com" value = "<?php echo $user_email; ?>"><br />
 <?php } else {
 echo $user_email;
 $user_email1 = $user_email;
 }?><p><br>
        <span class="required">*</span><?php _e('Industry:',$current_theme_locale_name) ?><br />
    
       <select name="industry">
          <option>Select</option>
          <option value="Business Services"<?php if(isset($industry) && $industry == 'Business Services') 
          echo ' selected="selected"';
    ?>>Business Services</option>
          <option value="Education"<?php if(isset($industry) && $industry == 'Education') 
          echo ' selected="selected"';
    ?>>Education</option>
          <option value="Finance"<?php if(isset($industry) && $industry == 'Finance') 
          echo ' selected="selected"';
    ?>>Finance</option>
          <option value="Government"<?php if(isset($industry) && $industry == 'Government') 
          echo ' selected="selected"';
    ?>>Government</option>
          <option value="Healthcare"<?php if(isset($industry) && $industry == 'Healthcare') 
          echo ' selected="selected"';
    ?>>Healthcare</option>
          <option value="IT"<?php if(isset($industry) && $industry == 'IT') 
          echo ' selected="selected"';
    ?>>Information Technology</option>
          <option value="Legal"<?php if(isset($industry) && $industry == 'Legal') 
          echo ' selected="selected"';
    ?>>Legal</option>
          <option value="Manufacturing"<?php if(isset($industry) && $industry == 'Manufacturing') 
          echo ' selected="selected"';
    ?>>Manufacturing</option>
          <option value="Real Estate"<?php if(isset($industry) && $industry == 'Real Estate') 
          echo ' selected="selected"';
    ?>>Real Estate</option>
          <option value="Retail"<?php if(isset($industry) && $industry == 'Retail') 
          echo ' selected="selected"';
    ?>>Retail</option>
          <option value="Other"<?php if(isset($industry) && $industry == 'Other') 
          echo ' selected="selected"';
    ?>>Other</option>
        </select><br /><br />

		<td valign="top" align="left">
		<?php
		if ($current_user->USER_TYPE > 3){?>
		 							 <script>
jQuery(document).ready(function($) {
   // STOCK OPTIONS
	$("#selectable").change(function(){
		if ( $(this).val() == "Sales" ) 
    $(this).next('div.checkbox2').show();
else
    $(this).next('div.checkbox2').hide();
	}).change();
});
 </script>
		<?php }
							if ($current_user->USER_TYPE > 3){
					_e('User Type:',$current_theme_locale_name) ?>

 						<select id = "selectable" name="ctype">
 
          <option value="Customer"<?php if(isset($ctype) && $ctype <= 1) 
          echo ' selected="selected"';
		      ?>>Customer</option>
			  <option value="Reseller"<?php if(isset($ctype) && $ctype == 2) 
          echo ' selected="selected"';
		      ?>>Reseller</option>
			  <option class="sales" value="Sales"<?php if(isset($ctype) && $ctype == 3) 
          echo ' selected="selected"';
		      ?>>Sales Rep</option>
			  <?php if ($current_user->USER_TYPE >= 4){?>
			  			  <option value="Admin"<?php if(isset($ctype) && $ctype == 4) 
          echo ' selected="selected"';
		      ?>>RentScan Admin</option>
			  <?php } ?>
			  </select>



 		

			<div class="checkbox2">
				<span class="required"></span><?php _e('* Oracle Salesperson:',$current_theme_locale_name) ?><br/>
				<select name="sales">



<option value="salesperson">Salesperson</option>
<?php 



	$query_result = $DBH->prepare("SELECT SALESPERSON_NAME, SALESPERSON_ORACLE_ID
								FROM wp_salesperson
								WHERE ((DATE_FORMAT( now( ) , '%Y-%m-%d' ) >= START_DATE_ACTIVE) OR START_DATE_ACTIVE = '0000-00-00 00:00:00')
								AND ((DATE_FORMAT( now( ) , '%Y-%m-%d' ) <= END_DATE_ACTIVE) OR END_DATE_ACTIVE = '0000-00-00 00:00:00') ORDER BY SALESPERSON_NAME");
                                               $query_result->execute($parms13);      
                                $data = $query_result->fetchAll();        
                        
                                foreach($data as $row2){
									$salesName = $row2['SALESPERSON_NAME'];
									$salesOracleID = $row2['SALESPERSON_ORACLE_ID'];
									
?>
<option class="trunc1" value="<?php echo $row2['SALESPERSON_ORACLE_ID'] ?>" <?php if ($row2['SALESPERSON_ORACLE_ID'] == $sales) echo 'selected = selected' ?>><?php echo $salesName ?></option>
<?php } ?>
</select>
			</div>
		</td>
					<?php	}	
																	$query_result = $DBH->prepare("SELECT wp_users.DISCREPANT_FLAG FROM wp_users WHERE wp_users.user_email = '$users'");
                                               $query_result->execute($parms9);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
																$blackListed = $row2['DISCREPANT_FLAG'];
																}
			
					if($blackListed != 1) {
					if ($_GET['thekey'] != NULL) {?>
					
								 <td style="vertical-align:text-top;"><input type="hidden" size="4" class="do_input" name="thekey2" value="<?php echo $userid ?>" />
								 <input type="submit" value="Create Order"  /></td>
								 <?php } }?>
		<?php /* if ($current_user->user_email == NULL) { ?> 
        <span class="required">*</span><?php _e('Password:',$current_theme_locale_name) ?><br />
     
        <input autocomplete="off" type="password" name="pass" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "" value = ""><br />
 
 <span class="required">*</span><?php _e('Re-type Password:',$current_theme_locale_name) ?><br />
     
        <input autocomplete="off" type="password" name="reppass" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "" value = ""><br />
<?php } */ ?>
		<tr>

</td>
<?php
if (isset($user_email1)){
$query_result = $DBH->prepare("SELECT ID, USER_TYPE, TAX_EXEMPT_NUMBER, TAX_EXEMPT_FLAG FROM wp_users  WHERE user_email = '$user_email1'");
                                               $query_result->execute($parms12);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$userid = $row2['ID'];
																$user_type = $row2['USER_TYPE'];
																$taxexempt = $row2['TAX_EXEMPT_NUMBER'];
																$checkedthis = $row2['TAX_EXEMPT_FLAG'];
																}
}


											
$billto = $_GET['billto'];
$shipto = $_GET['shipto'];

if (isset($_GET['shipto'])){

$val =  '?shipto='.$shipto.'&billto=';
}
else
$val = '?billto=';

if (isset($_GET['billto'])){

$val1 =  '?billto='.$billto.'&shipto=';
}
else
$val1 = '?shipto=';





$tempuser = $_SESSION['tempuser'];
$x=0;

?>
<html>
<head>
<script>
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","../../wp-content/themes/Walleto/lib/getaddress.php?q="+str,true);
xmlhttp.send();
}
function showUser2(str)
{
if (str=="")
  {
  document.getElementById("txtHint2").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","../../wp-content/themes/Walleto/lib/getaddress.php?r="+str,true);
xmlhttp.send();
}
function showUser3(str)
{
if (str=="")
  {
  document.getElementById("txtHint4").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint4").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","../../wp-content/themes/Walleto/lib/getaddress.php?t="+str,true);
xmlhttp.send();
}


</script>
</head>
<body>

<td><div id="txtHints"><b>Billing Information</b>
</td><td>
<!--<input id = "checkboxID" type="checkbox" name="sameshipping" value="checked">Check if Billing is same as Shipping</input><div id="txtHints"> -->
<b>Shipping Information</b></td>

<tr>

<td>

<!--<script>
$("#checkboxID").click(function ()
{
    if ($("#checkboxID").attr("checked"))
    {
        $("#txtHint2").hide();
		$("#txtHint3").hide();
    }
    else
    {
        $("#txtHint2").show();
		$("#txtHint3").show();
    }              
});

</script>
-->
<select class="trunc1" name="addy" onchange="showUser(this.value)">



<option value="New Address">New Address</option>
<?php 



	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'BILLING_ADDRESS' AND USER_ID = '$userid' ORDER BY ADDRESS1");
                                               $query_result->execute($parms13);      
                                $data = $query_result->fetchAll();        
                        
                                foreach($data as $row2){
									$address_display = $row2['CUSTOMER_NAME'].', '.$row2['ADDRESS1'].', '
									.$row2['ADDRESS2'].', '.$row2['CITY'].', '.$row2['STATE'].', '.$row2['ZIP'];
?>
<option class="trunc1" value="<?php echo $row2['ADDRESS_ID'] ?>" <?php if ($row2['ADDRESS_ID'] == $billID) echo 'selected = selected' ?>><?php echo $address_display ?></option>
<?php } ?>
</select>


</td>


</div>




<td>


<div style="width:300px" id="txtHint3">
<select class="trunc1" name="addy1" onchange="showUser2(this.value)">


<option value="New Address">New Address</option>
<?php 

if (!isset($_GET['thekey'])){
unset($userid);
}

	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'SHIPPING_ADDRESS'  AND USER_ID = '$userid' ORDER BY ADDRESS1");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                          foreach($data as $row2){
									$address_display2 = $row2['CUSTOMER_NAME'].', '.$row2['ADDRESS1'].', '
									.$row2['ADDRESS2'].', '.$row2['CITY'].', '.$row2['STATE'].', '.$row2['ZIP'];
?>
<option class="trunc1" value="<?php echo $row2['ADDRESS_ID'] ?>" <?php if ($row2['ADDRESS_ID'] == $shipID) echo 'selected = selected' ?>><?php echo $address_display2 ?></option>
<?php }


 ?>
</select>
</tr><tr><td>&nbsp;</td></tr><tr><td></td>
<td>
<?php if($shipID == NULL) { ?>
<input type="checkbox" onclick="FillBilling(this.form)" name="billingtoo">

<em>Check if Billing is same as Shipping</em>
<?php }  ?>


</td>
</tr>
<script>
function FillBilling(f) {
  if(f.billingtoo.checked == true) {
    f.shipcustomer.value = f.billcustomer.value;
	f.shipattn.value = f.billattn.value;
	f.shipStreet1.value = f.billStreet1.value;
	f.shipStreet2.value = f.billStreet2.value;
    f.shipCity.value = f.billCity.value;
	f.shipState.value = f.billState.value;
	f.shipZip.value = f.billZip.value;
  }
    if(f.billingtoo.checked == false) {
	f.shipcustomer.value = '';
	f.shipattn.value = '';
	f.shipStreet1.value = '';
	f.shipStreet2.value = '';
    f.shipCity.value = '';
	f.shipState.value = '';
	f.shipZip.value = '';
  }
}
</script>

</div>
</td>
</tr>

<tr><td style="width:100px">

	<div style="width:500px" id="txtHint"> 
		
  <span class="required">*</span><?php _e('Bill to Company Name:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="billcustomer" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billname; ?>" ><br />
		
		<span class="required"></span><?php _e('Bill to Attn:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="billattn" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billattn; ?>" ><br />
		
		<span class="required">*</span><?php _e('Bill to Address1:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone1"  type="text" name="billStreet1" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billStreet1; ?>" ><br />
		      
		<span class="required"></span><?php _e('Bill to Address2:',$current_theme_locale_name) ?><br />
		
		<input id="thisone2"  type="text" name="billStreet2" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billStreet2; ?>" ><br />
      
        <span class="required">*</span><?php _e('Bill to City:',$current_theme_locale_name) ?><br />
 
        <input id="thisone3"  type="text" name="billCity" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billCity; ?>"><br />
  
       <div >
		<span class="required ">*</span><?php _e('Bill to State:',$current_theme_locale_name) ?><br />
    
       <select name="billState" >
          <option>Select</option>
          <option value="Alabama"<?php if(isset($billState) && $billState == 'Alabama') 
          echo ' selected="selected"';
    ?>>Alabama</option>
          <option value="Alaska"<?php if(isset($billState) && $billState == 'Alaska') 
          echo ' selected="selected"';
    ?>>Alaska</option>
          <option value="American Samoa"<?php if(isset($billState) && $billState == 'American Samoa') 
          echo ' selected="selected"';
    ?>>American Samoa</option>
          <option value="Arizona"<?php if(isset($billState) && $billState == 'Arizona') 
          echo ' selected="selected"';
    ?>>Arizona</option>
          <option value="Arkansas"<?php if(isset($billState) && $billState == 'Arkansas') 
          echo ' selected="selected"';
    ?>>Arkansas</option>
          <option value="California"<?php if(isset($billState) && $billState == 'California') 
          echo ' selected="selected"';
    ?>>California</option>
          <option value="Colorado"<?php if(isset($billState) && $billState == 'Colorado') 
          echo ' selected="selected"';
    ?>>Colorado</option>
          <option value="Connecticut"<?php if(isset($billState) && $billState == 'Connecticut') 
          echo ' selected="selected"';
    ?>>Connecticut</option>
          <option value="Delaware"<?php if(isset($billState) && $billState == 'Delaware') 
          echo ' selected="selected"';
    ?>>Delaware</option>
          <option value="District of Columbia"<?php if(isset($billState) && $billState == 'District of Columbia') 
          echo ' selected="selected"';
    ?>>District of Columbia</option>
          <option value="Florida"<?php if(isset($billState) && $billState == 'Florida') 
          echo ' selected="selected"';
    ?>>Florida</option>
	          <option value="Georgia"<?php if(isset($billState) && $billState == 'Georgia') 
          echo ' selected="selected"';
    ?>>Georgia</option>
	          <option value="Guam"<?php if(isset($billState) && $billState == 'Guam') 
          echo ' selected="selected"';
    ?>>Guam</option>
	          <option value="Hawaii"<?php if(isset($billState) && $billState == 'Hawaii') 
          echo ' selected="selected"';
    ?>>Hawaii</option>
	          <option value="Idaho"<?php if(isset($billState) && $billState == 'Idaho') 
          echo ' selected="selected"';
    ?>>Idaho</option>
	          <option value="Illinois"<?php if(isset($billState) && $billState == 'Illinois') 
          echo ' selected="selected"';
    ?>>Illinois</option>
	          <option value="Indiana"<?php if(isset($billState) && $billState == 'Indiana') 
          echo ' selected="selected"';
    ?>>Indiana</option>
	          <option value="Iowa"<?php if(isset($billState) && $billState == 'Iowa') 
          echo ' selected="selected"';
    ?>>Iowa</option>
	          <option value="Kansas"<?php if(isset($billState) && $billState == 'Kansas') 
          echo ' selected="selected"';
    ?>>Kansas</option>
		          <option value="Kentucky"<?php if(isset($billState) && $billState == 'Kentucky') 
          echo ' selected="selected"';
    ?>>Kentucky</option>
		          <option value="Louisiana"<?php if(isset($billState) && $billState == 'Louisiana') 
          echo ' selected="selected"';
    ?>>Louisiana</option>
		          <option value="Maine"<?php if(isset($billState) && $billState == 'Maine') 
          echo ' selected="selected"';
    ?>>Maine</option>
		          <option value="Maryland"<?php if(isset($billState) && $billState == 'Maryland') 
          echo ' selected="selected"';
    ?>>Maryland</option>
		          <option value="Massachusetts"<?php if(isset($billState) && $billState == 'Massachusetts') 
          echo ' selected="selected"';
    ?>>Massachusetts</option>
		          <option value="Michigan"<?php if(isset($billState) && $billState == 'Michigan') 
          echo ' selected="selected"';
    ?>>Michigan</option>
		          <option value="Minnesota"<?php if(isset($billState) && $billState == 'Minnesota') 
          echo ' selected="selected"';
    ?>>Minnesota</option>
		          <option value="Mississippi"<?php if(isset($billState) && $billState == 'Mississippi') 
          echo ' selected="selected"';
    ?>>Mississippi</option>
		          <option value="Missouri"<?php if(isset($billState) && $billState == 'Missouri') 
          echo ' selected="selected"';
    ?>>Missouri</option>
		          <option value="Montana"<?php if(isset($billState) && $billState == 'Montana') 
          echo ' selected="selected"';
    ?>>Montana</option>
		          <option value="Nebraska"<?php if(isset($billState) && $billState == 'Nebraska') 
          echo ' selected="selected"';
    ?>>Nebraska</option>
		          <option value="Nevada"<?php if(isset($billState) && $billState == 'Nevada') 
          echo ' selected="selected"';
    ?>>Nevada</option>
		          <option value="New Hampshire"<?php if(isset($billState) && $billState == 'New Hampshire') 
          echo ' selected="selected"';
    ?>>New Hampshire</option>
		          <option value="New Jersey"<?php if(isset($billState) && $billState == 'New Jersey') 
          echo ' selected="selected"';
    ?>>New Jersey</option>
		          <option value="New Mexico"<?php if(isset($billState) && $billState == 'New Mexico') 
          echo ' selected="selected"';
    ?>>New Mexico</option>
		          <option value="New York"<?php if(isset($billState) && $billState == 'New York') 
          echo ' selected="selected"';
    ?>>New York</option>
		          <option value="North Carolina"<?php if(isset($billState) && $billState == 'North Carolina') 
          echo ' selected="selected"';
    ?>>North Carolina</option>
		          <option value="North Dakota"<?php if(isset($billState) && $billState == 'North Dakota') 
          echo ' selected="selected"';
    ?>>North Dakota</option>
		          <option value="Northern Mariana Islands"<?php if(isset($billState) && $billState == 'Northern Mariana Islands') 
          echo ' selected="selected"';
    ?>>Northern Mariana Islands</option>
		          <option value="Ohio"<?php if(isset($billState) && $billState == 'Ohio') 
          echo ' selected="selected"';
    ?>>Ohio</option>
		          <option value="Oklahoma"<?php if(isset($billState) && $billState == 'Oklahoma') 
          echo ' selected="selected"';
    ?>>Oklahoma</option>
		          <option value="Oregon"<?php if(isset($billState) && $billState == 'Oregon') 
          echo ' selected="selected"';
    ?>>Oregon</option>
			          <option value="Pennsylvania"<?php if(isset($billState) && $billState == 'Pennsylvania') 
          echo ' selected="selected"';
    ?>>Pennsylvania</option>
			          <option value="Puerto Rico"<?php if(isset($billState) && $billState == 'Puerto Rico') 
          echo ' selected="selected"';
    ?>>Puerto Rico</option>
			          <option value="Rhode Island"<?php if(isset($billState) && $billState == 'Rhode Island') 
          echo ' selected="selected"';
    ?>>Rhode Island</option>
			          <option value="South Carolina"<?php if(isset($billState) && $billState == 'South Carolina') 
          echo ' selected="selected"';
    ?>>South Carolina</option>
			          <option value="South Dakota"<?php if(isset($billState) && $billState == 'South Dakota') 
          echo ' selected="selected"';
    ?>>South Dakota</option>
			          <option value="Tennessee"<?php if(isset($billState) && $billState == 'Tennessee') 
          echo ' selected="selected"';
    ?>>Tennessee</option>
			          <option value="Texas"<?php if(isset($billState) && $billState == 'Texas') 
          echo ' selected="selected"';
    ?>>Texas</option>
			          <option value="United States Virgin Islands"<?php if(isset($billState) && $billState == 'United States Virgin Islands') 
          echo ' selected="selected"';
    ?>>United States Virgin Islands</option>
			          <option value="Utah"<?php if(isset($billState) && $billState == 'Utah') 
          echo ' selected="selected"';
    ?>>Utah</option>
			          <option value="Vermont"<?php if(isset($billState) && $billState == 'Vermont') 
          echo ' selected="selected"';
    ?>>Vermont</option>
			          <option value="Virginia"<?php if(isset($billState) && $billState == 'Virginia') 
          echo ' selected="selected"';
    ?>>Virginia</option>
			          <option value="Washington"<?php if(isset($billState) && $billState == 'Washington') 
          echo ' selected="selected"';
    ?>>Washington</option>
			          <option value="West Virginia"<?php if(isset($billState) && $billState == 'West Virginia') 
          echo ' selected="selected"';
    ?>>West Virginia</option>
			          <option value="Wisconsin"<?php if(isset($billState) && $billState == 'Wisconsin') 
          echo ' selected="selected"';
    ?>>Wisconsin</option>
			          <option value="Wyoming"<?php if(isset($billState) && $billState == 'Wyoming') 
          echo ' selected="selected"';
    ?>>Wyoming</option>
			          <option value="Other"<?php if(isset($billState) && $billState == 'Other') 
          echo ' selected="selected"';
    ?>>Other</option>
	
        </select><br />
  </div>
 
        <span class="required">*</span><?php _e('Bill to Zip:',$current_theme_locale_name) ?><br />
     
        <input id="thisone5"  type="text" name="billZip" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: sample@example.com" value = "<?php echo $billZip; ?>"><br />


</div>
	</td>
	<td>

		<div style="width:300px" id="txtHint2">


  <span class="required">*</span><?php _e('Ship to Company Name:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="shipcustomer" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipname; ?>" ><br />
		
		<span class="required"></span><?php _e('Ship to Attn:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="shipattn" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipattn; ?>" ><br />
		
		<span class="required">*</span><?php _e('Ship to Address1:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone1"  type="text" name="shipStreet1" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipStreet1; ?>" ><br />
		      
		<span class="required"></span><?php _e('Ship to Address2:',$current_theme_locale_name) ?><br />
		
		<input id="thisone2"  type="text" name="shipStreet2" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipStreet2; ?>" ><br />
      
        <span class="required">*</span><?php _e('Ship to City:',$current_theme_locale_name) ?><br />
 
        <input id="thisone3"  type="text" name="shipCity" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipCity; ?>"><br />
  
    <div >
		<span class="required ">*</span><?php _e('Ship to State:',$current_theme_locale_name) ?><br />
    
       <select name="shipState" >
          <option>Select</option>
          <option value="Alabama"<?php if(isset($shipState) && $shipState == 'Alabama') 
          echo ' selected="selected"';
    ?>>Alabama</option>
          <option value="Alaska"<?php if(isset($shipState) && $shipState == 'Alaska') 
          echo ' selected="selected"';
    ?>>Alaska</option>
          <option value="American Samoa"<?php if(isset($shipState) && $shipState == 'American Samoa') 
          echo ' selected="selected"';
    ?>>American Samoa</option>
          <option value="Arizona"<?php if(isset($shipState) && $shipState == 'Arizona') 
          echo ' selected="selected"';
    ?>>Arizona</option>
          <option value="Arkansas"<?php if(isset($shipState) && $shipState == 'Arkansas') 
          echo ' selected="selected"';
    ?>>Arkansas</option>
          <option value="California"<?php if(isset($shipState) && $shipState == 'California') 
          echo ' selected="selected"';
    ?>>California</option>
          <option value="Colorado"<?php if(isset($shipState) && $shipState == 'Colorado') 
          echo ' selected="selected"';
    ?>>Colorado</option>
          <option value="Connecticut"<?php if(isset($shipState) && $shipState == 'Connecticut') 
          echo ' selected="selected"';
    ?>>Connecticut</option>
          <option value="Delaware"<?php if(isset($shipState) && $shipState == 'Delaware') 
          echo ' selected="selected"';
    ?>>Delaware</option>
          <option value="District of Columbia"<?php if(isset($shipState) && $shipState == 'District of Columbia') 
          echo ' selected="selected"';
    ?>>District of Columbia</option>
          <option value="Florida"<?php if(isset($shipState) && $shipState == 'Florida') 
          echo ' selected="selected"';
    ?>>Florida</option>
	          <option value="Georgia"<?php if(isset($shipState) && $shipState == 'Georgia') 
          echo ' selected="selected"';
    ?>>Georgia</option>
	          <option value="Guam"<?php if(isset($shipState) && $shipState == 'Guam') 
          echo ' selected="selected"';
    ?>>Guam</option>
	          <option value="Hawaii"<?php if(isset($shipState) && $shipState == 'Hawaii') 
          echo ' selected="selected"';
    ?>>Hawaii</option>
	          <option value="Idaho"<?php if(isset($shipState) && $shipState == 'Idaho') 
          echo ' selected="selected"';
    ?>>Idaho</option>
	          <option value="Illinois"<?php if(isset($shipState) && $shipState == 'Illinois') 
          echo ' selected="selected"';
    ?>>Illinois</option>
	          <option value="Indiana"<?php if(isset($shipState) && $shipState == 'Indiana') 
          echo ' selected="selected"';
    ?>>Indiana</option>
	          <option value="Iowa"<?php if(isset($shipState) && $shipState == 'Iowa') 
          echo ' selected="selected"';
    ?>>Iowa</option>
	          <option value="Kansas"<?php if(isset($shipState) && $shipState == 'Kansas') 
          echo ' selected="selected"';
    ?>>Kansas</option>
		          <option value="Kentucky"<?php if(isset($shipState) && $shipState == 'Kentucky') 
          echo ' selected="selected"';
    ?>>Kentucky</option>
		          <option value="Louisiana"<?php if(isset($shipState) && $shipState == 'Louisiana') 
          echo ' selected="selected"';
    ?>>Louisiana</option>
		          <option value="Maine"<?php if(isset($shipState) && $shipState == 'Maine') 
          echo ' selected="selected"';
    ?>>Maine</option>
		          <option value="Maryland"<?php if(isset($shipState) && $shipState == 'Maryland') 
          echo ' selected="selected"';
    ?>>Maryland</option>
		          <option value="Massachusetts"<?php if(isset($shipState) && $shipState == 'Massachusetts') 
          echo ' selected="selected"';
    ?>>Massachusetts</option>
		          <option value="Michigan"<?php if(isset($shipState) && $shipState == 'Michigan') 
          echo ' selected="selected"';
    ?>>Michigan</option>
		          <option value="Minnesota"<?php if(isset($shipState) && $shipState == 'Minnesota') 
          echo ' selected="selected"';
    ?>>Minnesota</option>
		          <option value="Mississippi"<?php if(isset($shipState) && $shipState == 'Mississippi') 
          echo ' selected="selected"';
    ?>>Mississippi</option>
		          <option value="Missouri"<?php if(isset($shipState) && $shipState == 'Missouri') 
          echo ' selected="selected"';
    ?>>Missouri</option>
		          <option value="Montana"<?php if(isset($shipState) && $shipState == 'Montana') 
          echo ' selected="selected"';
    ?>>Montana</option>
		          <option value="Nebraska"<?php if(isset($shipState) && $shipState == 'Nebraska') 
          echo ' selected="selected"';
    ?>>Nebraska</option>
		          <option value="Nevada"<?php if(isset($shipState) && $shipState == 'Nevada') 
          echo ' selected="selected"';
    ?>>Nevada</option>
		          <option value="New Hampshire"<?php if(isset($shipState) && $shipState == 'New Hampshire') 
          echo ' selected="selected"';
    ?>>New Hampshire</option>
		          <option value="New Jersey"<?php if(isset($shipState) && $shipState == 'New Jersey') 
          echo ' selected="selected"';
    ?>>New Jersey</option>
		          <option value="New Mexico"<?php if(isset($shipState) && $shipState == 'New Mexico') 
          echo ' selected="selected"';
    ?>>New Mexico</option>
		          <option value="New York"<?php if(isset($shipState) && $shipState == 'New York') 
          echo ' selected="selected"';
    ?>>New York</option>
		          <option value="North Carolina"<?php if(isset($shipState) && $shipState == 'North Carolina') 
          echo ' selected="selected"';
    ?>>North Carolina</option>
		          <option value="North Dakota"<?php if(isset($shipState) && $shipState == 'North Dakota') 
          echo ' selected="selected"';
    ?>>North Dakota</option>
		          <option value="Northern Mariana Islands"<?php if(isset($shipState) && $shipState == 'Northern Mariana Islands') 
          echo ' selected="selected"';
    ?>>Northern Mariana Islands</option>
		          <option value="Ohio"<?php if(isset($shipState) && $shipState == 'Ohio') 
          echo ' selected="selected"';
    ?>>Ohio</option>
		          <option value="Oklahoma"<?php if(isset($shipState) && $shipState == 'Oklahoma') 
          echo ' selected="selected"';
    ?>>Oklahoma</option>
		          <option value="Oregon"<?php if(isset($shipState) && $shipState == 'Oregon') 
          echo ' selected="selected"';
    ?>>Oregon</option>
			          <option value="Pennsylvania"<?php if(isset($shipState) && $shipState == 'Pennsylvania') 
          echo ' selected="selected"';
    ?>>Pennsylvania</option>
			          <option value="Puerto Rico"<?php if(isset($shipState) && $shipState == 'Puerto Rico') 
          echo ' selected="selected"';
    ?>>Puerto Rico</option>
			          <option value="Rhode Island"<?php if(isset($shipState) && $shipState == 'Rhode Island') 
          echo ' selected="selected"';
    ?>>Rhode Island</option>
			          <option value="South Carolina"<?php if(isset($shipState) && $shipState == 'South Carolina') 
          echo ' selected="selected"';
    ?>>South Carolina</option>
			          <option value="South Dakota"<?php if(isset($shipState) && $shipState == 'South Dakota') 
          echo ' selected="selected"';
    ?>>South Dakota</option>
			          <option value="Tennessee"<?php if(isset($shipState) && $shipState == 'Tennessee') 
          echo ' selected="selected"';
    ?>>Tennessee</option>
			          <option value="Texas"<?php if(isset($shipState) && $shipState == 'Texas') 
          echo ' selected="selected"';
    ?>>Texas</option>
			          <option value="United States Virgin Islands"<?php if(isset($shipState) && $shipState == 'United States Virgin Islands') 
          echo ' selected="selected"';
    ?>>United States Virgin Islands</option>
			          <option value="Utah"<?php if(isset($shipState) && $shipState == 'Utah') 
          echo ' selected="selected"';
    ?>>Utah</option>
			          <option value="Vermont"<?php if(isset($shipState) && $shipState == 'Vermont') 
          echo ' selected="selected"';
    ?>>Vermont</option>
			          <option value="Virginia"<?php if(isset($shipState) && $shipState == 'Virginia') 
          echo ' selected="selected"';
    ?>>Virginia</option>
			          <option value="Washington"<?php if(isset($shipState) && $shipState == 'Washington') 
          echo ' selected="selected"';
    ?>>Washington</option>
			          <option value="West Virginia"<?php if(isset($shipState) && $shipState == 'West Virginia') 
          echo ' selected="selected"';
    ?>>West Virginia</option>
			          <option value="Wisconsin"<?php if(isset($shipState) && $shipState == 'Wisconsin') 
          echo ' selected="selected"';
    ?>>Wisconsin</option>
			          <option value="Wyoming"<?php if(isset($shipState) && $shipState == 'Wyoming') 
          echo ' selected="selected"';
    ?>>Wyoming</option>
			          <option value="Other"<?php if(isset($shipState) && $shipState == 'Other') 
          echo ' selected="selected"';
    ?>>Other</option>
	
        </select><br />
  </div>
        <span class="required">*</span><?php _e('Ship to Zip:',$current_theme_locale_name) ?><br />
     
        <input id="thisone5"  type="text" name="shipZip" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: sample@example.com" value = "<?php echo $shipZip; ?>"><br />

		</div>
	</td>
</tr>


</body>
</html>  

 <!-- 
        <span class="required">*</span><?php _e('Start Date:',$current_theme_locale_name) ?><br />
  
        <select name="start_date">
          <option>Select</option>
          <option value="Immediately"<?php if(isset($start_date) && $start_date == 'Immediately') 
          echo ' selected="selected"';
    ?>>Immediately</option>
          <option value="1-2 Weeks"<?php if(isset($start_date) && $start_date == '1-2 Weeks') 
          echo ' selected="selected"';
    ?>>1-2 Weeks</option>
          <option value="2-6 Weeks"<?php if(isset($start_date) && $start_date == '2-6 Weeks') 
          echo ' selected="selected"';
    ?>>2-6 Weeks</option>
          <option value="6+ Weeks"<?php if(isset($start_date) && $start_date == '6+ Weeks') 
          echo ' selected="selected"';
    ?>>6+ Weeks</option>
          <option value="Unknown"<?php if(isset($start_date) && $start_date == 'Unknown') 
          echo ' selected="selected"';
    ?>>Unknown</option>
        </select><br /><br />
 
        <span class="required">*</span><?php _e('Project Details:',$current_theme_locale_name) ?><br />
        
         <textarea rows="3" cols="25" name="description"><?php echo htmlspecialchars($description);?></textarea><br /><br />        
        -->
      </td>
	  <tr>
	  <td colspan="8"><hr color="#711"  /></td>
    </tr>
	
    <input type="hidden" name="listid" value="32092">
    <input type="hidden" name="specialid:32092" value="7XT9">

    <input type="hidden" name="clientid" value="855981">
    <input type="hidden" name="formid" value="3882">
    <input type="hidden" name="reallistid" value="1">
    <input type="hidden" name="doubleopt" value="0">
	<?php 
	global $current_user;
$curuser = $current_user->USER_TYPE;

	if ($curuser == 5 && $user_type < 5){	
	 ?>



 <td style="vertical-align:text-top;">
 
 <script>
jQuery(document).ready(function($) {
   // STOCK OPTIONS
	$('input.checkthis').change(function(){
		if ($(this).is(':checked'))
    $(this).next('div.checkbox1').show();
else
    $(this).next('div.checkbox1').hide();
	}).change();
});
 </script>
 
 		
		<div id="checkbox2">
			<input type="checkbox" class="checkthis" name="checkedthis" value="checkedthis"<?php if (($checkedthis!=NULL) && ($taxexempt!=NULL)) echo 'checked=checked'?> > Approved for Tax Exempt
			<div class="checkbox1">
				<span class="required"></span><?php _e('Tax Exempt ID:',$current_theme_locale_name) ?><br/>
<input type="text" name="taxexempt" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $taxexempt; ?>" >

			</div>

			
		
 <div style="width:300px" id="txtHint4">
 
 
 </div>
 </td><td style="vertical-align:text-top;">
 
 <input type="checkbox" name="poApproved" <?php if ($poApproved != NULL) echo 'checked = checked'?> value="approved"><span class="required"></span><?php _e('Approved for PO:',$current_theme_locale_name) ?><br>
 <?php if ($_GET['thekey'] == NULL){ ?>
 
 <input type="checkbox" name="emailSend" <?php if ($emailSend != NULL) echo 'checked = checked'?> value="emailSend"><span class="required"></span><?php _e('Send Email:',$current_theme_locale_name) ?>
 <?php } ?>
 <?php if ($_GET['thekey'] != NULL){ ?>

 <input type="checkbox" name="blackListed" <?php if ($blackListed != 0) echo 'checked = checked'?> value="approved"> <span class="required"></span><?php _e('Delinquent Customer:',$current_theme_locale_name) ?>
 <?php } ?>
         <br/><span class="required"></span><?php _e('Comments:',$current_theme_locale_name) ?><br />
        
         <textarea rows="3" cols="25" name="description"><?php echo htmlspecialchars($description);?></textarea><br /><br />  

  <?php } ?>
    <tr align="center">
	
      <td>
								

			<input type="submit" name="back" type="image" value="Back" />
			
						      <input name="Submit" type="submit" value="Save"  />
						<!-- <input type="submit" name="agree_and_pay" value="'.__('Proceed to Payment','Walleto'). '" /> -->
   

					<?php 
					
																	$query_result = $DBH->prepare("SELECT wp_users.DISCREPANT_FLAG FROM wp_users WHERE wp_users.user_email = '$users'");
                                               $query_result->execute($parms9);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
																$blackListed = $row2['DISCREPANT_FLAG'];
																}
			
					if($blackListed != 1) {
					if ($_GET['thekey'] != NULL) {?>
					
									<input type="hidden" size="4" class="do_input" name="thekey2" value="<?php echo $userid ?>" />
								 <input type="submit" value="Create Order"  />
								 
								 </form>
								 <?php }} else 
								 echo '<th class="fifteen" valign="middle">Delinquent Customer</th>';
								 ?>
<!--<form method="post" action="<?php echo $current_file; ?>" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
<input type="hidden" name="reset" value="checked">
 <input name="Submit" type="submit" value="Send Email"  />
</form>-->
</td>
</td></tr>
    </table>
</div>

								     <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
							
								<div id="content">
								
<div class="my_box7 pad-left" >
	<?php
	}
	else if ((isset($_GET['key1'])) && ($errors != 1)){
	

	                            ?>
								<div class="my_box6 " >
								<table class="widefat1 post fixed">
                            <thead class="widefat1"> <tr><form method="post" action="<?php bloginfo('siteurl'); ?>/my-account/outstanding-payments/?key1=1" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
<!--<input type="hidden" name="redirect" value="http://www.myscannerrental.com/thanks-from-rentscan.html">
<input type="hidden" name="errorredirect" value="http://www.myscannerrental.com/resubmit-rentscan-quote-request.html">-->


      <td class="pad-left" valign="top" align="left" colspan="2">

	          <?php _e('To search an existing Customer enter the Company Name:',$current_theme_locale_name) ?>
</td>
<tr>
	<td class="pad-left">  
       	<input type="text" name="company1" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo htmlspecialchars($qcomp) ?>">
	</td>
	<td><input name="Submit" type="submit" value="Search">
	</td>
</tr>

	<input type="hidden" size="4" class="do_input" name="thekey" value="<?php echo $key ?>" />
	<input type="hidden" size="4" class="do_input" name="update" value="1" />


<tr>	
	<td class="pad-left" colspan="2"><input type="submit" name="newCustomer" value="Create New Customer">
	</td>
</tr>
<tr>	
	<td class="pad-left" colspan="2">
	</td>
</tr>
</form>

<?php
	
?>	
<div id="fragment-3">


       
          <?php

                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   $reseller = $current_user->USER_TYPE;
                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                                   $total_count = 0;
								   
								   if ($reseller == 2){
								   $customeronly = "quoteheader.RESELLER_ID = '$uid' AND quoteheader.CUSTOMER_ID = users.ID AND ";
								   }
                                   $page = $_GET['pj3'];
                                   if(empty($page)) $page = 1;
                                   
                                   //---------------------------------
                                   
                                if ($qcomp == NULL){
								$qcomp = 'blank';
								}   
                                  $qcomp = esc_sql($qcomp); 
                            global $wpdb;       
                            $querystr2 = "SELECT DISTINCT(usermeta.meta_value), users.PO_APPROVED, users.USER_TYPE, users.user_email, usermeta.user_id FROM wp_users users, wp_usermeta usermeta
                                WHERE $customeronly (usermeta.meta_value LIKE '%$qcomp%') AND usermeta.meta_key = 'company' AND users.ID = usermeta.user_id AND users.USER_TYPE <> 5";
								
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count=$total_count+1;
                                   }
                            $my_page = $page;    
                            $pages_curent = $page;

                     //-----------------------------------------------------------------------           
                            
                            $totalPages = ($total_count > 0 ? ceil($total_count / $nrpostsPage) : 0);
                            $pagess = $totalPages;
                     
                                   
                                                        $querystr =   "SELECT DISTINCT(usermeta.meta_value), users.PO_APPROVED, users.USER_TYPE, users.user_email, usermeta.user_id FROM wp_users users, wp_usermeta usermeta
                                WHERE $customeronly (usermeta.meta_value LIKE '%$qcomp%') AND usermeta.meta_key = 'company' AND users.ID = usermeta.user_id AND users.USER_TYPE <> 5 $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
                            
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;

                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat3 post fixed">
                                   <thead class="widefat1"> <tr>
                                   <th>Company</th>
								   <th>Email</th>
                                   <th>Type</th>
                                   <th>Approved for PO</th>
								   <th>Create Order</th>


                                   
                            </tr>
                            </thead> <tbody>
                     
                     
                                    <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                                   unset($company, $last_name);
              $oid = $post->id;                        

                                                                                 
                                                               
															
                                                                $key3 = $post->meta_value;	
																$key1 = $post->user_id;	
																$users = $post->user_email;
																$typer = $post->USER_TYPE;
																$po = $post->PO_APPROVED;
																 
						if ($typer == 3)
						$typer = 'Sales Rep';
						else if ($typer == 2)
						$typer = 'Reseller';
						else if ($typer < 2)
						$typer = 'Customer';
						else
						$typer = 'Admin';
                        if ($po == 1){
						$po = 'Approved';
						}else {
						$po = 'Not Applicable';
						}
                                   ?>
                     
                    <tr>
                      <th class="ten"><a href="<?php echo $current_file; ?>?key1=1&thekey=<?php echo $users ?>"><?php echo $key3 ?></a></th>
					  <th class="ten"><?php echo $users ?></th>
					  <th class="ten"><?php echo $typer ?></th>
                  
                                   <th class="fifteen"><?php echo $po; ?></th>

					<?php 
					
					
																	$query_result = $DBH->prepare("SELECT wp_users.DISCREPANT_FLAG FROM wp_users WHERE wp_users.user_email = '$users'");
                                               $query_result->execute($parms9);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
																$blackListed = $row2['DISCREPANT_FLAG'];
																}
			
					if($blackListed != 1) {?>
					 <form action="<?php echo $current_file ?>">
									<th class="ten" valign="middle"><input type="hidden" size="4" class="do_input" name="thekey1" value="<?php echo $key1 ?>" />
								 <input type="submit" value="Create Order"  />
								 </th>
								 </form>
								 <?php } else 
								 echo '<th class="fifteen" valign="middle">Delinquent Customer</th>';
								 ?>
								 
								 
</form>                          </tr>
                            
                   
                               
                               <?php endforeach; ?>
                    </tbody> 
                    </table> 
                     
                     
                     <div class="nav">
                     <?php
                                         
              $batch = 1000000000; //ceil($page / $nrpostsPage );
              $end = $batch * $nrpostsPage;


              if ($end > $pagess) {
                     $end = $pagess;
              }
              $start = $end - $nrpostsPage + 1;
              
              if($start < 1) $start = 1;
              
              $links = '';
       
              
              $raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
              
              $start               = $raport * $batch + 1; 
              $end          = $start + $batch - 1;
              $end_me       = $end + 1;
              $start_me     = $start - 1;
              
              if($end > $totalPages) $end = $totalPages;
              if($end_me > $totalPages) $end_me = $totalPages;
              
              if($start_me <= 0) $start_me = 1;
              
              $previous_pg = $page - 1;
              if($previous_pg <= 0) $previous_pg = 1;
              
              $next_pg = $pages_curent + 1;
              if($next_pg > $totalPages) $next_pg = 1;
              if($next_pg > $totalPages) $next_pg = 1;
              if($next_pg > $totalPages) $next_pg = 1;
              if($next_pg > $totalPages) $next_pg = 1;
              
              
              
              //PricerrTheme_get_browse_jobs_link($job_tax, $job_category, 'new', $page)
              
                            if($my_page > 1)
              {      
                     echo '<a href="'.network_site_url('my-account/outstanding-payments/?key1=1&').'pj3=' .$start_me.'&des='.$desc.'&q='.$qcomp.'"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/outstanding-payments/?key1=1&').'pj3='.$previous_pg.'&des='.$desc.'&q='.$qcomp.'"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/outstanding-payments/?key1=1&').'pj3=' . $i.'&q='.$qcomp.'">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/outstanding-payments/?key1=1&').'pj3=' . $next_pg.'&des='.$desc.'&q='.$qcomp.'"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/outstanding-payments/?key1=1&').'pj3=' . $end_me.'&des='.$desc.'&q='.$qcomp.'">>></a>';
                                                 ?>
                     </div>
                     
                     </div></div><div>
                     
                     
                     <?php else: ?>
        <!-- <div id="tabs" class="ui-widget1"> -->
  <div id="fragment-4">

                     
                             </thead></table></div></div></div>
         

                            
						<?php echo Walleto_get_users_links(); 
						die;?>
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   
                                   ?>
                
        

         

                            
						<?php echo Walleto_get_users_links(); ?>
                            <thead class="widefat1"> <tr><form method="post" action="<?php echo $current_file; ?>" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
<!--<input type="hidden" name="redirect" value="http://www.myscannerrental.com/thanks-from-rentscan.html">
<input type="hidden" name="errorredirect" value="http://www.myscannerrental.com/resubmit-rentscan-quote-request.html">-->

<div id="SignUp">
<table width="900" class="signupframe1" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<input type="hidden" name="action" value="register" />
     
    </tr>
</div></div></div></div>

								  <?php 
	}else if ($errors != 1){
	global $current_user;
	get_currentuserinfo();
	$desc = $_GET['des'] ;
	if (isset($_GET['count']))
	$total_count1 = $_GET['count'] ;
	if (!isset($desc)){
       $desc = 'DESC';
       }
       if ($desc == NULL){
       $asc = 'DESC';
       }
	$uid = $current_user->ID;
if (isset($_GET['datef']) && $check != 1){	
	$datefrom = $_GET['datef'];
	$dateto = $_GET['datet'];
	$reports = trim($_GET['reports']);
	} else {
	$datefrom = trim($_POST['from']);
	$dateto = trim($_POST['to']);
	$reports = trim($_GET['reports']);
	}
if (isset($_GET['ddate']) && $check != 1){	
	$ddate = $_GET['ddate'];
	$reports = trim($_GET['reports']);
	} else {
	$ddate = trim($_POST['ddate']);
	$reports = trim($_GET['reports']);
	}
	if ($reports == 'Overdue by Date'){
	if ($ddate != NULL)
	$ddate = date("Y-m-d 00:00:00", strtotime($ddate));
	else
	$ddate = date("Y-m-d 00:00:00");
    global $wpdb;       
	                            global $wpdb;  
							
                            $querystr2 = "SELECT (DATEDIFF(DATE_FORMAT(orderlines.RETURN_DATE, '%Y-%m-%d'), 
												DATE_FORMAT(now(),'%Y-%m-%d'))) AS REMAINING_DAYS, orderlines.DELIVERED_DATE, (orderlines.RETURN_DATE) AS RETURN_DATE, 
												orders.CURRENT_ORDER_ID, orders.COMPANY, orders.TOTAL_AMOUNT, orders.ORDER_ID, orders.PROCESS_STATUS, quote.QUOTE_ID, 
												orders.SALESPERSON_ID, orders.ORACLE_RMA_NUMBER, orders.SALESPERSON_NAME
											FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  
												".$wpdb->prefix."users users,  wp_walleto_order_lines orderlines
                                            WHERE orders.ORDER_ID = orderlines.ORDER_ID 
											AND users.ID = orders.CUSTOMER_ID 
											AND usermeta.user_id = orders.CUSTOMER_ID 
											AND usermeta.meta_key = 'first_name' 
											AND quote.QUOTE_ID = orders.QUOTE_ID 
											AND orders.PAID='1' AND orders.STATUS = 'PAID' 
											AND '$ddate' >= orderlines.RETURN_DATE
											AND orderlines.SHIPPED_DATE <= '$ddate' 
											AND (orders.PROCESS_STATUS = 'WAITING_FOR_RETURN')  
                                            GROUP BY orders.ORDER_ID
											ORDER BY REMAINING_DAYS";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count1=$total_count1+1;
                                   }
	}

	if ($reports == 'Chat'){
	if ($datefrom != NULL)
	$datefrom = date("Y-m-d 00:00:00", strtotime($datefrom));
	else
	$datefrom = date("Y-m-d 00:00:00");
	if ($dateto != NULL)
	$dateto = date("Y-m-d 23:59:59", strtotime($dateto));
	else 
	$dateto = date("Y-m-d 23:59:59");
    global $wpdb;       
	                            global $wpdb;  
							
                            $querystr2 = "SELECT CASE WHEN PHONE_EXTENSION IS NULL 
											THEN (
											CONCAT( (
											IFNULL( PHONE_NUMBER, '' ) ) , ' ', (
											IFNULL( PHONE_EXTENSION, '' ) 
											)))
											ELSE
											(CONCAT( (
											IFNULL( PHONE_NUMBER, '' ) ) , ' x', (
											IFNULL( PHONE_EXTENSION, '' ) 
											))) END AS 'PHONE', TRANSACTION_ID, TRANSACTION_DATE, COMPANY_NAME, FIRST_NAME, LAST_NAME,
											EMAIL_ADDRESS, UNAVAILABLE_MESSAGE, INQUIRING_ABOUT
											FROM wpf_chat_details 
											WHERE '$datefrom' <= TRANSACTION_DATE AND '$dateto' >= TRANSACTION_DATE ORDER BY TRANSACTION_ID ";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count1=$total_count1+1;
                                   }
	}
	
	if ($reports == 'Request for Quotes'){
	if ($datefrom != NULL)
	$datefrom = date("Y-m-d 00:00:00", strtotime($datefrom));
	else
	$datefrom = date("Y-m-d 00:00:00");
	if ($dateto != NULL)
	$dateto = date("Y-m-d 23:59:59", strtotime($dateto));
	else 
	$dateto = date("Y-m-d 23:59:59");
	                            global $wpdb;       
                            $querystr2 = "select quote.LOCATION, quote.FIRST_NAME, quote.LAST_NAME, quote.USER_EMAIL, quote.USER_PHONE, quote.COMPANY, quote.INDUSTRY, quote.CREATION_DATE, quote.RENTAL_DURATION from request_a_quote quote WHERE '$datefrom' <= quote.CREATION_DATE AND '$dateto' >= quote.CREATION_DATE";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count1=$total_count1+1;
                                   }
	
	

								   } 

	if ($reports == 'Transactions'){
	if ($datefrom != NULL)
	$datefrom = date("Y-m-d 00:00:00", strtotime($datefrom));
	else
	$datefrom = date("Y-m-d 00:00:00");
	if ($dateto != NULL)
	$dateto = date("Y-m-d 23:59:59", strtotime($dateto));
	else 
	$dateto = date("Y-m-d 23:59:59");
	                            global $wpdb;   
                                   $dateType = $_POST['dateType'];
								   $modelType = $_POST['modelType'];
								   $buyerName = $_POST['buyerName'];
								   $companySearch = $_POST['companySearch'];
								   $resellerID = $_POST['resellerName'];
								  $salesID = $_POST['salesName'];
								   if ($dateType == NULL){
								   $dateType = 'CREATION_DATE';
								   }
								   if ($modelType == NULL){
								   $modelType = '%';
								   }
								   if ($resellerID == NULL){
								   $resellerID = '%';
								   }
								   if ($salesID == NULL){
								   $salesID = '%';
								   }
								   $buyerName = ltrim($buyerName);
									$buyerName = explode(' ', $buyerName);
									$buyerName = preg_replace('/\s+/', '', $buyerName[0]);	
									
									$companySearch = ltrim($companySearch);
									$companySearch = explode(' ', $companySearch);
									$companySearch = preg_replace('/\s+/', '', $companySearch[0]);								
                             $querystr2 =   "SELECT DISTINCT(ordlines.ORDER_LINE_ID),ordheader.QUOTE_ID, ordheader.ORDER_ID, ordheader.TRANSACTION_DATE, ordlines.RETURN_DATE, 
										ordlines.MODEL_NUMBER, ordlines.QUANTITY, ordlines.CREATION_DATE, ordlines.DURATION, 
										ordlines.PRODUCT_AMOUNT, ordlines.FREIGHT_AMOUNT, ordlines.TAX_AMOUNT, ordlines.TOTAL_LINE_AMOUNT, 
										ordlines.DISCOUNT_AMOUNT, ordlines.SHIP_TYPE, ordheader.SHIP_TO_STATE, ordlines.ORACLE_ORDER_LINE_ID,
										umeta.meta_value
										FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines, wp_usermeta umeta, wp_users users
										WHERE ordheader.ORDER_ID = ordlines.ORDER_ID
										AND ordheader.CUSTOMER_ID = umeta.user_id
										
										AND ordheader.RESELLER_ID LIKE '$resellerID'
										AND umeta.meta_key = 'industry'
										AND ordheader.SALESPERSON_ID LIKE '$salesID'
										AND ((ordheader.FIRST_NAME LIKE '%$buyerName%') OR (ordheader.LAST_NAME LIKE '%$buyerName%'))
										AND ordheader.COMPANY LIKE '%$companySearch%'
										AND ordlines.POST_ID LIKE '$modelType'
										AND '$datefrom' <= ordlines.$dateType 
										AND '$dateto' >= ordlines.$dateType ORDER BY ordlines.$dateType" ; 
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count1=$total_count1+1;
                                   }
	
	

								   } 
?>	
                     <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
          
                <html xmlns="http://www.w3.org/1999/xhtml">
                        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <script type="text/javascript" src="../../wp-content/themes/Walleto/fancybox/fancybox/jquery.fancybox.pack.js"></script>
<head>
<link rel="stylesheet" href="../../wp-content/themes/Walleto/fancybox/fancybox/jquery.fancybox.css" type="text/css"  />
       <title>An XHTML 1.0 Strict standard template</title>
       <meta http-equiv="content-type" 
              content="text/html;charset=utf-8" />
<div id="main_section">
			<div class="my_box6">
            
<!doctype html>
<html>
<head>
    <title>jQuery UI Date Picker</title>
 
    <script type="text/javascript" src="../../wp-content/themes/Walleto/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../../wp-content/themes/Walleto/js/jquery-ui.js"></script>
	
  <script>
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
   //   onClose: function( selectedDate ) {
    //    $( "#to" ).datepicker( "option", "minDate", selectedDate );
    //  }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
     // onClose: function( selectedDate ) {
     //   $( "#from" ).datepicker( "option", "maxDate", selectedDate );
    //  }
    });
	    $( "#ddate" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
      }
    });
  });
  </script>
</head>
<body>
             	<div class="box_title my_account_title"><?php _e("Reports",'Walleto'); ?></div>
                <div class="box_content10">   
				<div class="form">
				 <form class = "block" method="post"  name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
	       Report Type: <select id="select-language" title="reports" onchange="window.location.href=this.value">
          <option value='?' >Select</option>
          <option value="?reports=Request for Quotes"<?php if(isset($reports) && $reports == 'Request for Quotes') 
          echo ' selected="selected"';
    ?>>Request for Quotes</option>
	      <option value="?reports=Overdue by Date"<?php if(isset($reports) && $reports == 'Overdue by Date') 
          echo ' selected="selected"';
    ?>>Overdue by Date</option>
<!--	<option value="?reports=Chat"<?php if(isset($reports) && $reports == 'Chat') 
          echo ' selected="selected"';
    ?>>Chat</option> -->
	<option value="?reports=Transactions"<?php if(isset($reports) && $reports == 'Transactions') 
          echo ' selected="selected"';
    ?>>Transactions</option>
	</select>
	<?php if ($reports == 'Overdue by Date'){ ?>
<label for="ddate">Date: </label>
<input type="text" id="ddate" name="ddate" value="<?php $dateddatedisp = date("m-d-Y", strtotime($ddate));
                                          $dateddatedisp = str_replace('-', '/', $dateddatedisp); echo ' '.$dateddatedisp;?>">
	
	<?php } ?> 
	<?php if ($reports == 'Chat'){ ?>
<label for="from">From Date: </label>
<input type="text" id="from" name="from" value="<?php $datefromdisp = date("m-d-Y", strtotime($datefrom));
                                          $datefromdisp = str_replace('-', '/', $datefromdisp); echo ' '.$datefromdisp;?>">
<label for="to">To Date: </label>
<input type="text" id="to" name="to" value="<?php $datetodisp = date("m-d-Y", strtotime($dateto));
                                          $datetodisp = str_replace('-', '/', $datetodisp); echo ' '.$datetodisp;?>">
										  <?php $check = 1;
										  } ?>
	<?php if ($reports == 'Request for Quotes'){ ?>
<label for="from">From Date: </label>
<input type="text" id="from" name="from" value="<?php $datefromdisp = date("m-d-Y", strtotime($datefrom));
                                          $datefromdisp = str_replace('-', '/', $datefromdisp); echo ' '.$datefromdisp;?>">
<label for="to">To Date: </label>
<input type="text" id="to" name="to" value="<?php $datetodisp = date("m-d-Y", strtotime($dateto));
                                          $datetodisp = str_replace('-', '/', $datetodisp); echo ' '.$datetodisp;?>">
										  <?php $check = 1;
										  } ?>

<?php if ($reports == 'Transactions'){ ?>

<br/>Date Type:&nbsp;&nbsp;&nbsp;&nbsp;<select name="dateType">
<option value="CREATION_DATE" <?php if($_POST['dateType'] == 'CREATION_DATE') echo 'selected=selected'; ?>>Order Date</option>
<option value="SHIPPED_DATE" <?php if($_POST['dateType'] == 'SHIPPED_DATE') echo 'selected=selected'; ?>>Shipped Date</option>
<option value="DELIVERED_DATE" <?php if($_POST['dateType'] == 'DELIVERED_DATE') echo 'selected=selected'; ?>>Delivered Date</option>
<option value="RETURN_DATE" <?php if($_POST['dateType'] == 'RETURN_DATE') echo 'selected=selected'; ?>>Return Date</option>
</select>

<label for="from">From Date: </label>
<input type="text" id="from" name="from" value="<?php $datefromdisp = date("m-d-Y", strtotime($datefrom));
                                          $datefromdisp = str_replace('-', '/', $datefromdisp); echo ' '.$datefromdisp;?>">
<label for="to">To Date: </label>
<input type="text" id="to" name="to" value="<?php $datetodisp = date("m-d-Y", strtotime($dateto));
                                          $datetodisp = str_replace('-', '/', $datetodisp); echo ' '.$datetodisp;?>">


<?php 

					global $wp_query;
					$query_vars = $wp_query->query_vars;
					$post_per_page = 100;				
					query_posts( "post_status=draft,publish&meta_key=".$key."&post_type=product&order=".$desc."&orderby=".$val."&posts_per_page=" . $post_per_page . "&paged=" . $query_vars['paged'] );
	
					if(have_posts()) :


                                
                                                                
										
			
?>
<br/>Model Type:&nbsp;&nbsp;<select name="modelType">
<option value="%">All</option>
<?php 
					while ( have_posts() ) { the_post();

	$pid = get_the_ID();
	$videolink = get_post_meta(get_the_ID(), 'videolink', true);
	$status = get_post_meta($pid,'status',true);
	global $post;
	$uom=get_post_meta(get_the_ID(),'uom',true);
	
	$st = $post->post_status;
				$name = $post->post_title;

			
			 $query_result = $DBH->prepare("SELECT pmeta.post_id
											FROM wp_terms term, wp_postmeta pmeta, wp_term_taxonomy pterm
											WHERE pmeta.meta_key = 'uom'
											AND pmeta.meta_value = term.slug
											AND term.slug = '$uom'
											AND pterm.term_id = term.term_id
											");

							
							$query_result->execute($parms);      
                                $data = $query_result->fetchAll();
          
foreach($data as $row){
    $tID= $row['post_id'];
if (($pid == $tID)){ ?>
<option value="<?php echo $pid ?>" <?php if($_POST['modelType'] == $pid) echo 'selected=selected' ?>><?php the_title(); ?></option>

<?php } } }?>
</select><br/>
Contact:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp; <input type="text" name="buyerName" value="<?php echo $_POST['buyerName']?>"><br/>
Company:&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="companySearch" value="<?php echo $_POST['companySearch']?>"><br/>
Salesperson:
<select name="salesName">
<option value="%">All</option>
<option value="0" <?php if($_POST['salesName'] == '0') echo 'selected=selected' ?>>No Sales Credit</option>
<?php
			 $query_result = $DBH->prepare("SELECT display_name, ID
											FROM wp_users
											WHERE USER_TYPE = 3
											");

							
							$query_result->execute($parms);      
                                $data = $query_result->fetchAll();
          
foreach($data as $row){
 $sales = $row['display_name'];
 $salesID = $row['ID'];

 ?>
<option value="<?php echo $salesID ?>" <?php if($_POST['salesName'] == $salesID) echo 'selected=selected' ?>><?php echo $sales ?></option>

<?php  }
?>
</select><br/>
Reseller:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<select name="resellerName">
<option value="%">All</option>

<?php
			 $query_result = $DBH->prepare("SELECT display_name, ID
											FROM wp_users
											WHERE USER_TYPE = 2
											");

							
							$query_result->execute($parms);      
                                $data = $query_result->fetchAll();
          
foreach($data as $row){
 $reseller = $row['display_name'];
 $resellerID = $row['ID'];

 ?>
<option value="<?php echo $resellerID ?>" <?php if($_POST['resellerName'] == $resellerID) echo 'selected=selected' ?>><?php echo $reseller ?></option>

<?php  }
?>
</select>

										  <?php 
										  					
	
					if(function_exists('wp_pagenavi')):
					wp_pagenavi(); endif;
					
					else:
					
					_e("There are no active products yet.",'Walleto');
					
					endif;
					
					wp_reset_query();
										  $check = 2;
										  } ?>
										 
	 <input name="Submit" type="submit" value="Submit"/>
	 </form>
	 <?php if ($reports != NULL && $reports != 'Select' && $total_count1 != 0){
	 // for live site, change to ../../../../excelexport/requestedQuotesExcel.php/...
	 ?>
	 <form method="post" action ="<?php echo '../../wp-content/excelexport/requestedQuotesExcel.php/?report='.$reports.'&from='.$datefrom.'&to='.$dateto.'&ddate='.$ddate.'&des='.$desc.'&datetype='.$_POST['dateType'].'&model='.$_POST['modelType'].'&cust='.$_POST['buyerName'].'&companySearch='.$_POST['companySearch'].'&sales='.$_POST['salesName'].'&resell='.$_POST['resellerName'] ?>" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
	 <input name="Submit" type="submit" value="Excel"/>

  </form>  
<?php } ?>  
</div>  
</body>
</html>

                     <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
          
                <html xmlns="http://www.w3.org/1999/xhtml">
                        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <script type="text/javascript" src="../../wp-content/themes/Walleto/fancybox/fancybox/jquery.fancybox.pack.js"></script>
<head>
<link rel="stylesheet" href="../../wp-content/themes/Walleto/fancybox/fancybox/jquery.fancybox.css" type="text/css"  />
       <title>An XHTML 1.0 Strict standard template</title>
       <meta http-equiv="content-type" 
              content="text/html;charset=utf-8" />
			  <?php
if ($frag != NULL){
?>
<script>
var v = '<?php echo $frag; ?>'
window.location.href = "#"+v;
</script> 
<?php
}
?>
<body>

       

    </head>
       </body>
</html>
<SCRIPT LANGUAGE="JavaScript">

// answer to http://stackoverflow.com/q/14819642/1055987 - JFK
$(document).ready(function () {
    /* fancybox handler */
    $('.fancybox-media').fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        autoSize: true,
        type: 'iframe',
        iframe: {
            preload: false // fixes issue with iframe and IE
        }
    });
});

</script>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>tabs demo</title>

  <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
	<?php if ($reports == 'Request for Quotes'){ ?>
 <!-- <div id="tabs" class="ui-widget1"> -->
  <div id="fragment-4">

          <?php
		  if ($reports == 'Select' || $reports == ''){
		  echo 'Please choose a report.';
		  }
		  if ($reports == 'Request for Quotes'){

                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   
                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                                   $total_count = 0;
                                   $page = $_GET['pj4'];
                                   if(empty($page)) $page = 1;
                                   
                                   //---------------------------------

                                   
                            global $wpdb;       
                            $querystr2 = "select quote.LOCATION, quote.FIRST_NAME, quote.LAST_NAME, quote.USER_EMAIL, quote.USER_PHONE, quote.COMPANY, quote.INDUSTRY, quote.CREATION_DATE, quote.RENTAL_DURATION from request_a_quote quote WHERE '$datefrom' <= quote.CREATION_DATE AND '$dateto' >= quote.CREATION_DATE ";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count=$total_count+1;
                                   }
                            $my_page = $page;    
                            $pages_curent = $page;
                     //-----------------------------------------------------------------------           
                            
                            $totalPages = ($total_count > 0 ? ceil($total_count / $nrpostsPage) : 0);
                            $pagess = $totalPages;
                                   
                                                        $querystr =   "select quote.LOCATION, quote.FIRST_NAME, quote.LAST_NAME, quote.USER_EMAIL, quote.USER_PHONE, quote.COMPANY, quote.INDUSTRY, quote.CREATION_DATE, quote.RENTAL_DURATION from request_a_quote quote WHERE '$datefrom' <= quote.CREATION_DATE AND '$dateto' >= quote.CREATION_DATE ORDER BY CREATION_DATE $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
                            
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;
                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed1">
                                   <thead class="widefat1"> <tr>
                                
                    <th><a class="white" href="<?php echo network_site_url('my-account/outstanding-payments?des='.$asc.'&datef='.$datefrom.'&datet='.$dateto.'&reports='.$reports.'&count=1')  ?>">Creation Date</a></th>
                                   <th>First Name</th>
                                   <th>Last Name</th>
                                   <th>E-mail</th>
                                   <th>Phone</th>
                    <th>Company</th>
                                   <th>Industry</th>
								   <th>Location</th>
                    <th>Rental Duration</th>


                                   
                            </tr>
                            </thead> <tbody>

                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                            
                                   $oid = $post->id;                         
 
                        
                             
                                          $doclink             = $post->PDF_FILE_NAME;
                                         $buyer                      = get_userdata($post->uid);
                                         $totalprice   = ($post->totalprice);
                                          $rma                 = $post->ORACLE_ORDER_NUMBER;
                                          $datemade = date("m-d-Y", strtotime($post->CREATION_DATE));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quote_number = $post->QUOTE_NUMBER;
                                          $salesperson  = $post->SALESPERSON_NAME;

                                          $contact             = $post->meta_value.' '.$last_name;
                                          if($post->RETURN_DATE!=0 && $post->RETURN_DATE!=NULL){
                                          $returnDate = date("m-d-Y", strtotime($post->RETURN_DATE));
                                          $returnDate = str_replace('-', '/', $returnDate);
                                          $today = strtotime(date('Y-m-d H:i:s'));
                                          $expireDay = strtotime($post->RETURN_DATE);
                                          $timeToEnd = ($expireDay - $today)/86400;
                                          $timeToEnd = intval($timeToEnd);
                                          if($timeToEnd <= 0)
                                          $timeToEnd = '';
                                          }
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_SHIPMENT')
                                                 $status = 'Waiting for Shipment';
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_RETURN')
                                                 $status = 'Shipped';
						if($post->STATUS == 'CANCELLED')
                                                 $status = 'Canceled';
						if($post->PROCESS_STATUS == 'RENEWED')
                                                 $status = 'Renewed';
						if($post->PROCESS_STATUS == 'WAITING_FOR_RENEWAL')
                                                 $status = 'Waiting for renewal';
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
                                          if($post->RECEIVED_DATE!=0 && $post->RECEIVED_DATE!=NULL){
                                          $receiveDate = date("m-d-Y", strtotime($post->RECEIVED_DATE));
                                          $receiveDate = str_replace('-', '/', $receiveDate);
                                          } 
                                                                                    
                                    ?>
                     
                    <tr>
                     <th class="five"><?php echo $datemade; ?></a></th>
                    <th class="ten"><?php echo $post->FIRST_NAME; ?></th>
                                   <th class="ten"><?php echo $post->LAST_NAME; ?></th>
                    <th class="fifteen"><?php echo $post->USER_EMAIL; ?></th>
                                   <th class="fifteen"><?php echo $post->USER_PHONE; ?></th>
                                   <th class="fifteen"><?php echo $post->COMPANY; ?></th>
                    <th class="fifteen"><?php echo $post->INDUSTRY; ?></th>
					<th class="fifteen"><?php echo $post->LOCATION; ?></th>
					<th class="fifteen"><?php echo $post->RENTAL_DURATION; ?></th>




                            </tr>
                            
                   
                               
                               <?php endforeach; ?>
                    </tbody> 
                    </table> 
                     
                     
                     <div class="nav">
                     <?php
                                         
              $batch = 1000000000; //ceil($page / $nrpostsPage );
              $end = $batch * $nrpostsPage;


              if ($end > $pagess) {
                     $end = $pagess;
              }
              $start = $end - $nrpostsPage + 1;
              
              if($start < 1) $start = 1;
              
              $links = '';
       
              
              $raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
              
              $start               = $raport * $batch + 1; 
              $end          = $start + $batch - 1;
              $end_me       = $end + 1;
              $start_me     = $start - 1;
              
              if($end > $totalPages) $end = $totalPages;
              if($end_me > $totalPages) $end_me = $totalPages;
              
              if($start_me <= 0) $start_me = 1;
              
              $previous_pg = $page - 1;
              if($previous_pg <= 0) $previous_pg = 1;
              
              $next_pg = $pages_curent + 1;
              if($next_pg > $totalPages) $next_pg = 1;
              
              
              
              //PricerrTheme_get_browse_jobs_link($job_tax, $job_category, 'new', $page)
              
              if($my_page > 1)
              {      
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' .$start_me.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Request for Quotes"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4='.$previous_pg.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Request for Quotes"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $i.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Request for Quotes">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $next_pg.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Request for Quotes"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $end_me.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Request for Quotes">>></a>';
                                                 
                            
                                   ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                  
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   }
                                   ?>
                
        
        
         
         
          </div>
                
       


<script>
$( "#tabs" ).tabs();

</script>

</body>
</html>

      
</div>
<?php }	

 if ($reports == 'Transactions'){ ?>
 <!--<div id="tabs" class="ui-widget1"> -->
  <div id="fragment-4">

          <?php
		  if ($reports == 'Select' || $reports == ''){
		  echo 'Please choose a report.';
		  }
		  if ($reports == 'Transactions'){

                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   $dateType = $_POST['dateType'];
								   $modelType = $_POST['modelType'];
								   $buyerName = $_POST['buyerName'];
								   $companySearch = $_POST['companySearch'];
								   $resellerID = $_POST['resellerName'];
								  $salesID = $_POST['salesName'];
								   if ($dateType == NULL){
								   $dateType = 'CREATION_DATE';
								   }
								   if ($modelType == NULL){
								   $modelType = '%';
								   }
								   if ($resellerID == NULL){
								   $resellerID = '%';
								   }
								   if ($salesID == NULL){
								   $salesID = '%';
								   }
								   $buyerName = ltrim($buyerName);
									$buyerName = explode(' ', $buyerName);
									$buyerName = preg_replace('/\s+/', '', $buyerName[0]);
									
									$companySearch = ltrim($companySearch);
									$companySearch = explode(' ', $companySearch);
									$companySearch = preg_replace('/\s+/', '', $companySearch[0]); //strip whitespace

									


                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                                   $total_count = 0;
                                   $page = $_GET['pj4'];
                                   if(empty($page)) $page = 1;
                                   
                                   //---------------------------------

                                   
                            global $wpdb;       
							$querystr2 = "SELECT DISTINCT(ordlines.ORDER_LINE_ID),ordheader.QUOTE_ID, ordheader.ORDER_ID, ordheader.TRANSACTION_DATE, ordlines.RETURN_DATE, 
										ordlines.MODEL_NUMBER, ordlines.QUANTITY, ordlines.CREATION_DATE, ordlines.DURATION, 
										ordlines.PRODUCT_AMOUNT, ordlines.FREIGHT_AMOUNT, ordlines.TAX_AMOUNT, ordlines.TOTAL_LINE_AMOUNT, 
										ordlines.DISCOUNT_AMOUNT, ordlines.SHIP_TYPE, ordheader.SHIP_TO_STATE, ordlines.ORACLE_ORDER_LINE_ID,
										umeta.meta_value
										FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines, wp_usermeta umeta, wp_users users
										WHERE ordheader.ORDER_ID = ordlines.ORDER_ID
										AND ordheader.CUSTOMER_ID = umeta.user_id
										
										AND ordheader.RESELLER_ID LIKE '$resellerID'
										AND umeta.meta_key = 'industry'
										AND ordheader.SALESPERSON_ID LIKE '$salesID'
										AND ((ordheader.FIRST_NAME LIKE '%$buyerName%') OR (ordheader.LAST_NAME LIKE '%$buyerName%'))
										AND ordheader.COMPANY LIKE '%$companySearch%'
										AND ordlines.POST_ID LIKE '$modelType'
										AND '$datefrom' <= ordlines.$dateType 
										AND '$dateto' >= ordlines.$dateType ORDER BY ordlines.$dateType";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count=$total_count+1;
                                   }
                            $my_page = $page;    
                            $pages_curent = $page;
                     //-----------------------------------------------------------------------           
                            
                            $totalPages = ($total_count > 0 ? ceil($total_count / $nrpostsPage) : 0);
                            $pagess = $totalPages;
                                   
                            $querystr =   "SELECT DISTINCT(ordlines.ORDER_LINE_ID),ordheader.QUOTE_ID, ordheader.ORDER_ID, ordheader.TRANSACTION_DATE, ordlines.RETURN_DATE, 
										ordlines.MODEL_NUMBER, ordlines.QUANTITY, ordlines.CREATION_DATE, ordlines.DURATION, 
										ordlines.PRODUCT_AMOUNT, ordlines.FREIGHT_AMOUNT, ordlines.TAX_AMOUNT, ordlines.TOTAL_LINE_AMOUNT, 
										ordlines.DISCOUNT_AMOUNT, ordlines.SHIP_TYPE, ordheader.SHIP_TO_STATE, ordlines.ORACLE_ORDER_LINE_ID,
										umeta.meta_value
										FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines, wp_usermeta umeta, wp_users users
										WHERE ordheader.ORDER_ID = ordlines.ORDER_ID
										AND ordheader.CUSTOMER_ID = umeta.user_id
										
										AND ordheader.RESELLER_ID LIKE '$resellerID'
										AND umeta.meta_key = 'industry'
										AND ordheader.SALESPERSON_ID LIKE '$salesID'
										AND ((ordheader.FIRST_NAME LIKE '%$buyerName%') OR (ordheader.LAST_NAME LIKE '%$buyerName%'))
										AND ordheader.COMPANY LIKE '%$companySearch%'
										AND ordlines.POST_ID LIKE '$modelType'
										AND '$datefrom' <= ordlines.$dateType
										AND '$dateto' >= ordlines.$dateType ORDER BY ordlines.$dateType $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
                        
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;
                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed1">
                                   <thead class="widefat1"> <tr>
									<th>Order#</th>
									<th>Order Date</th>
                    <th><a class="white" href="<?php echo network_site_url('my-account/outstanding-payments?des='.$asc.'&datef='.$datefrom.'&datet='.$dateto.'&reports='.$reports.'&count=2')  ?>">Paid Date</a></th>
                                   
									<th>Sch. Return Date</th>
									<th>Product</th>
									<th>Discount</th>
									<th>Total</th>
									<th>Ship Type</th>
									<th>Ship State</th>
									<th>Industry</th>
									<th>Renewal</th>


                                   
                            </tr>
                            </thead> <tbody>

                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                            
                                                         
 
                        
                             
                                          $doclink             = $post->PDF_FILE_NAME;
                              
                                          $datemade = date("m-d-Y", strtotime($post->CREATION_DATE));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quotenum = $post->QUOTE_ID;
                                          $salesperson  = $post->SALESPERSON_NAME;

                                        
                                          if($post->RETURN_DATE!=0 && $post->RETURN_DATE!=NULL){
                                          $returnDate = date("m-d-Y", strtotime($post->RETURN_DATE));
                                          $returnDate = str_replace('-', '/', $returnDate);
										 
                                          $today = strtotime(date('Y-m-d H:i:s'));
                                          $expireDay = strtotime($post->RETURN_DATE);
                                          $timeToEnd = ($expireDay - $today)/86400;
                                          $timeToEnd = intval($timeToEnd);
                                          if($timeToEnd <= 0)
                                          $timeToEnd = '';
                                          }else 
										  $returnDate = '';
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_SHIPMENT')
                                                 $status = 'Waiting for Shipment';
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_RETURN')
                                                 $status = 'Shipped';
						if($post->STATUS == 'CANCELLED')
                                                 $status = 'Canceled';
						if($post->PROCESS_STATUS == 'RENEWED')
                                                 $status = 'Renewed';
						if($post->PROCESS_STATUS == 'WAITING_FOR_RENEWAL')
                                                 $status = 'Waiting for renewal';
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
                                          if($post->TRANSACTION_DATE!=0 && $post->TRANSACTION_DATE!=NULL){
                                          $tranDate = date("m-d-Y", strtotime($post->TRANSACTION_DATE));
                                          $tranDate = str_replace('-', '/', $tranDate);
                                          } 
                                       if($post->ORACLE_ORDER_LINE_ID != NULL)
										$renewConfirm = 'YES';
										else{
										$renewConfirm = 'NO';
										}
                                    ?>
                     
                    <tr>
                     <th class = "five"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $post->ORDER_ID; ?></a></th>
                    <th class="ten"><?php echo $datemade; ?></th>
                                   <th class="ten"><?php echo $tranDate; ?></th>
                    <th class="fifteen"><?php echo $returnDate; ?></th>
                                   <th class="fifteen"><?php echo $post->MODEL_NUMBER; ?></th>

					<th class="fifteen"><?php echo $post->DISCOUNT_AMOUNT; ?></th>
					<th class="fifteen"><?php echo $post->TOTAL_LINE_AMOUNT; ?></th>
					<th class="fifteen"><?php echo $post->SHIP_TYPE; ?></th>
					<th class="fifteen"><?php echo $post->SHIP_TO_STATE; ?></th>
					<th class="fifteen"><?php echo $post->meta_value; ?></th>
					<th class="fifteen"><?php echo $renewConfirm; ?></th>




                            </tr>
                            
                   
                               
                               <?php endforeach; ?>
                    </tbody> 
                    </table> 
                     
                     
                     <div class="nav">
                     <?php
                                         
              $batch = 1000000000; //ceil($page / $nrpostsPage );
              $end = $batch * $nrpostsPage;


              if ($end > $pagess) {
                     $end = $pagess;
              }
              $start = $end - $nrpostsPage + 1;
              
              if($start < 1) $start = 1;
              
              $links = '';
       
              
              $raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
              
              $start               = $raport * $batch + 1; 
              $end          = $start + $batch - 1;
              $end_me       = $end + 1;
              $start_me     = $start - 1;
              
              if($end > $totalPages) $end = $totalPages;
              if($end_me > $totalPages) $end_me = $totalPages;
              
              if($start_me <= 0) $start_me = 1;
              
              $previous_pg = $page - 1;
              if($previous_pg <= 0) $previous_pg = 1;
              
              $next_pg = $pages_curent + 1;
              if($next_pg > $totalPages) $next_pg = 1;
              
              
              
              //PricerrTheme_get_browse_jobs_link($job_tax, $job_category, 'new', $page)
              
              if($my_page > 1)
              {      
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' .$start_me.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Transactions"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4='.$previous_pg.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Transactions"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $i.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Transactions">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $next_pg.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Transactions"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $end_me.'&des='.$desc.'&datef='.$datefrom.'&datet='.$dateto.'&reports=Transactions">>></a>';
                                                 
                            
                                   ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
          
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   }
                                   ?>
                
        
        
         
         
          </div>
                
       


<script>
$( "#tabs" ).tabs();

</script>

</body>
</html>

      
</div>
<?php }
 if ($reports == 'Overdue by Date'){
 ?>

<!-- <div id="tabs" class="ui-widget1"> -->
  <div id="fragment-4">

         
       
          <?php
		  if ($reports == 'Select' || $reports == ''){
		  echo 'Please choose a report.';
		  }
		  if ($reports == 'Overdue by Date'){
                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   
                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                                   $total_count = 0;
                                   $page = $_GET['pj4'];
                                   if(empty($page)) $page = 1;
                                   
                                   //---------------------------------
                             /* select *, DATEDIFF(DATE_FORMAT(ord.RETURN_DATE, '%Y-%m-%d'), DATE_FORMAT(now(),'%Y-%m-%d')) AS REMAINING_DAYS 
							 from ".$wpdb->prefix."walleto_orders ord, ".$wpdb->prefix."quote_detail quote 
							 WHERE quote.QUOTE_ID = ord.QUOTE_ID AND '$ddate' >= ord.RETURN_DATE AND
							 ord.PROCESS_STATUS = 'WAITING_FOR_RETURN' AND ord.shipped_on <= '$ddate' AND 
							 (ord.RECEIVED_DATE IS NULL OR ord.RECEIVED_DATE = 0*/     
                                   
                                   
                            global $wpdb;  
							
                            $querystr2 = "SELECT (DATEDIFF(DATE_FORMAT(orderlines.RETURN_DATE, '%Y-%m-%d'), 
												DATE_FORMAT(now(),'%Y-%m-%d'))) AS REMAINING_DAYS, orderlines.DELIVERED_DATE, (orderlines.RETURN_DATE) AS RETURN_DATE, 
												orders.CURRENT_ORDER_ID, orders.COMPANY, orders.TOTAL_AMOUNT, orders.ORDER_ID, orders.PROCESS_STATUS, quote.QUOTE_ID, 
												orders.SALESPERSON_ID, orders.ORACLE_RMA_NUMBER, orders.SALESPERSON_NAME
											FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  
												".$wpdb->prefix."users users,  wp_walleto_order_lines orderlines
                                            WHERE orders.ORDER_ID = orderlines.ORDER_ID 
											AND users.ID = orders.CUSTOMER_ID 
											AND usermeta.user_id = orders.CUSTOMER_ID 
											AND usermeta.meta_key = 'first_name' 
											AND quote.QUOTE_ID = orders.QUOTE_ID 
											AND orders.PAID='1' AND orders.STATUS = 'PAID' 
											AND '$ddate' >= orderlines.RETURN_DATE
											AND orderlines.SHIPPED_DATE <= '$ddate' 
											AND (orders.PROCESS_STATUS = 'WAITING_FOR_RETURN')  
                                            GROUP BY orders.ORDER_ID
											ORDER BY REMAINING_DAYS ";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count=$total_count+1;
                                   }
                            $my_page = $page;    
                            $pages_curent = $page;
                     //-----------------------------------------------------------------------           
                            
                            $totalPages = ($total_count > 0 ? ceil($total_count / $nrpostsPage) : 0);
                            $pagess = $totalPages;
							
                             $querystr =   "SELECT (DATEDIFF(DATE_FORMAT(orderlines.RETURN_DATE, '%Y-%m-%d'), 
												DATE_FORMAT(now(),'%Y-%m-%d'))) AS REMAINING_DAYS, orderlines.DELIVERED_DATE, (orderlines.RETURN_DATE) AS RETURN_DATE, 
												orders.CURRENT_ORDER_ID, orders.COMPANY, orders.TOTAL_AMOUNT, orders.ORDER_ID, orders.PROCESS_STATUS, quote.QUOTE_ID, 
												orders.SALESPERSON_ID, orders.ORACLE_RMA_NUMBER, orders.SALESPERSON_NAME
											FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  
												".$wpdb->prefix."users users,  wp_walleto_order_lines orderlines
                                            WHERE orders.ORDER_ID = orderlines.ORDER_ID 
											AND users.ID = orders.CUSTOMER_ID 
											AND usermeta.user_id = orders.CUSTOMER_ID 
											AND usermeta.meta_key = 'first_name' 
											AND quote.QUOTE_ID = orders.QUOTE_ID 
											AND orders.PAID='1' AND orders.STATUS = 'PAID' 
											AND orderlines.RETURN_DATE <> '0000-00-00 00:00:00'
											AND '$ddate' >= orderlines.RETURN_DATE
											AND orderlines.SHIPPED_DATE <= '$ddate' 
											AND (orders.PROCESS_STATUS = 'WAITING_FOR_RETURN')  
											GROUP BY orders.ORDER_ID
											ORDER BY REMAINING_DAYS $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;     

                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;
                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed1">
                                   <thead class="widefat1"> <tr>
									<th>Order#</th>
                                   <th>RMA#</th>
                                   <th>Quote#</th>
                                   <th>Customer</th>
                                   <th>Salesperson</th>
                    <th>Total Amount</th>
                                   <th>Contact Details</th>
                    <th>Shipment Details</th>
					<th>Scheduled Return Date</th>
					<th><a class="white" href="<?php echo network_site_url('my-account/outstanding-payments?des='.$asc.'&ddate='.$ddate.'&reports='.$reports)  ?>">Days Remaining</a></th>
                                   
                            </tr>
                            </thead> <tbody>

                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); 
					 $oid = $post->id; 
					 ?>
					 
                     <?php
              $s = "select user.meta_value from ".$wpdb->prefix."walleto_orders orders, ".$wpdb->prefix."usermeta user WHERE orders.id = $oid AND user.meta_key = 'company' AND user.user_id = orders.uid";
              $r = $wpdb->get_results($s);       
                            foreach($r as $row1)
                                   {
              $company      = $row1->meta_value;
              }                            
                                                           
 
                        
                             
                                          $doclink             = $post->PDF_FILE_NAME;
                                         $buyer                      = get_userdata($post->uid);
                                         $totalprice   = ($post->totalprice);
                                          $rma                 = $post->ORACLE_RMA_NUMBER;
                                          $datemade = date("m-d-Y", strtotime($post->datemade));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quotenum = $post->QUOTE_ID;
                                          $salesperson  = $post->SALESPERSON_NAME;

                                          $contact             = $post->meta_value.' '.$last_name;
                                          if($post->RETURN_DATE!=0 && $post->RETURN_DATE!=NULL){
                                          $returnDate = date("m-d-Y", strtotime($post->RETURN_DATE));
                                          $returnDate = str_replace('-', '/', $returnDate);
                                          $today = strtotime(date('Y-m-d'));

                                          $expireDay = strtotime($post->RETURN_DATE);
                                          $timeToEnd = $post->REMAINING_DAYS;
                                          $timeToEnd = intval($timeToEnd);
											if($timeToEnd <= 0 && $post->PROCESS_STATUS != 'RETURNED'){
											$timeToEnd = abs($timeToEnd). ' days overdue';
                                          }
                                          }
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_SHIPMENT')
                                                 $status = 'Waiting for Shipment';
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_RETURN')
                                                 $status = 'Shipped';
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
                                          if($post->RECEIVED_DATE!=0 && $post->RECEIVED_DATE!=NULL){
                                          $receiveDate = date("m-d-Y", strtotime($post->RECEIVED_DATE));
                                          $receiveDate = str_replace('-', '/', $receiveDate);
                                          } 
                                                                                  
                                    ?>
                     
                    <tr>
					
                    <th class = "five"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $post->ORDER_ID; ?></a></th>
                    <th class="ten"><?php echo $rma; ?></th>
                    <th class="ten"><?php echo $quote_number; ?></th>
                                   <th class="fifteen"><?php echo $post->COMPANY; ?></th>
                                   <th class="fifteen"><?php echo $salesperson; ?></th>
                    <th class="fifteen"><?php echo $ttl; ?></th>
                                   <th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>contact=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   
                                   <th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>orders=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   <th class="ten"><?php echo $returnDate ?></th>
                    <th><?php echo $timeToEnd; ?></th>
                            </tr>
                            
                   
                               
                               <?php endforeach; ?>
                    </tbody> 
                    </table> 
                     
                     
                     <div class="nav">
                     <?php
                                         
              $batch = 1000000000; //ceil($page / $nrpostsPage );
              $end = $batch * $nrpostsPage;


              if ($end > $pagess) {
                     $end = $pagess;
              }
              $start = $end - $nrpostsPage + 1;
              
              if($start < 1) $start = 1;
              
              $links = '';
       
              
              $raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
              
              $start               = $raport * $batch + 1; 
              $end          = $start + $batch - 1;
              $end_me       = $end + 1;
              $start_me     = $start - 1;
              
              if($end > $totalPages) $end = $totalPages;
              if($end_me > $totalPages) $end_me = $totalPages;
              
              if($start_me <= 0) $start_me = 1;
              
              $previous_pg = $page - 1;
              if($previous_pg <= 0) $previous_pg = 1;
              
              $next_pg = $pages_curent + 1;
              if($next_pg > $totalPages) $next_pg = 1;
              
              
              
              //PricerrTheme_get_browse_jobs_link($job_tax, $job_category, 'new', $page)
              
              if($my_page > 1)
              {      
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' .$start_me.'&des='.$desc.'&ddate='.$ddate.'&reports=Overdue by Date"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4='.$previous_pg.'&des='.$desc.'&ddate='.$ddate.'&reports=Overdue by Date"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $i.'&des='.$desc.'&ddate='.$ddate.'&reports=Overdue by Date">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $next_pg.'&des='.$desc.'&ddate='.$ddate.'&reports=Overdue by Date"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $end_me.'&des='.$desc.'&ddate='.$ddate.'&reports=Overdue by Date">>></a>';
                                                 
                            
                                   ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
                    
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   }
                                   ?>
                
        
        
         
         
          </div>
                
       


<script>
$( "#tabs" ).tabs();

</script>

</body>
</html>

      
</div>
<?php } 

 if ($reports == 'Chat'){
 ?>

<!-- <div id="tabs" class="ui-widget1"> -->
  <div id="fragment-4">

         
       
          <?php
		  if ($reports == 'Select' || $reports == ''){
		  echo 'Please choose a report.';
		  }
		  if ($reports == 'Chat'){
                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   
                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                                   $total_count = 0;
                                   $page = $_GET['pj4'];
                                   if(empty($page)) $page = 1;
                                   
                                   //---------------------------------
                             /* select *, DATEDIFF(DATE_FORMAT(ord.RETURN_DATE, '%Y-%m-%d'), DATE_FORMAT(now(),'%Y-%m-%d')) AS REMAINING_DAYS 
							 from ".$wpdb->prefix."walleto_orders ord, ".$wpdb->prefix."quote_detail quote 
							 WHERE quote.QUOTE_ID = ord.QUOTE_ID AND '$ddate' >= ord.RETURN_DATE AND
							 ord.PROCESS_STATUS = 'WAITING_FOR_RETURN' AND ord.shipped_on <= '$ddate' AND 
							 (ord.RECEIVED_DATE IS NULL OR ord.RECEIVED_DATE = 0*/     
                                   
                                   
                            global $wpdb;  
	
                            $querystr2 = "SELECT CASE WHEN PHONE_EXTENSION IS NULL OR ''
											THEN (
											CONCAT( (
											IFNULL( PHONE_NUMBER, '' ) ) , ' ', (
											IFNULL( PHONE_EXTENSION, '' ) 
											)))
											ELSE
											(CONCAT( (
											IFNULL( PHONE_NUMBER, '' ) ) , ' x', (
											IFNULL( PHONE_EXTENSION, '' ) 
											))) END AS 'PHONE', TRANSACTION_ID, TRANSACTION_DATE, COMPANY_NAME, FIRST_NAME, LAST_NAME,
											EMAIL_ADDRESS, UNAVAILABLE_MESSAGE, INQUIRING_ABOUT
											FROM wpf_chat_details 
											WHERE '$datefrom' <= TRANSACTION_DATE AND '$dateto' >= TRANSACTION_DATE ORDER BY TRANSACTION_ID ";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count=$total_count+1;
                                   }
								   
                            $my_page = $page;    
                            $pages_curent = $page;
                     //-----------------------------------------------------------------------           
                            
                            $totalPages = ($total_count > 0 ? ceil($total_count / $nrpostsPage) : 0);
                            $pagess = $totalPages;
							
                             $querystr =   "SELECT CASE WHEN PHONE_EXTENSION IS NULL OR ''
											THEN (
											CONCAT( (
											IFNULL( PHONE_NUMBER, '' ) ) , ' ', (
											IFNULL( PHONE_EXTENSION, '' ) 
											)))
											ELSE
											(CONCAT( (
											IFNULL( PHONE_NUMBER, '' ) ) , ' x', (
											IFNULL( PHONE_EXTENSION, '' ) 
											))) END AS 'PHONE', TRANSACTION_ID, TRANSACTION_DATE, COMPANY_NAME, FIRST_NAME, LAST_NAME,
											EMAIL_ADDRESS, UNAVAILABLE_MESSAGE, INQUIRING_ABOUT
											FROM wpf_chat_details 
											WHERE '$datefrom' <= TRANSACTION_DATE AND '$dateto' >= TRANSACTION_DATE ORDER BY TRANSACTION_ID
											$desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;   

                            $pageposts = $wpdb->get_results($querystr);

                            
                            $posts_per = 7;
                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed1">
                                   <thead class="widefat1"> <tr>
								   <th>Date</th>
									<th>Transaction ID</th>
                                   <th>Company</th>
                                   <th>First Name</th>
                                   <th>Last Name</th>
                                   <th>Phone</th>
                    <th>Email</th>                
                    <th>Inquiring About</th>
					<th>Unavailable Message</th>
                    
                            </tr>
                            </thead> <tbody>

                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); 
					
					 ?>
					 
                     <?php                                    

                                          $datemade = date("m-d-Y", strtotime($post->TRANSACTION_DATE));
                                          $datemade = str_replace('-', '/', $datemade);
										  if($post->TRANSACTION_ID == 0)
											$transactionID = ' ';
										  else
											$transactionID = $post->TRANSACTION_ID;
                                                    
                                    ?>
                     
                    <tr>

					<th class = "five"><?php echo $datemade; ?></th>
					<th class = "five"><?php echo $transactionID; ?></th>
                    <th class="ten"><?php echo $post->COMPANY_NAME; ?></th>
                    <th class="ten"><?php echo $post->FIRST_NAME; ?></th>
                    <th class="ten"><?php echo $post->LAST_NAME; ?></th>
                    <th class="fifteen"><?php echo $post->PHONE ?></th>
                    <th class="ten"><?php echo $post->EMAIL_ADDRESS; ?></th>
                    <th class="fifteen"><?php echo $post->INQUIRING_ABOUT; ?></th>
					<th class="fifteen"><?php echo $post->UNAVAILABLE_MESSAGE; ?></th>
                            </tr>
                            
                   
                               
                               <?php endforeach; ?>
                    </tbody> 
                    </table> 
                     
                     
                     <div class="nav">
                     <?php
                                         
              $batch = 1000000000; //ceil($page / $nrpostsPage );
              $end = $batch * $nrpostsPage;


              if ($end > $pagess) {
                     $end = $pagess;
              }
              $start = $end - $nrpostsPage + 1;
              
              if($start < 1) $start = 1;
              
              $links = '';
       
              
              $raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
              
              $start               = $raport * $batch + 1; 
              $end          = $start + $batch - 1;
              $end_me       = $end + 1;
              $start_me     = $start - 1;
              
              if($end > $totalPages) $end = $totalPages;
              if($end_me > $totalPages) $end_me = $totalPages;
              
              if($start_me <= 0) $start_me = 1;
              
              $previous_pg = $page - 1;
              if($previous_pg <= 0) $previous_pg = 1;
              
              $next_pg = $pages_curent + 1;
              if($next_pg > $totalPages) $next_pg = 1;
              
              
              
              //PricerrTheme_get_browse_jobs_link($job_tax, $job_category, 'new', $page)
              
              if($my_page > 1)
              {      
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' .$start_me.'&des='.$desc.'&ddate='.$ddate.'&reports=Chat"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4='.$previous_pg.'&des='.$desc.'&ddate='.$ddate.'&reports=Chat"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $i.'&des='.$desc.'&ddate='.$ddate.'&reports=Chat">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $next_pg.'&des='.$desc.'&ddate='.$ddate.'&reports=Chat"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/outstanding-payments?').'pj4=' . $end_me.'&des='.$desc.'&ddate='.$ddate.'&reports=Chat">>></a>';
                                                 
                            
                                   ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
                    
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   }
                                   ?>
                
        
        
         
         
          </div>
                
       


<script>
$( "#tabs" ).tabs();

</script>

</body>
</html>

      
</div>
<?php } ?>

</div>
</div>
<?php

	echo Walleto_get_users_links();
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	
}
}}
function Walleto_register_new_user_sitemile3( $fields_method, $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $newp,
				$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry, $shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry, $address10, $address11, $ctype,
				$taxexempt, $poApproved, $billname, $shipname, $billaddressID, $shipaddressID, $sameshipping, $billattn, $shipattn, $emailSend, $description, $blackListed, $sales, $checkedthis ) {
require './wp-content/themes/Walleto/connectPDO.php';

global $wpdb;	

if ($address10 != NULL){
$billaddressID = NULL;
}
if ($address11 != NULL){
$shipaddressID = NULL;
}

	$user_email1 = $_GET['thekey'];
									$s = "select wp_users.ID from ".$wpdb->prefix."users WHERE wp_users.user_email = '$user_email1'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $uid       = $row1->ID;
                                }

/*	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'BILLING_ADDRESS' AND ADDRESS_ID = '$address10'");
                                               $query_result->execute($parms2);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																
																$billname = $row2['CUSTOMER_NAME'];
																
																}
																
								*/								
							$query_result = $DBH->prepare("SELECT  wp_usermeta.meta_value FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email1'");
                                               $query_result->execute($parms5);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
                                                               	$company = $row2['meta_value'];
																}

				
	/*			
	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'SHIPPING_ADDRESS' AND ADDRESS_ID = '$address11'");
                                               $query_result->execute($parms1);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$shipname = $row2['CUSTOMER_NAME'];
															
																}
																
				*/											

								if ($sameshipping == 'on'){

								$s = "select * from ".$wpdb->prefix."user_addresses addy WHERE addy.USER_ID = '$uid' AND addy.ADDRESS_TYPE = 'SHIPPING_ADDRESS'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
									$shipname = $row1->CUSTOMER_NAME;
									$shipattn = $row1->ATTENTION;
									$shipStreet1 = $row1->ADDRESS1;
									$shipStreet2 = $row1->ADDRESS2;
									$shipCity = $row1->CITY;
									$shipState = $row1->STATE;
									$shipZip = $row1->ZIP;
									$shipCountry = $row1->COUNTRY;
                                
								if (($billname == $shipname) && ($billattn == $shipattn) && ($billStreet1 == $shipStreet1) && ($billStreet2 == $shipStreet2) && 
								($billCity == $shipCity) && ($billState == $shipState) && ($billZip == $shipZip) && ($billCountry == $shipCountry) && ($billname == $shipname))
								{
								$address11=$row1->ADDRESS_ID;
								break;
								}else 
								$address11='New Address';
								}
									$shipname	= $billname;
									$shipattn	= $billattn;
									$shipStreet1 = $billStreet1;
									$shipStreet2 = $billStreet2;
									$shipCity = $billCity;
									$shipState = $billState;
									$shipZip = $billZip;
									$shipCountry = $billCountry;
								}	





	$errors = new WP_Error();

	global $current_theme_locale_name;
		global $wpdb;
	$s = "select * from ".$wpdb->prefix."lookup WHERE LOOKUP_TYPE = 'request_quote' AND ENABLE_FLAG = 1";
				$r = $wpdb->get_results($s);
				
				foreach ($r as $row){


	if ($row->MEANING == 'inside_sales'){
	$sales_email = $row->ATT1;
	}
	}

preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

if (count($matches)>1){
  //Then we're using IE
  $version = $matches[1];

  switch(true){
    case ($version<=8):
      //IE 8 or under!
      break;

    case ($version==9):
      //IE9!
      break;

    default:
      //You get the idea
  }
}
	// Check the e-mail address
global $current_user;


$x=0;
		// Check the firstname
if ($_GET['thekey'] == NULL) {
	if ( $company == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need company name.</b></font><br/>';
		$x = 1;
	} }
	if ( $firstname == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need first name.</b></font><br/>';
		$x = 1;
	} 
			// Check the lastname
	if ( $lastname == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need last name.</b></font><br/>';
		$x = 1;
	} 
			if ( $phone == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need phone number.</b></font><br/>';
		$x = 1;
	} else if (!(preg_match("/[(. ]?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})/", $phone))) {
  echo '<font size="2" color="red"><b>&nbsp;* The phone is incorrect.</b></font><br/>';
  $x = 1;
}
if ($_GET['thekey'] ==NULL){
	if ( $user_email == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Please type your e-mail address.</b></font><br/>';
		$x=1;
	} elseif ( ! is_email( $user_email ) ) {
		echo '<font size="2" color="red"><b>&nbsp;* The email address isn&#8217;t correct.</b></font><br/>';
		$user_email = '';
		$x=1;
	} elseif ( email_exists( $user_email ) ) {
		echo '<font size="2" color="red"><b>&nbsp;* This email is already registered, please choose another one.</b></font><br/>';
		$x=1;
	}}

			// Check the industry
	if ( ($industry == 'Select') || ($industry == NULL) ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need industry.</b></font><br/>';
		$x = 1;
	} 
		if ( $billname == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need billing name.</b></font><br/>';
		$x = 1;
	} 
	if ( $billStreet1 == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need billing address.</b></font><br/>';
		$x = 1;
	} 
		if ( $billCity == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need billing city.</b></font><br/>';
		$x = 1;
	} 
		if ( ($billState == 'Select') || ($billState == NULL )) {
		echo '<font size="2" color="red"><b>&nbsp;* Need billing state.</b></font><br/>';
		$x = 1;
	} 
		if ( $billZip == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need billing zip.</b></font><br/>';
		$x = 1;
	} 

		if ( $shipname == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping name.</b></font><br/>';
		$x = 1;
	} 
		if ( $shipStreet1 == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping street.</b></font><br/>';
		$x = 1;
	} 
		if ( $shipCity == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping city.</b></font><br/>';
		$x = 1;
	} 
		if( ($shipState == 'Select') ||  ($shipState == NULL)) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping state.</b></font><br/>';
		$x = 1;
	} 
		if ( $shipZip == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping zip.</b></font><br/>';
		$x = 1;
	}
	if($ctype == 3){
			$s = "select sales.SALESPERSON_EMAIL from ".$wpdb->prefix."salesperson sales WHERE sales.SALESPERSON_ORACLE_ID = '$sales'";
            $r = $wpdb->get_results($s);     
            foreach($r as $row1)
				{
                $salesEmail       = $row1->SALESPERSON_EMAIL;
				}
		if ( $sales == 'salesperson' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need Oracles Sales ID.</b></font><br/>';
		$x = 1;
		}
		if ($salesEmail != $user_email){
		echo '<font size="2" color="red"><b>&nbsp;* Oracle information does not match.</b></font><br/>';
		$x = 1;
		}
	}
	if($checkedthis != NULL){
	$checkedthis = 1;
	if ($taxexempt == NULL){
	echo '<font size="2" color="red"><b>&nbsp;* Tax Exempt ID needed.</b></font><br/>';
		$x = 1;
	}
	}else{
	$checkthis = 0;
	}

	if ($x==1){
	return 1;
	}
			

	do_action( 'register_post', $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $fields_method, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email, $start_date, $industry, $fields_method, $address10 );


/*
	$sq = "update $wpdb->users set user_pass='$newp' where ID='$uid'" ;
	$wpdb->query($sq);
	*/
		logging($uid, 'Password entered', 'personal_info.php');
	if($industry == 'Select'){$industry = '';}

	$user_pass = $newp;
	$today = date('Y-m-d H:i:s');
	global $wpdb;
	$today = date('Y-m-d H:i:s');
	$query_result = $DBH->prepare("UPDATE  `wp_user_addresses` SET  ENABLED_FLAG = 0 WHERE `USER_ID` = $uid");
									$query_result->execute($parms16);
	
	if ($_GET['thekey'] != NULL){






									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :industry WHERE `user_id` = $uid AND meta_key = 'industry'");
									$parm0[':industry'] = $industry;
									$query_result->execute($parm0); 
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :first WHERE `user_id` = $uid AND meta_key = 'first_name'");
									$parm1[':first'] = $firstname;
									$query_result->execute($parm1);          
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :last WHERE `user_id` = $uid AND meta_key = 'last_name'");
									$parm2[':last'] = $lastname;
									$query_result->execute($parm2);          
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :phone WHERE `user_id` = $uid AND meta_key = 'user_phone'");
									$parm3[':phone'] = $phone;
									$query_result->execute($parm3);          
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :company WHERE `user_id` = $uid AND meta_key = 'company'");
									$parm4[':company'] = $company;
									$query_result->execute($parm4);          

/*

									$query_result = $DBH->prepare("UPDATE  `wp_users` SET BILL_TO_ADDRESS1 = :billStreet1, BILL_TO_ADDRESS2 = :billStreet2, 
									BILL_TO_CITY = :billCity, BILL_TO_STATE = :billState, BILL_TO_ZIP = :billZip, BILL_TO_COUNTRY = :billCountry, SHIP_TO_ADDRESS1 = :shipStreet1, SHIP_TO_ADDRESS2 = :shipStreet2, SHIP_TO_CITY = :shipCity, 
									SHIP_TO_STATE = :shipState, SHIP_TO_ZIP = :shipZip, SHIP_TO_COUNTRY = :shipCountry, USER_TYPE = :ctype, TAX_EXEMPT_NUMBER = :taxexempt, PO_APPROVED = :poApproved WHERE `ID` = $uid");
									$parm7[':billStreet1'] = $billStreet1;
									$parm7[':billStreet2'] = $billStreet2;
									$parm7[':billCity'] = $billCity;
									$parm7[':billState'] = $billState;
									$parm7[':billZip'] = $billZip;
									$parm7[':billCountry'] = $billCountry;
									$parm7[':shipStreet1'] = $shipStreet1;
									$parm7[':shipStreet2'] = $shipStreet2;
									$parm7[':shipCity'] = $shipCity;
									$parm7[':shipState'] = $shipState;
									$parm7[':shipZip'] = $shipZip;
									$parm7[':shipCountry'] = $shipCountry;
									$parm7[':ctype'] = $ctype;
									$parm7[':taxexempt'] = $taxexempt;
									$parm7[':poApproved'] = $poApproved;
									$query_result->execute($parm7);
								*/	

									$query_result = $DBH->prepare("UPDATE  `wp_users` SET TAX_EXEMPT_FLAG = :taxFlag,ORACLE_SALESREP_ID = :oracle_salesrep_id, user_nicename = :first,
									COMMENTS = :description, DISCREPANT_FLAG = :blackListed, USER_TYPE = :ctype, TAX_EXEMPT_NUMBER = :taxexempt, PO_APPROVED = :poApproved WHERE `ID` = $uid");
									$parm7[':first'] = $firstname;
									$parm7[':oracle_salesrep_id'] = $sales;
									$parm7[':description'] = $description;
									$parm7[':blackListed'] = $blackListed;
									$parm7[':taxFlag'] = $checkedthis;
									$parm7[':ctype'] = $ctype;
									$parm7[':taxexempt'] = $taxexempt;
									$parm7[':poApproved'] = $poApproved;
									$query_result->execute($parm7);
								  								
									}else {
									
                                                                                                $user_pass = '';
                                                                                                   
                                                                                                           
                                  //create user

							wp_create_user( $company, $user_pass, $firstname, $lastname, $user_email, $phone, $industry);
								$s = "select * from ".$wpdb->prefix."users WHERE wp_users.user_email = '$user_email'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $uid       = $row1->ID;
                                }
								$query_result = $DBH->prepare("UPDATE  `wp_usermeta` 
								SET `meta_value` = '$industry'
								WHERE `meta_key` = 'industry' AND `user_id` = $uid");

									$query_result->execute($parm99);
							/*		
									$query_result = $DBH->prepare("UPDATE  `wp_users` SET BILL_TO_ADDRESS1 = :billStreet1, BILL_TO_ADDRESS2 = :billStreet2, 
									BILL_TO_CITY = :billCity, BILL_TO_STATE = :billState, BILL_TO_ZIP = :billZip, BILL_TO_COUNTRY = :billCountry, SHIP_TO_ADDRESS1 = :shipStreet1, SHIP_TO_ADDRESS2 = :shipStreet2, SHIP_TO_CITY = :shipCity, 
									SHIP_TO_STATE = :shipState, SHIP_TO_ZIP = :shipZip, SHIP_TO_COUNTRY = :shipCountry, USER_TYPE = :ctype, TAX_EXEMPT_NUMBER = :taxexempt, PO_APPROVED = :poApproved  WHERE `ID` = $uid");
									$parm7[':billStreet1'] = $billStreet1;
									$parm7[':billStreet2'] = $billStreet2;
									$parm7[':billCity'] = $billCity;
									$parm7[':billState'] = $billState;
									$parm7[':billZip'] = $billZip;
									$parm7[':billCountry'] = $billCountry;
									$parm7[':shipStreet1'] = $shipStreet1;
									$parm7[':shipStreet2'] = $shipStreet2;
									$parm7[':shipCity'] = $shipCity;
									$parm7[':shipState'] = $shipState;
									$parm7[':shipZip'] = $shipZip;
									$parm7[':shipCountry'] = $shipCountry;
									$parm7[':ctype'] = $ctype;
									$parm7[':taxexempt'] = $taxexempt;
									$parm7[':poApproved'] = $poApproved;
									$query_result->execute($parm7);
													$admin_email = get_admin_email();
													*/
															
									
									$query_result = $DBH->prepare("UPDATE  `wp_users` SET TAX_EXEMPT_FLAG = :taxFlag,ORACLE_SALESREP_ID = :oracle_salesrep_id, 
									COMMENTS = :description, DISCREPANT_FLAG = :blackListed, USER_TYPE = :ctype, TAX_EXEMPT_NUMBER = :taxexempt, PO_APPROVED = :poApproved  WHERE `ID` = $uid");
									$parm7[':description'] = $description;
									$parm7[':oracle_salesrep_id'] = $sales;
									$parm7[':blackListed'] = $blackListed;
									$parm7[':taxFlag'] = $checkedthis;
									$parm7[':ctype'] = $ctype;
									$parm7[':taxexempt'] = $taxexempt;
									$parm7[':poApproved'] = $poApproved;
									$query_result->execute($parm7);
													$admin_email = get_admin_email();
													
                          } 


	  

	

if($address10=='New Address'){
					$query_result = $DBH->prepare("INSERT INTO `wp_user_addresses` 
					(`ADDRESS_ID`, `USER_ID`, `ADDRESS_TYPE`, `CUSTOMER_NAME`, `ATTENTION`, `ADDRESS1`, `ADDRESS2`, `CITY`, `STATE`, `ZIP`, `COUNTRY`, 
					`ENABLED_FLAG`, `PRIMARY_FLAG`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATE_BY`) 
					VALUES
					('', :uid, 'BILLING_ADDRESS', :name, :billattn, :billStreet1, :billStreet2, :billCity, :billState, :billZip, :billCountry, 1, NULL, '$today', :salesid, NULL, NULL);
					");


					$parms10[':uid'] = $uid;
					$parms10[':name'] = $billname;
					$parms10[':billattn'] = $billattn;

					
					$parms10[':salesid'] = $current_user->ID;
					$parms10[':billStreet1'] = $billStreet1;
					$parms10[':billStreet2'] = $billStreet2;
					$parms10[':billCity'] = $billCity;
					$parms10[':billState'] = $billState;
					$parms10[':billZip'] = $billZip;
					$parms10[':billCountry'] = $billCountry;


					$query_result->execute($parms10); 
}else{

									$query_result = $DBH->prepare("UPDATE  `wp_user_addresses` SET CUSTOMER_NAME = :name, ATTENTION = :billattn, ADDRESS1 = :billStreet1, ADDRESS2 = :billStreet2, 
									CITY = :billCity, STATE = :billState, ZIP = :billZip, COUNTRY = :billCountry, ENABLED_FLAG = 1
									WHERE ((`ADDRESS_ID` = '$address10') OR (`ADDRESS_ID` = '$billaddressID')) AND USER_ID = '$uid'");


														$parms14[':name'] = $billname;
														$parms14[':billattn'] = $billattn;
														$parms14[':billStreet1'] = $billStreet1;
														$parms14[':billStreet2'] = $billStreet2;
														$parms14[':billCity'] = $billCity;
														$parms14[':billState'] = $billState;
														$parms14[':billZip'] = $billZip;
														$parms14[':billCountry'] = $billCountry;
									$query_result->execute($parms14);

}
if($address11=='New Address'){

					$query_result = $DBH->prepare("INSERT INTO `wp_user_addresses` 
					(`ADDRESS_ID`, `USER_ID`, `ADDRESS_TYPE`, `CUSTOMER_NAME`, `ATTENTION`, `ADDRESS1`, `ADDRESS2`, `CITY`, `STATE`, `ZIP`, `COUNTRY`, 
					`ENABLED_FLAG`, `PRIMARY_FLAG`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATE_BY`) 
					VALUES
					('', :uid, 'SHIPPING_ADDRESS', :name, :shipattn, :shipStreet1, :shipStreet2, :shipCity, :shipState, :shipZip, :shipCountry, 1, NULL, '$today', :salesid, NULL, NULL);
					");


					$parms11[':uid'] = $uid;
					$parms11[':name'] = $shipname;
					$parms11[':shipattn'] = $shipattn;

					
					$parms11[':salesid'] = $current_user->ID;
					$parms11[':shipStreet1'] = $shipStreet1;
					$parms11[':shipStreet2'] = $shipStreet2;
					$parms11[':shipCity'] = $shipCity;
					$parms11[':shipState'] = $shipState;
					$parms11[':shipZip'] = $shipZip;
					$parms11[':shipCountry'] = $shipCountry;




					$query_result->execute($parms11);  

}else{

									$query_result = $DBH->prepare("UPDATE  `wp_user_addresses` SET CUSTOMER_NAME = :name, ATTENTION = :shipattn, ADDRESS1 = :shipStreet1, ADDRESS2 = :shipStreet2, 
									CITY = :shipCity, STATE = :shipState, ZIP = :shipZip, COUNTRY = :shipCountry, ENABLED_FLAG = 1
									WHERE ((`ADDRESS_ID` = '$address11') OR (`ADDRESS_ID` = '$shipaddressID')) AND USER_ID = '$uid'");

														$parms15[':name'] = $shipname;
														$parms15[':shipattn'] = $shipattn;
														$parms15[':shipStreet1'] = $shipStreet1;
														$parms15[':shipStreet2'] = $shipStreet2;
														$parms15[':shipCity'] = $shipCity;
														$parms15[':shipState'] = $shipState;
														$parms15[':shipZip'] = $shipZip;
														$parms15[':shipCountry'] = $shipCountry;

									$query_result->execute($parms15);   

}     
                      
				if ($emailSend == 'emailSend' || $ctype >= 2){
				
				 $user_pass = wp_generate_password( 8, false);
				 $userPassMd = wp_hash_password($user_pass);
				 
				 $query_result = $DBH->prepare("UPDATE  `wp_users` 
								SET `user_pass` = :userPassMd
								WHERE `user_email` = :user_email AND `ID` = :uid");
								
									$userPassImp[':userPassMd'] = $userPassMd;
									$userPassImp[':uid'] = $uid;
									$userPassImp[':user_email'] = $user_email;
									
									$query_result->execute($userPassImp);
									
									
                             $message = "Hi {$firstname}, \r\n\r\n      We have created a RentScan account for {$company} that will allow you to login to our website.  This login will allow you to create your own quote or view and pay for any existing quotes. Please login to your account using the information below:
                                \r\n".network_site_url('/wp-login.php')." \r\n\r\n Username: {$user_email} \r\n Password: {$user_pass} \r\n\r\n 
                                We recommend you change your password after your initial login. Once you are logged in, under the 'My Account' Menu click on the 'Personal Info' link to change your password..\r\n\r\n

If you experience any difficulties, please contact us at (888) 425-8228.";
                                $message1 = "Hi {$firstname}, \r\n\r\n      We have created a RentScan account for {$company} that will allow you to login to our website.  This login will allow you to create your own quote or view and pay for any existing quotes. Please login to your account using the information below:
                                \r\n".network_site_url('/wp-login.php')." \r\n\r\n Username: {$user_email} \r\n\r\n 
                                We recommend you change your password after your initial login. Once you are logged in, under the 'My Account' Menu click on the 'Personal Info' link to change your password..\r\n\r\n

If you experience any difficulties, please contact us at (888) 425-8228.
";
                                Walleto_send_email($user_email, $subject = "Customer Account Created", $message); 
								Walleto_send_email1($sales_email, $subject = "Customer Account Created", $message1, 'quote_create', 'inside_sales'); 
								}else {
 $query_result = $DBH->prepare("UPDATE  `wp_users` 
								SET `user_pass` = ''
								WHERE `user_email` = :user_email AND `ID` = :uid");
								
								
									$userPassRes[':uid'] = $uid;
									$userPassRes[':user_email'] = $user_email;
									
									$query_result->execute($userPassRes);
									}
									$_SESSION['comp'] = $company;
									if(isset($_POST['Submit'])){
									header('Location: '.bloginfo('siteurl').'/rentscan/my-account/outstanding-payments/?key1=1');
									die;
									}
									
									if (isset($_POST['thekey2'])){
									unset ($_SESSION['my_cart']);
									 $temp = $_POST['thekey2'];
											$_SESSION['tempuser'] = $_POST['thekey2'];
											 $query_result = $DBH->prepare("SELECT wp_usermeta.meta_value FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.ID = '$temp'");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();        
                                
                                                                foreach($data1 as $row1){
																$company2 = $row1['meta_value'];
                                                                }
		$_SESSION['tempcomp'] = $company2;
		header ('Location: ../../what-we-rent');
		die;
		}
		if (isset($_GET['thekey2'])){
									unset ($_SESSION['my_cart']);
									 $temp = $_GET['thekey2'];
											$_SESSION['tempuser'] = $_GET['thekey2'];
											 $query_result = $DBH->prepare("SELECT wp_usermeta.meta_value FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.ID = '$temp'");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();        
                                
                                                                foreach($data1 as $row1){
																$company2 = $row1['meta_value'];
                                                                }
		$_SESSION['tempcomp'] = $company2;
		header ('Location: ../../what-we-rent');
		die;
		}

}
?>