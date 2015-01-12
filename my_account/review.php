<?php 
	/*
	* Call to GetExpressCheckoutDetails
	*/

	require_once ("paypal_functions.php"); 

	/*
    * in paypalfunctions.php in a session variable 
	*/
	$_SESSION['payer_id'] =	$_GET['PayerID'];

	// Check to see if the Request object contains a variable named 'token'	
	$token = "";

	if (isset($_REQUEST['token']))
	{
		$token = $_REQUEST['token'];
		$_SESSION['TOKEN'] = $token;
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
			$quoteid			= $resArrayGetExpressCheckout["L_PAYMENTREQUEST_0_NUMBER0"];
			$email 				= $resArrayGetExpressCheckout["EMAIL"]; // ' Email address of payer.
			$payerId 			= $resArrayGetExpressCheckout["PAYERID"]; // ' Unique PayPal customer account identification number.
			$payerStatus		= $resArrayGetExpressCheckout["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
			$firstName			= $resArrayGetExpressCheckout["FIRSTNAME"]; // ' Payer's first name.
			$lastName			= $resArrayGetExpressCheckout["LASTNAME"]; // ' Payer's last name.
			$cntryCode			= $resArrayGetExpressCheckout["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
			//$shipToName			= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
			//$shipToStreet		= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
			//$shipToCity			= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
			//$shipToState		= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
			//$shipToCntryCode	= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code. 
			//$shipToZip			= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
			//$addressStatus 		= $resArrayGetExpressCheckout["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal 
			$totalAmt   		= $resArrayGetExpressCheckout["PAYMENTREQUEST_0_AMT"]; // ' Total Amount to be paid by buyer
			$currencyCode       = $resArrayGetExpressCheckout["CURRENCYCODE"]; // 'Currency being used 
			$shippingAmt        = $resArrayGetExpressCheckout["PAYMENTREQUEST_0_SHIPPINGAMT"]; // 'Currency being used 
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
	if(!USERACTION_FLAG){
	include("header.php");
?>	
<!DOCTYPE html>
<html>
<head>
	<title>Secure Login: Log In</title>
	<link rel="stylesheet" href="css/main.css" />
	<script type="text/JavaScript" src="js/sha512.js"></script> 
	<script type="text/JavaScript" src="js/forms.js"></script> 
</head>
<body>

<table width="980" height="100" border="0" cellspacing="0" cellpadding="0" class="center">	

</table><table width="400" height="0" border="0" cellspacing="0" cellpadding="0" class="center">
  
  <tr >
    <td colspan="3">
    
<div class="example1">
         <div id="i" align=center height="334">
		<div class="overlay"> 
		<table width="400" height="0" border="0" cellspacing="0" cellpadding="0" class="center">
		<tr>


				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2">Please confirm your order: &nbsp;</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td>First Name:</td><td><?php echo $firstName   		?></td></tr>
				<tr><td>Last Name:</td><td><?php echo $lastName   		?></td></tr>
				<tr><td>Customer Email:</td><td><?php echo $email   		?></td></tr>
				<tr><td>Payer ID:</td><td><?php echo $payerId   		?></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>Quote Number:</td><td><?php echo $quoteid   		?></td></tr>
				<tr><td>Total Amount:</td><td><?php echo $totalAmt   		?></td></tr>
				<tr><td>Currency Code:</td><td><?php echo $currencyCode   	?></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>Status:</td><td><?php echo $payerStatus   	?></td></tr>
				<tr><td>&nbsp;</td></tr>
				<form action="return.php" name="order_confirm" method="POST">

					<tr><td><input type="Submit" name="confirm" alt="Check out with PayPal" class="btn btn-primary btn-large" value="Confirm Order"></td>
					<td><a href="../../../../../my-account"><font color="black">Cancel</font></a></td></tr>
				</form>
	</div></td></tr>

	</table>
    </body>
</html>
	<?php
	}
	?>
<?php include('footer.php'); ?>