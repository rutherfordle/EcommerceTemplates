<?php

require '../rentscan/wp-content/themes/Walleto/connectPDO.php';
sync_logging ('Sync Started', 'Sync Started'); 
unset($email, $user_email);                                                                       
require'./wp-content/themes/Walleto/lib/my_account/TrackWebServiceClient/TrackWebServiceClient.php';

$today = date('Y-m-d H:i:s');
$quoteTimeMax = strtotime ( '15 days' , strtotime ( $today ) ) ;
$quoteTimeMax = date('Y-m-d H:i:s', $quoteTimeMax);
//Quote Aging Days only
global $wpdb;
$querystr = "SELECT quote.FIRST_NAME, quote.SALESPERSON_ID, quote.AGING_FLAG, quote.QUOTE_ID, quote.USER_EMAIL,
			DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'), DATE_FORMAT(quote.CREATION_DATE, '%Y-%m-%d')) AS QUOTE_DAYS  
			FROM ".$wpdb->prefix."quote_headers quote
			WHERE quote.STATUS = 'ACTIVE'
			AND quote.CREATION_DATE <= '$quoteTimeMax' 
			";    

$pageposts = $wpdb->get_results($querystr, OBJECT);
global $wpdb;
global $post;
foreach ($pageposts as $post){
	setup_postdata($post); 
if($post->CREATION_DATE!=0 && $post->CREATION_DATE!=NULL){
	$creationDate = date("m-d-Y", strtotime($post->CREATION_DATE));
	$creationDate = str_replace('-', '/', $creationDate);
}
$today = strtotime(date('Y-m-d'));
$timeToEnd = $post->QUOTE_DAYS;
$timeToEnd = intval($timeToEnd);
$flag = $post ->AGING_FLAG;
$qid = $post->QUOTE_ID;
$email=$post->USER_EMAIL;
$salesID=$post->SALESPERSON_ID;
$first=$post->FIRST_NAME;

if($salesID !=0){
	$s = "select users.user_email from  ".$wpdb->prefix."users users,
	".$wpdb->prefix."quote_headers qid WHERE users.ID = qid.SALESPERSON_ID AND qid.QUOTE_ID = '$qid'";
    $r = $wpdb->get_results($s);     
		foreach($r as $row2){
			$sales_email = $row2->user_email;
	}
	$email = $email.', '.$sales_email;  
}

/*
$querystr1 = "SELECT VALUE
			FROM wp_lookup
			WHERE LOOKUP_TYPE = 'quote_cancel'";

	
$lookup = $wpdb->get_results($querystr1, OBJECT);
foreach ($lookup as $row){
	$quoteCancel = $row->VALUE;
	if($quoteCancel <= $timeToEnd){

		$pd = date('Y-m-d H:i:s');

		//$s = "delete from  ".$wpdb->prefix."walleto_orders where id='$oid'";
		//$s = "update ".$wpdb->prefix."walleto_orders set paid='1', paid_on='$pd' where id='$oid'";

		global $current_user;
		get_currentuserinfo();

		$s = "update ".$wpdb->prefix."quote_headers headers
				set headers.STATUS='CANCELLED', headers.LAST_UPDATE_DATE='$pd', headers.LAST_UPDATE_BY='-1' WHERE headers.QUOTE_ID = '$qid' ";
		$wpdb->query($s);
		$s = "update ".$wpdb->prefix."quote_lines line
				set line.STATUS='CANCELLED', line.LAST_UPDATE_DATE='$pd', line.LAST_UPDATE_BY='-1' WHERE line.QUOTE_ID = '$qid' ";
		$wpdb->query($s);
		}
}
*/	
	
  $querystr1 = "SELECT VALUE
		FROM wp_lookup
		WHERE LOOKUP_TYPE = 'quote_aging'";

	
$lookup = $wpdb->get_results($querystr1, OBJECT);
foreach ($lookup as $row){
	$aging = $row->VALUE;
                
	if($timeToEnd == $aging && $timeToEnd > 0 && $aging != $flag){
		echo 'QUOTE AGING DAYS';
	if($aging == 1)
		$daytype = 'day';
	else 
		$daytype = 'days';
       $message1 = "Hi {$first},\r\n\r\n This is a reminder that you currently have a pending quote for our RentScan service.  Please review the quote and let us know if there is anything else we can help you with.  If you want to proceed with the rental process simply click on the &quot;Complete Order&quot; button to pay for your rental.  If you choose not to go forward with your rental you can also click on the &quot;Cancel&quot; button to cancel your quote.  This quote will remain open for 30 days. Please login into your account using the information below:
	    \r\n".network_site_url('/wp-login.php')." \r\n\r\n Usename: {$email} \r\n Password:  Please refer to the previous email with Subject &quot;Complete Your RentScan Order&quot; as this contains your password.\r\n\r\nIf you have forgot your password you can also click on this URL to reset your password.
https://rentscanbyfujitsu.com/wp-login.php?action=lostpassword 
\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team";
                                                                               	   
	   Walleto_send_email1($email, $subject = "You Have a Pending RentScan Quote 'Quote #{$qid}'", $message1, 'quote_aging', "Aging {$aging} day");
       sync_logging("Aging", 'Aging due in '.$aging.' '.$daytype.' for '.$email.' with Order #: '.$qid);        
       $query_result = $DBH->prepare("UPDATE `wp_quote_headers` SET AGING_FLAG = :aging
                                     WHERE QUOTE_ID = '$qid' AND STATUS = 'ACTIVE'"); 
                                    $parm11[':aging'] = $aging;
                                                                                                                                                
                                 $query_result->execute($parm11);
                                }
                          }
						  }
								 
							   
// SHIPPING STAGING ONLY!! Only update---------------------------------------------------------------------------------------------------
$query_result = $DBH->prepare("SELECT usermeta.meta_value, ordheader.SALESPERSON_ID, ordheader.USER_EMAIL, ordheader.ORDER_ID, ordheader.PROCESS_STATUS, ordheader.AGING_FLAG,
								ordlines.SHIPPED_DATE, ordlines.ORACLE_RMA_LINE_ID, ordlines.WAYBILL_NUMBER, ordlines.CARRIER, ordlines.ORDER_LINE_ID
								FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines, wp_usermeta usermeta
                                WHERE usermeta.user_id = ordheader.CUSTOMER_ID 
								AND usermeta.meta_key = 'first_name'
								AND ordheader.ORDER_ID = ordlines.ORDER_ID AND ordheader.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL' 
								AND ordheader.AGING_FLAG = '' AND ordlines.SHIPPED_DATE <> '0000-00-00 00:00:00'
								AND ordlines.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL'");
$today = date('Y-m-d H:i:s');
$query_result->execute($checkEmail);          
$data = $query_result->fetchAll();
if(empty($data)){
	echo "No Result Found Shipment"; }        

foreach($data as $row){
//Takes in oracle number and header that is new, not renewal

	$agingFlag = $row['AGING_FLAG'];
	$process              = $row['PROCESS_STATUS'];
	$oid              = $row['ORDER_ID'];
	$user_email              = $row['USER_EMAIL'];
	$salesID              = $row['SALESPERSON_ID'];
	$shipped_date              = $row['SHIPPED_DATE'];
	$oracle_number              = $row['ORACLE_RMA_LINE_ID'];
	$waybill_number              = $row['WAYBILL_NUMBER'];
	$carrier              = $row['CARRIER'];
	$ordLineID			= $row['ORDER_LINE_ID'];
	$first			= $row['meta_value'];
	if($salesID != 0){								
	$query_result = $DBH->prepare("SELECT user_email FROM wp_users
							WHERE ID = '$salesID'");

	$query_result->execute($salesEmail); 
							
	$data1 = $query_result->fetchAll();


	foreach($data1 as $row){
		$sales_email = $row['user_email'];
		}
		$user_email = $user_email.', '.$sales_email; 
	}					 
	if($shipped_date!=0 && $shipped_date!=NULL){
		$shipped_date = date("m-d-Y", strtotime($shipped_date));
		$shipped_date = str_replace('-', '/', $shipped_date);  
	}										  
	$message = "Hi {$first},\r\n\r\nYour RentScan Order has shipped!\r\n\r\nOrder #: {$oid}\nDate Shipped: {$shipped_date}\nWaybill/Tracking #: {$waybill_number}\nCarrier: {$carrier}\nRMA #: {$oracle_number}\r\n\r\nYou can also check your status by logging into ".network_site_url('/wp-login.php')." under 'All Orders'.\r\n\r\nTo get started when your scanner arrives, remove the USB stick from the scanner case and insert it into the computer you will be using for your scanning project. Then follow the quick RentScan Getting Started Tutorial to begin.  Refer to helpful guides/information in the Documentation folder of the USB stick.\r\n\r\nPlease share this email with everyone that will be working on the project.  If you need assistance, then please call us at (888) 425-8228 for Sales or (800) 626-4686 for Technical Support..\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team";

	Walleto_send_email1($user_email, $subject = "RentScan Getting Started - Order #: {$oid}", $message, 'ship_create', 'inside_sales'); 

	$query_result = $DBH->prepare("UPDATE `wp_walleto_order_lines` SET PROCESS_STATUS = 'SHIP_STATUS_QUEUE'
									WHERE ORDER_LINE_ID = '$ordLineID'"); 
																			
	$query_result->execute($setQueue);

	$checker = 'unchecked';                             
	$query_result = $DBH->prepare("SELECT ordlines.ORDER_LINE_ID
									FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines
									WHERE ordheader.ORDER_ID = ordlines.ORDER_ID 
									AND ordlines.ORDER_ID = '$oid'
									AND ordheader.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL' 
									AND ordlines.SHIPPED_DATE = '0000-00-00 00:00:00'");
	$query_result->execute($getData);  
	$data1 = $query_result->fetchAll();
	foreach($data1 as $row){
		$checker = 'checked';
	}
	if ($checker == 'unchecked'){                           
		$query_result = $DBH->prepare("UPDATE `wp_walleto_order_header` SET AGING_FLAG = 'shipped'
										WHERE ORDER_ID = '$oid'");

		$query_result->execute($shipFlag); 
		$query_result = $DBH->prepare("UPDATE `wp_walleto_order_lines` SET PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL'
										WHERE ORDER_ID = '$oid'");

		$query_result->execute($shipFlag);   
	}									
}

//Delivery Date
$query_result = $DBH->prepare("SELECT ORDER_ID 
								FROM wp_walleto_order_header
								WHERE PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL' 
								AND AGING_FLAG = 'shipped'");

$query_result->execute($getTracking);  
$data = $query_result->fetchAll();
foreach($data as $row){
	$getOrderID = $row['ORDER_ID'];


	$query_result = $DBH->prepare("SELECT WAYBILL_NUMBER, ORDER_LINE_ID, DURATION, UOM 
									FROM wp_walleto_order_lines
									WHERE ORDER_ID = '$getOrderID'
									AND SHIPPED_DATE <> '0000-00-00 00:00:00'
									AND PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL'
									AND RETURN_DATE = '0000-00-00 00:00:00'
									AND DELIVERED_DATE = '0000-00-00 00:00:00'");

	$query_result->execute($getTracking);  
	$data = $query_result->fetchAll();
	foreach($data as $row){
		$getWaybillTracking = $row['WAYBILL_NUMBER'];
		$getOrderLineID = $row['ORDER_LINE_ID'];
		$getDuration = $row['DURATION'];
		$uom = $row['UOM'];



		echo 'Pushing Delivery Date';	
		if(preg_match('/[,]+/', $getWaybillTracking)){
			$getWaybillTracking = strstr($getWaybillTracking, ',', true); // As of PHP 5.3.0
		}
		echo $actualDeliveryTimestamp = deliverDateCall($getWaybillTracking);

		if ($actualDeliveryTimestamp != NULL){
			$actualDeliveryTimestamp = date('Y-m-d H:i:s',strtotime($actualDeliveryTimestamp));
		if($uom == 'MTH'){
			$getDuration *= 30;
		}
		if($uom == 'WK'){
			$getDuration *= 7;	 
		}
		$returnDate = strtotime ( $getDuration.' days' , strtotime ( $actualDeliveryTimestamp ) ) ;
		$returnDate = date('Y-m-d H:i:s', $returnDate);

		$query_result = $DBH->prepare("UPDATE wp_walleto_order_lines SET DELIVERED_DATE = '$actualDeliveryTimestamp', RETURN_DATE = '$returnDate', 
										PROCESS_STATUS = 'WAITING_FOR_DELIVERY_SYNC'
										WHERE ORDER_LINE_ID = ' $getOrderLineID'");

		$query_result->execute($checkDelivery);          
		}     
	}
	//Check for all delivered
	$checker = 'unchecked';
	$query_result = $DBH->prepare("SELECT ORDER_LINE_ID 
									FROM wp_walleto_order_lines
									WHERE ORDER_ID = '$getOrderID'
									AND SHIPPED_DATE <> '0000-00-00 00:00:00'
									AND PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL'
									AND RETURN_DATE = '0000-00-00 00:00:00'
									AND DELIVERED_DATE = '0000-00-00 00:00:00'");

	$query_result->execute($getTracking);  
	$data1 = $query_result->fetchAll();
	foreach($data1 as $row){
		$checker = 'checked';

	}
	if ($checker != 'checked'){ 
		// Still waiting for all to be delivered
		$query_result = $DBH->prepare("SELECT MAX(DELIVERED_DATE) as maxDate 
										FROM wp_walleto_order_lines
										WHERE ORDER_ID = '$getOrderID'
										AND SHIPPED_DATE <> '0000-00-00 00:00:00'
										AND PROCESS_STATUS = 'WAITING_FOR_DELIVERY_SYNC'");

		$query_result->execute($getTracking);  
		$data1 = $query_result->fetchAll();
		foreach($data1 as $row){
			$maxDate = $row['maxDate'];

		}
		$query_result = $DBH->prepare("UPDATE wp_walleto_order_header SET
										FINAL_DELIVERED_DATE = '$maxDate', 
										PROCESS_STATUS = 'WAITING_FOR_DELIVERY_SYNC'
										WHERE ORDER_ID = '$getOrderID'");

		$query_result->execute($setDelivery);     

	}
}
	  

//Aging Days only
global $wpdb;

$today = date('Y-m-d H:i:s');


$query_result = $DBH->prepare("SELECT ATT1, VALUE
								FROM wp_lookup
								WHERE LOOKUP_TYPE = 'daily_emails'
								AND MEANING = 'daily_emails'");

$query_result->execute($getDailyType);  
$data = $query_result->fetchAll();
foreach($data as $row){
	$timeStart = $row['VALUE'];
	$emailTo = $row['ATT1'];
}
$timeStart = preg_replace('/\s+/', '', $timeStart);
$timeChecker = explode(',', $timeStart);
$todayInterval = date('Y-m-d '.$timeChecker[0]);
$todayFive = date('Y-m-d '.$timeChecker[1]);

if($today <= $todayFive && $today >= $todayInterval){
	echo '|Daily Check!|';
	$today1 = date('m/d/Y ', strtotime($today));	

	$querystr = "SELECT DISTINCT (user.meta_value), ordlines.ORDER_LINE_ID, orders.USER_EMAIL, ordlines.ORDER_ID,
	ordlines.RETURN_DATE, ordlines.AGING_FLAG, DATEDIFF( DATE_FORMAT( ordlines.RETURN_DATE, '%Y-%m-%d' ) , 
	DATE_FORMAT( now( ) , '%Y-%m-%d' ) ) AS REMAINING_DAYS, orders.SALESPERSON_ID, ordlines.MODEL_NUMBER, ordlines.SERIAL_NUMBER
	FROM wp_walleto_order_header orders, wp_walleto_order_lines ordlines, wp_usermeta user
	WHERE user.meta_key = 'first_name'
	AND user.user_id = orders.CUSTOMER_ID
	AND orders.SHIPPED_STATUS = 'SHIPPED'
	AND ordlines.ORDER_ID = orders.ORDER_ID
	AND ordlines.SHIPPED_DATE <> '0000-00-00 00:00:00'
	AND ordlines.PROCESS_STATUS = 'WAITING_FOR_RETURN'
	AND orders.PAID = '1'
	AND orders.STATUS = 'PAID'
	AND orders.PROCESS_STATUS = 'WAITING_FOR_RETURN'";    

	$pageposts = $wpdb->get_results($querystr, OBJECT);

	global $post;
	foreach ($pageposts as $post){
		setup_postdata($post); 

		if($post->RETURN_DATE!=0 && $post->RETURN_DATE!=NULL){
			$returnDate = date("m-d-Y", strtotime($post->RETURN_DATE));
			$returnDate = str_replace('-', '/', $returnDate);
		}
		$today = strtotime(date('Y-m-d'));
		$timeToEnd = $post->REMAINING_DAYS;
		$timeToEnd = intval($timeToEnd);
		$flag = $post ->AGING_FLAG;
		$ordLineID = $post ->ORDER_LINE_ID;
		$oid      = $post->ORDER_ID;
		$first      = $post->meta_value;
		$email=$post->USER_EMAIL;
		$salesID=$post->SALESPERSON_ID;
		$model=$post->MODEL_NUMBER;
		$serial=$post->SERIAL_NUMBER;

		if($salesID !=0){	  
			$s = "select users.user_email from  ".$wpdb->prefix."users users,
			".$wpdb->prefix."walleto_order_header oid WHERE users.ID = oid.SALESPERSON_ID AND oid.ORDER_ID = '$oid'";
			$r = $wpdb->get_results($s);     
			foreach($r as $row2)
			{

				$sales_email = $row2->user_email;
			}

			$email = $email.', '.$sales_email;  
		}	
		$querystr1 = "SELECT VALUE
		FROM wp_lookup
		WHERE LOOKUP_TYPE = 'aging'";

		$lookup = $wpdb->get_results($querystr1, OBJECT);
		foreach ($lookup as $row){
			$aging = $row->VALUE;

			if($timeToEnd == $aging && $timeToEnd > 0 && $aging != $flag){
				if($aging == 1)
					$daytype = 'day';
				else 
				$daytype = 'days';
					$message1 = "Hi {$first},\r\n\r\nWe wanted to let you know that your current rental period will be ending in {$aging} {$daytype}.\r\n\r\nIf you haven&rsquo;t finished your scanning project and you need to extend your rental, then please email your sales representative or give us a call at (888) 425-8228.  Be sure to include your RentScan Order number below.\r\n\r\nIf you have finished your scanning project and you are ready to return your rental(s), then please follow the repacking and shipping instructions in the Documentation folder of the RentScan USB that is included in your scanner case.\r\n\r\nRentScan Order Number: {$oid}\r\nModel Number: {$model}\r\nSerial Number: {$serial}\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team";
																						   

				Walleto_send_email1($email, $subject = "RentScan {$aging} Day Notice", $message1, 'Aging', "Aging {$aging} day");

				sync_logging("Aging", 'Aging due in '.$aging.' '.$daytype.' for '.$email.' with Order #: '.$oid);        
				$query_result = $DBH->prepare("UPDATE `wp_walleto_order_lines` SET AGING_FLAG = :aging
				WHERE ORDER_LINE_ID = '$ordLineID' AND PROCESS_STATUS = 'WAITING_FOR_RETURN'"); 
				$parm11[':aging'] = $aging;
																						
				$query_result->execute($parm11);
				}

			if($timeToEnd < 0 && $post->PROCESS_STATUS != 'RETURNED' && $timeToEnd == $aging && $aging != $flag){
				$pos_aging = abs($aging);
				$message1 = "{$first},\r\n\r\This is an automated message to let you know that your rental agreement is showing {$pos_aging} day(s) overdue. \r\n\r\nIf you have already returned your equipment, then please disregard this email.\r\n\r\nIf you haven&rsquo;t finished your scanning project and you need to extend your rental, then please email your sales representative or give us a call at (888) 425-8228.  Be sure to include your RentScan Order number below.\r\n\r\nIf you have finished your scanning project and you are ready to return your rental(s), then please follow the repacking and shipping instructions in the Documentation folder of the RentScan USB that is included in your scanner case.\r\n\r\nRentScan Order Number: {$oid}\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
				";											

				Walleto_send_email1($email, $subject = "RentScan {$pos_aging} Days Overdue", $message1, 'Aging', "{$pos_aging} days overdue");
				sync_logging("Aging", 'Aging '.$pos_aging.' days overdue for '.$email.' with Order #: '.$oid);        
				$query_result = $DBH->prepare("UPDATE `wp_walleto_order_lines` SET AGING_FLAG = :aging
				WHERE ORDER_LINE_ID = '$ordLineID'"); //make sure it matches old user email
				$parm12[':aging'] = $aging;
				$query_result->execute($parm12);
			}
		}
	}

}
//Return Delivery Date
$today = date('Y-m-d H:i:s');
$shipTimeMax = strtotime ( '6 months' , strtotime ( $today ) ) ;
$shipTimeMax = date('Y-m-d H:i:s', $shipTimeMax);

$query_result = $DBH->prepare("SELECT DISTINCT(ordlines.ORDER_ID), users.user_email, ordlines.ORDER_LINE_ID , ordlines.RETURN_WAYBILL_NUMBER, ordheader.FIRST_NAME, ordheader.SALESPERSON_ID
									FROM wp_walleto_order_lines ordlines, wp_users users, wp_walleto_order_header ordheader
									WHERE ordlines.PROCESS_STATUS = 'WAITING_FOR_RETURN' 
									AND users.ID = ordheader.CUSTOMER_ID
									AND ordheader.ORDER_ID = ordlines.ORDER_ID
									AND ordlines.RECEIVED_DATE = '0000-00-00 00:00:00'
									AND ordlines.RETURN_WAYBILL_NUMBER <> '' 
									AND ordlines.SHIPPED_DATE <= '$shipTimeMax' 
									AND ordlines.DELIVERED_DATE <> '0000-00-00 00:00:00'");

$query_result->execute($getReceived);  
$data = $query_result->fetchAll();
foreach($data as $row){
	$user_email = $row['user_email'];
	$getReturnWaybillTracking = $row['RETURN_WAYBILL_NUMBER'];
	$getOrderLineID1 = $row['ORDER_LINE_ID'];
	$getOrderID1 = $row['ORDER_ID'];
	$first = $row['FIRST_NAME'];
	$salesID = $row['SALESPERSON_ID'];



	echo '|Pushing Received Date|';														
	if(preg_match('/[,]+/', $getReturnWaybillTracking)){
		$getReturnWaybillTracking = strstr($getReturnWaybillTracking, ',', true); // As of PHP 5.3.0
	}

	echo $actualDeliveryTimestamp1 = deliverDateCall($getReturnWaybillTracking);

	if ($actualDeliveryTimestamp1 != NULL){
		$actualDeliveryTimestamp = date('Y-m-d H:i:s',strtotime($actualDeliveryTimestamp));
		$query_result = $DBH->prepare("UPDATE wp_walleto_order_lines SET RECEIVED_DATE = '$actualDeliveryTimestamp1', PROCESS_STATUS = 'RETURNED'
										WHERE ORDER_LINE_ID = ' $getOrderLineID1' 
										AND RECEIVED_DATE = '0000-00-00 00:00:00'");

		$query_result->execute($checkReturnDelivery);  

		$checker = 'unchecked';                             
		$query_result = $DBH->prepare("SELECT ordlines.ORDER_LINE_ID
										FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines
										WHERE ordheader.ORDER_ID = ordlines.ORDER_ID 
										AND ordlines.ORDER_ID = '$getOrderID1'
										AND ordlines.PROCESS_STATUS = 'WAITING_FOR_RETURN'");
		$query_result->execute($getData);  
		$data1 = $query_result->fetchAll();
		foreach($data1 as $row){
			$checker = 'checked';

		}
		if ($checker == 'unchecked'){ 

			$query_result = $DBH->prepare("UPDATE wp_walleto_order_header SET PROCESS_STATUS = 'RETURNED'
											WHERE ORDER_ID = ' $getOrderID1'");

			$query_result->execute($checkReturnDelivery1); 
		}							 

		if($salesID !=0){
			$s = "select users.user_email from  ".$wpdb->prefix."users users,
			".$wpdb->prefix."walleto_order_header oid WHERE users.ID = oid.SALESPERSON_ID AND oid.ORDER_ID = '$getOrderID1'";
			$r = $wpdb->get_results($s);     
			foreach($r as $row2)
			{

				$sales_email = $row2->user_email;
			} 

			$user_email = $user_email.', '.$sales_email;  
		}
		$message = "Hi {$first},\r\n\r\nThank you for returning your RentScan equipment.  Our team is inspecting, testing, and getting it ready for the next scanning project. We will send you a confirmation email when we finish.\r\n\r\nIn the meantime, are you interested in purchasing a scanner for your day-to-day scanning needs?  Many customers like you purchase a similar or smaller scanner to help them prevent paper archives from accumulating over time.\r\n\r\nIf you are interested, we offer a complete lineup with scanners of all sizes:\r\n\r\nFujitsu ScanSnap: http://www.fujitsu.com/global/services/computing/peripheral/scanners/ss/\r\n\r\nFujitsu fi-Series: http://www.fujitsu.com/global/services/computing/peripheral/scanners/fi/\r\n\r\nPlease give us a call to discuss purchasing a scanner at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team";

		Walleto_send_email1($user_email, $subject = "Your RentScan Equipment Has Been Received - Order #: {$getOrderID1}", $message, 'ship_create', 'inside_sales'); 
	}
}

//Daily Alerts
$today = date('Y-m-d H:i:s');


$query_result = $DBH->prepare("SELECT ATT1, VALUE
								FROM wp_lookup
								WHERE LOOKUP_TYPE = 'daily_check'
								AND MEANING = 'daily'");

$query_result->execute($getDailyType);  
$data = $query_result->fetchAll();
foreach($data as $row){
	$timeStart = $row['VALUE'];
	$emailTo = $row['ATT1'];
}
$timeStart = preg_replace('/\s+/', '', $timeStart);
$timeChecker = explode(',', $timeStart);
$todayFour = date('Y-m-d '.$timeChecker[0]);
$todayFourFive = date('Y-m-d '.$timeChecker[1]);
echo $dayCheck = $timeChecker[2];

if($today <= $todayFourFive && $today >= $todayFour){
	//$todayFour = date('Y-m-d '.'08:00:00');
	//if($today >= $todayFour){
	echo '|Daily Check!|';
	$today1 = date('m/d/Y ', strtotime($today));									
	$query_result = $DBH->prepare("SELECT ordheader.ORDER_ID, ordheader.EXPECTED_ARRIVAL_DATE, ordheader.CREATION_DATE
									FROM wp_walleto_order_lines ordlines, wp_users users, wp_walleto_order_header ordheader
									WHERE users.ID = ordheader.CUSTOMER_ID
									AND ordheader.ORDER_ID = ordlines.ORDER_ID
									AND (ordheader.PROCESS_STATUS = 'WAITING_FOR_SYNC' OR ordheader.PROCESS_STATUS = 'WAITING_FOR_SHIPMENT')
									AND ordheader.EXPECTED_ARRIVAL_DATE <= now()
									AND ordlines.SHIPPED_DATE = '0000-00-00 00:00:00'");

	$query_result->execute($getDaily);  
	$data = $query_result->fetchAll();
	foreach($data as $row){
		$orderID = $row['ORDER_ID'];
		$expectedArrivalDate = $row['EXPECTED_ARRIVAL_DATE'];
		$expectedArrivalDate = date('m/d/Y ', strtotime($expectedArrivalDate));
		$paidDate = $row['CREATION_DATE'];
		$paidDate = date('m/d/Y ', strtotime($paidDate));
		$message .= "Order ID: {$orderID} expects shipment on {$expectedArrivalDate} and paid on {$paidDate}.\r\n<hr/>";

	}

	$query_result = $DBH->prepare("SELECT qheader.QUOTE_ID
									FROM wp_quote_headers qheader
									WHERE qheader.EULA_ACCEPT_STATUS = 'Accepted'
									AND qheader.STATUS = 'ACTIVE'
	");

	$query_result->execute($getActive);  
	$data = $query_result->fetchAll();
	foreach($data as $row){
		$quoteID = $row['QUOTE_ID'];
		$message .= "Quote ID: {$quoteID} expects payment information today is {$today1}.\r\n<hr/>";

	}

	$query_result = $DBH->prepare("SELECT DISTINCT(ordheader.ORDER_ID), DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'), DATE_FORMAT(ordlines.SHIPPED_DATE, '%Y-%m-%d') ) AS REMAINING_DAYS, ordlines.SHIP_TYPE, ordlines.CARRIER, ordlines.WAYBILL_NUMBER, ordlines.SHIPPED_DATE
									FROM wp_walleto_order_header ordheader, wp_walleto_order_lines ordlines
									WHERE ordheader.ORDER_ID = ordlines.ORDER_ID 
									AND ordlines.SHIPPED_DATE <> '0000-00-00 00:00:00'
									AND ordlines.DELIVERED_DATE = '0000-00-00 00:00:00'
									ORDER BY ordheader.ORDER_ID
	");

	$query_result->execute($getDeliv);  
	$data = $query_result->fetchAll();
	foreach($data as $row){
		$orderID = $row['ORDER_ID'];
		$shipType = $row['SHIP_TYPE'];
		$carrier = $row['CARRIER'];
		$waybill = $row['WAYBILL_NUMBER'];
		$shipDate1 = $row['SHIPPED_DATE'];
		$shipDate = date('m/d/Y ', strtotime($shipDate1));
		$daysShipped = $row['REMAINING_DAYS'];
		if($daysShipped >= $dayCheck){
			if(preg_match('/[,]+/', $waybill)){
				$waybill = strstr($waybill, ',', true); // As of PHP 5.3.0
			}
			$message1 .= "Order ID: {$orderID} expected delivery and shipment was {$daysShipped} days ago.\r\nShip Date: {$shipDate}\r\nCarrier: {$carrier}\r\nDelivery Method: {$shipType}\r\nWaybill #: {$waybill}\r\n Fedex: https://www.fedex.com/fedextrack/html/index.html?tracknumbers={$waybill}&cntry_code=us \r\n<hr/>";
		}
	}

	/*
	echo $start = date('Y-m-d', strtotime($shipDate1));
	$start = new DateTime($start);
	echo $end = date('Y-m-d');
	$end = new DateTime($end);

	$holidays = array(
	);

	$period = new DatePeriod( $start, new DateInterval( 'P1D' ), $end );

	$days = array();

	foreach( $period as $day )
	{

	$dayOfWeek = $day->format( 'N' );
	if( $dayOfWeek < 6 ){
	//If the day of the week is not a pre-defined holiday
	$format = $day->format( 'Y-m-d' );
	if( false === in_array( $format, $holidays ) ){
	$days[] = $day;
	}
	}
	}
	echo $daysOver = count( $days );

	if($daysOver >= $dayCheck)
	$message1 .= "Order ID: {$orderID} expected delivery and shipment was {$daysOver} business days ago.\r\nShip Date: {$shipDate}\r\nCarrier: {$carrier}\r\nDelivery Method: {$shipType}\r\nWaybill #: {$waybill}\r\n Fedex: https://www.fedex.com/fedextrack/html/index.html?tracknumbers={$waybill}&cntry_code=us \r\n<hr/>";

	}
	*/

	if($message1 != ''){

		$query_result = $DBH->prepare("SELECT ATT1
										FROM wp_lookup
										WHERE LOOKUP_TYPE = 'deliv_check'
										AND MEANING = 'delivery'");

		$query_result->execute($getDailyType);  
		$data = $query_result->fetchAll();
		foreach($data as $row){
			$emailBusiness = $row['ATT1'];
		}

		$emailTo1 = $emailTo1.', '.$emailBusiness;
		Walleto_send_email1($emailTo1, $subject = 'RentScan Delivery Delay Alert', $message1, 'deliv_check', 'delivery'); 
	}
	$message .= $message1;
	if($message != ''){
		Walleto_send_email1($emailTo, $subject = 'RentScan Daily Error Log', $message, 'daily_check', 'daily'); 
	}
}

echo '|Sync Completed|';
sync_logging ('Sync Completed', 'Sync Completed');   	
?>

