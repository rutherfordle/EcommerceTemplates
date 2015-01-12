<?php

function walleto_checkout_area_function()
{
require './wp-content/themes/Walleto/connectPDO.php';

        $form_token = uniqid();

        /*** add the form token to the session ***/
        $_SESSION['form_token'] = $form_token;

						$cart = $_SESSION['my_cart'];
						foreach($cart as $item){
						if ($_POST['percent'.$itm] == 0);
						$_POST['percent'.$itm] = NULL;
						
						}

if (count($cart) == 0){ 
echo 'Your cart is empty';
header('Location: '.bloginfo('siteurl').'/rentscan/');
die;
}
$renew = $_SESSION['renew'];
$tempuser = $_SESSION['tempuser'];

global $current_user;
$arrivaldate =  $_SESSION['arrivaldate'];

 $shiptype = $_SESSION['shiptype'];

	if(isset($_POST['update_card']))
	{

		$i=0;$x=0;
		$cart = $_SESSION['my_cart']; $crt = array();
		
		if(is_array($_POST['cart_id_c']))
		{
			foreach($_POST['cart_id_c'] as $itm)
			{
				$crt[$i]['pid'] = $itm;
				//if ($_POST['percent'.$itm])
				$crt[$i]['percent'] = $_POST['percent'.$itm];
				if ($_POST['discount'.$itm])
				$crt[$i]['disc'] = $_POST['discount'.$itm];
				$crt[$i]['tax'] = $_POST['tax'.$itm];
				$crt[$i]['taxPerLine'] = $_POST['taxPerLine'.$itm];
				$crt[$i]['taxRate'] = $_POST['taxRate'.$itm];
				$crt[$i]['shipTaxTotal'] = $_POST['shipTaxTotal'.$itm];

				$crt[$i]['total'] = $_POST['total'.$itm];

				$i++;
			}
			foreach($cart as $itm){
				$crt[$x]['quant'] = $itm['quant'];
				$crt[$x]['duration'] = $itm['duration'];
				$crt[$x]['orderLineID'] = $itm['orderLineID'];
				$crt[$x]['serialDB'] = $itm['serialDB'];
				$crt[$x]['rmaDB'] = $itm['rmaDB'];
				$crt[$x]['uom'] = $itm['uom'];
				$crt[$x]['oracleRMA'] = $itm['oracleRMA'];
				$crt[$x]['oracleRMAHeader'] = $itm['oracleRMAHeader'];
				$x++;
			}
			$_SESSION['my_cart'] = $crt;
		}
		
		echo '<div class="saved-thing"><div class="padd10">'.__('Cart content updated.','Walleto').'</div></div>';
		
	}
		 switch( $_REQUEST["action"] ) 
		  {
			

			  			case 'register':
						
	
			
			  			default:
					if(isset($_POST['pass']) && !empty($_POST['pass']))
					{
						$p1 = trim($_POST['pass']);
						$p2 = trim($_POST['reppass']);
						
						if($p1 == $p2)
						{
							global $wpdb;
							$newp = $p1;

						}
						else
						echo __("Passwords do not match!","Walleto");
					}
		require_once( ABSPATH . WPINC . '/registration-functions.php');
		
	
	if (isset($_POST['Submit'])||isset($_POST['update_card'])) {
	if(isset($_POST['update_card'])){
	$update = $_POST['update_card'];
	
	}
	if(!isset($update)){
			$i=0;$x=0;$j=0;$k=0;$y=0;
		
		
		if(is_array($_POST['cart_id_c']))
		{
		foreach($_POST['cart_id_c'] as $itm){
		$discountval += $_POST['percent'.$itm];
		
						$crt[$j]['pid'] = $itm;
				//if ($_POST['percent'.$itm])
				$crt[$j]['percent'] = $_POST['percent'.$itm];
				if ($_POST['discount'.$itm])
				$crt[$j]['disc'] = $_POST['discount'.$itm];
				$crt[$j]['tax'] = $_POST['tax'.$itm];
				$crt[$j]['taxPerLine'] = $_POST['taxPerLine'.$itm];
				$crt[$j]['taxRate'] = $_POST['taxRate'.$itm];
				$crt[$j]['shipTaxTotal'] = $_POST['shipTaxTotal'.$itm];

				$crt[$j]['total'] = $_POST['total'.$itm];

				$j++;
		}
					foreach($cart as $itm){
				$crt[$k]['quant'] = $itm['quant'];
				$crt[$k]['duration'] = $itm['duration'];
				$crt[$k]['orderLineID'] = $itm['orderLineID'];
				$crt[$k]['serialDB'] = $itm['serialDB'];
				$crt[$k]['rmaDB'] = $itm['rmaDB'];
				$crt[$k]['uom'] = $itm['uom'];
				$crt[$k]['oracleRMA'] = $itm['oracleRMA'];
				$crt[$k]['oracleRMAHeader'] = $itm['oracleRMAHeader'];
				
				$k++;
			}
			$_SESSION['my_cart'] = $crt;
		$cart = $_SESSION['my_cart']; $crt = array();
		if ($discountval != -1){
																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.ID = '$tempuser' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'SHIPPING_ADDRESS'");
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
															
																
                                                                	}
			if (($_POST['addy1'] != NULL) || ($_POST['addy1'] == 'New Address')){
				$shipname = trim($_POST['shipcustomer']);
				$shipattn = trim($_POST['shipattn']);
				$shipStreet1 = trim($_POST['shipStreet1']);
				$shipStreet2 = trim($_POST['shipStreet2']);

				$shipCity = trim($_POST['shipCity']);
				$shipState = trim($_POST['shipState']);

				$shipZip = trim($_POST['shipZip']);
			
				}
				if($_SESSION['tempuser'] == NULL){
					$tempuser = $current_user->ID;
				}
				$query_result = $DBH->prepare("SELECT wp_users.TAX_EXEMPT_FLAG FROM wp_users WHERE wp_users.ID = '$tempuser'");
				$query_result->execute($parms3);      
				$data1 = $query_result->fetchAll();        

				foreach($data1 as $row1){
					$taxExemptFlag = $row1['TAX_EXEMPT_FLAG'];
				}	
				
		$taxValue = callForTax($shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $cart, $taxExemptFlag);
						$z=0;
						foreach($cart as $item)
						{
						$crt[$z]['taxPerLine'] = (float)$taxValue[4][$z];
						$z++;
						}
				foreach($_POST['cart_id_c'] as $itm){
				
				$crt[$i]['pid'] = $itm;
				//if ($_POST['percent'.$itm])
				$crt[$i]['percent'] = $_POST['percent'.$itm];
				$crt[$i]['disc'] = $_POST['discount'.$itm];
				$crt[$i]['tax'] = $taxValue[0];
				
				$crt[$i]['taxRate'] = $taxValue[1];
				$crt[$i]['shipTaxTotal'] = $taxValue[5];

				$crt[$i]['total'] = $taxValue[3];

				$i++;
				
				}}
				
				else{
			foreach($_POST['cart_id_c'] as $itm)
			{
				$crt[$y]['pid'] = $itm;
				//if ($_POST['percent'.$itm])
				 $crt[$y]['percent'] = $_POST['percent'.$itm];
				
				if ($_POST['discount'.$itm])
				$crt[$y]['disc'] = $_POST['discount'.$itm];
				$crt[$y]['tax'] = $_POST['tax'.$itm];
				$crt[$y]['taxPerLine'] = $_POST['taxPerLine'.$itm];
				$crt[$y]['taxRate'] = $_POST['taxRate'.$itm];
				$crt[$y]['shipTaxTotal'] = $_POST['shipTaxTotal'.$itm];

				$crt[$y]['total'] = $_POST['total'.$itm];

				$y++;
			}}
			foreach($cart as $itm){
				$crt[$x]['quant'] = $itm['quant'];
				$crt[$x]['duration'] = $itm['duration'];
				$crt[$x]['orderLineID'] = $itm['orderLineID'];
				$crt[$x]['serialDB'] = $itm['serialDB'];
				$crt[$x]['rmaDB'] = $itm['rmaDB'];
				$crt[$x]['uom'] = $itm['uom'];
				$crt[$x]['oracleRMA'] = $itm['oracleRMA'];
				$crt[$x]['oracleRMAHeader'] = $itm['oracleRMAHeader'];
				
				$x++;
			}
			
		}}
$_SESSION['my_cart'] = $crt;
$cart = $_SESSION['my_cart'];

	$tempuser = $_SESSION['tempuser'];
	if (!isset($tempuser)){
	$tempuser = $current_user->ID;
	}
																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.ID = '$tempuser' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'BILLING_ADDRESS'");
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
															
																}
																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.ID = '$tempuser' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'SHIPPING_ADDRESS'");
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
															
																
                                                                	}
																
				$sameshipping = trim($_POST['billingtoo']);
				$company = trim($_POST['company']);
				$firstname = trim($_POST['first']);
				$lastname = trim($_POST['last']);

				$user_email = trim($_POST['user_email']);
				$phone = trim($_POST['phone']);
				$address10 = trim($_POST['addy']);
				$address11 = trim($_POST['addy1']);
				$reseller_ID = trim($_POST['reseller_ID']);
				$salespersonID = trim($_POST['salespersonID']);
				$industry = trim($_POST['industry']);
				
				if (($_POST['addy'] != NULL) || ($_POST['addy'] == 'New Address')){
				$billname = trim($_POST['billcustomer']);
				$billattn = trim($_POST['billattn']);
				$billStreet1 = trim($_POST['billStreet1']);
				$billStreet2 = trim($_POST['billStreet2']);

				$billCity = trim($_POST['billCity']);
				$billState = trim($_POST['billState']);

				$billZip = trim($_POST['billZip']);
			
				}

				if (($_POST['addy1'] != NULL) || ($_POST['addy1'] == 'New Address')){
				$shipname = trim($_POST['shipcustomer']);
				$shipattn = trim($_POST['shipattn']);
				$shipStreet1 = trim($_POST['shipStreet1']);
				$shipStreet2 = trim($_POST['shipStreet2']);

				$shipCity = trim($_POST['shipCity']);
				$shipState = trim($_POST['shipState']);

				$shipZip = trim($_POST['shipZip']);
			
				}
				
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
				
				$errors = Walleto_register_new_user_sitemile2($fields_method, $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $newp,
				$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry = 'US', $shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry = 'US', $address10, $address11, $ctype,
				$taxexempt, $poApproved, $billname, $shipname, $billaddressID, $shipaddressID, $reseller_ID, $sameshipping, $billattn, $shipattn, $update, $salespersonID);
}
					{	
				if (!$errors == 1) 
						$ok_reg = 1;
						$getdetails= mysql_fetch_array(mysql_query("SELECT * FROM `wp_users` WHERE `ID`='$user_id'"));
						
$username=$getdetails['user_login'];


$creds = array();
$creds['user_login'] = $username;
$creds['user_password'] = $password;
$creds['remember'] = true;

    $user = wp_signon( $creds, false );
    if ( is_wp_error($user) )
        echo $user->get_error_message();
						//unset($company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $newp);						
					
					}	

			global $real_ttl;
			$real_ttl = __("Register", $current_theme_locale_name);			
			add_filter( 'wp_title', 'Walleto_sitemile_filter_ttl', 10, 3 );	
			
	?>


 <div class="clear10"></div>

	
			<div class="my_box"> 
            
            	<div class="box_title"><?php echo sprintf(__("Checkout",'Walleto')); ?></div>
                <div class="box_content3">   
                
                <?php
				$tempuser = $_SESSION['tempuser'];
					$cart 		= $_SESSION['my_cart']; $prc_t = 0; 
					$cart_id 	= get_option('Walleto_shopping_cart_page_id');
					$shp = 0;
					global $current_user;
									get_currentuserinfo();
									$usertype = $current_user->USER_TYPE;
					
					if(is_array($cart) and count($cart) > 0)
					{
						echo '<form method="post" action="'.$current_file.'"> <table width="100%">';
																	?>
					<tr class="gray"><div class="gray">
					
					<td colspan="1"></td>
					<?php if ($usertype >= 4) { ?>
					<td colspan="1" align="middle" ><strong>Product</strong></td>
					<?php } else { ?>
					<td colspan="3" align="middle" ><strong>Product</strong></td>
					<?php } ?>
					<?php
					if($renew != NULL){ ?>
					<td align="middle"><strong>Serial</strong></td>
					<td align="middle"><strong>RMA</strong></td>
					<?php } ?>
					<td align="middle"><strong>Quantity</strong></td>
					<td align="middle"><strong>Duration</strong></td>
					<td align="middle"><strong>Unit Price</strong></td>
					<?php if ($usertype >= 4) { ?>
					<td align="middle"><strong>Discount Type</strong></td>
					<td align="middle"><strong>Discount</strong></td>
					<?php  
					echo '<td align="middle">';
					}
					else 
					echo '<td  width="120" align="middle" colspan="1">';
					?>
					<strong>Total</strong></td>
					</tr>
					
					<?php
					$i = 0;
				
					if (isset($_SESSION['edit'])){
				$edit = $_SESSION['edit'];
   $query_result = $DBH->prepare("SELECT quote.POST_ID, quote.DISCOUNT_AMOUNT, quote.DISCOUNT_PERCENT FROM wp_quote_lines quote WHERE quote.QUOTE_ID = '$edit' ");
											   $query_result->execute($getres);      
                                $data = $query_result->fetchAll(); 
										foreach($data as $row2){
												$edit_quote_line = $row2['POST_ID'];
												$edit_discount_amount = $row2['DISCOUNT_AMOUNT'];
												$edit_discount_percent = $row2['DISCOUNT_PERCENT'];
											}	
}	
					$tempuser = $_SESSION['tempuser'];
				
					if ($current_user->user_email <> NULL && $tempuser == NULL){
                                $query_result = $DBH->prepare("SELECT wp_usermeta.meta_value, wp_users.TAX_EXEMPT_NUMBER FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'industry' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$current_user->user_email'");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();        
                                
                                                                foreach($data1 as $row1){
																$industry = $row1['meta_value'];
																$taxExemptNumber = $row1['TAX_EXEMPT_NUMBER'];
                                                                }
																$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'user_phone' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$current_user->user_email'");
                                               $query_result->execute($parms39);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
                                                                $user_email = $row2['user_email'];
																$phone = $row2['meta_value'];

                                                                }
																$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.user_email = '$current_user->user_email' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'BILLING_ADDRESS'");
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
											$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses addy, wp_users us WHERE us.user_email = '$current_user->user_email' AND us.ID = addy.USER_ID AND addy.ENABLED_FLAG = 1 AND addy.ADDRESS_TYPE = 'SHIPPING_ADDRESS'");
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
																$company = $current_user->company;
																$firstname = $current_user->first_name;
																$lastname = $current_user->last_name;

																}

																else if ($tempuser != NULL){
															
                                $query_result = $DBH->prepare("SELECT user_email, TAX_EXEMPT_NUMBER FROM wp_users WHERE ID = $tempuser");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();        
                                
                                                                foreach($data1 as $row1){
																$user_email = $row1['user_email'];
																$taxExemptNumber = $row1['TAX_EXEMPT_NUMBER'];
                                                                }
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

																$query_result = $DBH->prepare("SELECT wp_users.USER_TYPE, wp_users.PO_APPROVED FROM wp_users WHERE wp_users.user_email = '$user_email'");
                                               $query_result->execute($parms9);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){

																$ctype = $row2['USER_TYPE'];
																$poApproved = $row2['PO_APPROVED'];
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


																}

						foreach($cart as $item)
						{	

						 $item['percent'];
						
							$post_au 	= get_post($item['pid']);
							$pp 		= Walleto_get_item_price_sale($item['pid']);
							if ($pp == NULL)
							$pp 		= Walleto_get_item_price($item['pid']);
							$dur		= $item['duration'];
							
							if ($dur == NULL) $dur = 1;
							$salesPrc 		= $item['quant'] * $pp * $dur;
							if ($item['disc'] == 'percent'){
							$pct = $item['percent'];
							$dec = $pct / 100;
							$prc 		= $item['quant'] * $pp * $dur * (1 - $dec) ;
							$discount 		= $item['quant'] * $pp * $dur * $dec ;
							}
							else if ($item['disc'] == 'numberamount'){
							$pct = $item['percent'];
							
							$prc 		= ($item['quant'] * $pp * $dur ) - $pct ;
							$discount 		=  $pct ;
							} else {
							$prc 		= $item['quant'] * $pp * $dur;
							}

							$prc_t2 		+= $item['quant'] * $pp * $dur;
							$pp1 += $pp;
							if($renew != NULL){
							$shp1 = 0;
							}else{
							if ($shiptype == 'Ground')
							$shp		= get_post_meta($item['pid'], 'ground_shipping', true);
							if ($shiptype == '2 Day Shipping')
							$shp		= get_post_meta($item['pid'], '2_day_shipping', true);
							if ($shiptype == 'Overnight Shipping')
							$shp		= get_post_meta($item['pid'], 'overnight_shipping', true);
							$shp1 		+= $item['quant'] * $shp;	
							}
							$prc_t += $prc;
							$discount1 += $discount;
							
							if ($i % 2 == 0){
							echo '<tr class="blue">';
							}else{
							echo '<tr class="grayish">';
							}			
							
							echo ' <input type="hidden" name="cart_id_c[]" value="'.$item['pid'].'" />';
							echo '<td class="border-this" width="60" align="middle" colspan="1">'. Walleto_get_first_post_image($item['pid'], 50, 50, 'img_class') .'</td>';
							if ($usertype >= 4) 
							echo '<td align="middle" width="250"><a href="'.get_permalink($item['pid']).'">'. $post_au->post_title .'</a>';
							else 
							echo '<td colspan="3" align="middle"><a href="'.get_permalink($item['pid']).'">'. $post_au->post_title .'</a>';
						if($renew != NULL){
							echo '<td align="middle"  width="80">';
							echo $item['serialDB'].'</td>';
							echo '<td align="middle"  width="60">';
							echo $item['rmaDB'].'</td>';

							}
							echo '<td align="middle" width="80">'.$item['quant'].'</td>';
							//echo '<td align="right" valign="top"><a class="remove-cart" href="'.walleto_get_remove_from_cart_link($item['pid']).'">Remove from cart</a></td>';
							if ($item['duration'] == NULL){echo '<td  width="60"></td>';}else
							echo '<td align="middle"  width="80">'.$item['duration'].' </td>';

							echo '<td class = "pad-right"  width="120">$'.Walleto_get_show_price($pp).'</td>';
							$prc1 = $prc1 + $prc; 
							if ($usertype >= 4) {
							echo '
							<td width="20"><select type="POST" name="discount'.$item['pid'].'">
														<option ';
							if ($item['disc'] == 'numberamount') echo 'selected=selected';
							echo ' value="numberamount">Amount</option>
							<option ';
							if ($item['disc'] == 'percent') echo 'selected=selected';
							echo ' value="percent">Percent</option>

							</select>
							</td>
							';
							
							
							
							echo '<td align="middle" width="80"><input style="text-align:right;" type="'.($digital_good == "1" ? "hidden" : "text").'" size="4" class="do_input" name="percent'.$item['pid'].'" value="'.$item['percent'].'" /></td>';
							echo '<td class="pad-right"  width="150">$'.Walleto_get_show_price($prc).'</td>';
							
							
							
							$quant += $item['quant'];
							$i++;
							
							 } else{
							 echo '<td class="pad-right" colspan="1">$'.Walleto_get_show_price($prc);
							 }
							
							echo '</tr>';
	
							$quant += $item['quant'];
							$i++;

						}
						
						$query_result = $DBH->prepare("SELECT wp_users.TAX_EXEMPT_FLAG FROM wp_users WHERE wp_users.user_email = '$user_email'");
						$query_result->execute($parms3);      
						$data1 = $query_result->fetchAll();        

						foreach($data1 as $row1){
							$taxExemptFlag = $row1['TAX_EXEMPT_FLAG'];
						}	
				
						$taxValue = callForTax($shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $cart, $taxExemptFlag);
						//$taxValue[0] = 0;
						//$taxValue[1] = 0;
						//$taxValue[2] = 0;
						//$taxValue[3] = 0;
						//$taxValue[4] = 0;
						//$taxValue[5] = 0;
						$x=0;
						foreach($cart as $item)
						{
						echo '<input type="hidden" class="do_input" name="taxPerLine'.$item['pid'].'" value="'.$taxValue[4][$x].'" />';
						$x++;
						}
						echo '<input type="hidden" class="do_input" name="tax'.$item['pid'].'" value="'.$taxValue[0].'" />';
						echo '<input type="hidden" class="do_input" name="taxRate'.$item['pid'].'" value="'.$taxValue[1].'" />';
						echo '<input type="hidden" class="do_input" name="total'.$item['pid'].'" value="'.$taxValue[3].'" />';
						echo '<input type="hidden" class="do_input" name="shipTaxTotal'.$item['pid'].'" value="'.$taxValue[5].'" />';
						

						
						echo '<tr>';
						if($renew != NULL)
						echo '<td colspan="10"><hr color="#711"  /></td>';
						else
						echo '<td colspan="8"><hr color="#711"  /></td>';					
						echo '</tr>';
						
						//$shp = AT_get_shipping($prc_t, $uid);
						
						echo '<tr>';
						
						echo '<td colspan="2">Expected Arrival Date: '.$arrivaldate.'</td>';
						if($renew != NULL)
						echo '<td></td><td></td>';
						echo '<td class="pad-right">';
						echo '<td></td><td></td><td></td><td class="pad-right">Subtotal:</td> <td class="pad-right"> $ '.Walleto_get_show_price($prc_t, 2).'</td>';
						echo '<td></td></tr><tr>';
						echo '<td colspan="3">';
						echo 'Shipment Type: '.$shiptype;
						if($renew != NULL)
						echo '<td></td><td></td>';
						echo '<td></td><td></td><td></td><td class="pad-right">Shipping:</td> <td class="pad-right"> $ '.Walleto_get_show_price($shp1 , 2).'</td>';
						
						
						echo '<tr>';
						if($renew != NULL)
						echo '<td></td><td></td>';
								echo '<td></td><td></td><td></td><td></td><td></td><td></td><td class="pad-right">Tax: (%'.$taxValue[1].')</td> <td class="pad-right">$ '.number_format((float)$taxValue[0], 2, '.', '').'</td><tr>';
								
							/*	echo '<td colspan="3">';
								if(is_user_logged_in()){
						global $current_user;
									get_currentuserinfo();
									$user = $current_user->user_login;
									echo 'Welcome '.$user;
									
									}else{
						?>
						<a class="<?php echo $class_log; ?>" href="<?php bloginfo('siteurl') ?>/wp-login.php/?re=1"
								 name="login" id="login" />I am an existing customer or reseller</a></td>
								<?php } */
								//if ($tempuser != NULL)
								//$temps = 'For user ID: '.$tempuser;
								if ($current_user->user_email <> NULL)
								echo '<td></td><td></td><td></td>';
								if ($current_user->USER_TYPE >= 4){
								if($renew != NULL)
						echo '<td></td><td></td>';
								//echo '<td class="pad-right">Discount:</td> <td class="pad-right">- $ '.Walleto_get_show_price(($discount1), 2).'</td>';
								
								}
								echo '<tr>';
								echo '<td colspan="3">'.$temps.' </td>';
								if($renew != NULL)
						echo '<td></td><td></td>';
						echo '<td></td><td></td><td></td></td><td class="pad-right"><b>Total:</b></td> <td class="pad-right"><b>$ '.$taxValue[3].'</b></td>';
							

					
						echo '<td valign="middle">
						

						</td>';
						echo '</tr>';
						if($renew != NULL)
						echo '<td colspan="10"><hr color="#711"  /></td>';
						else
						echo '<td colspan="8"><hr color="#711"  /></td>';
						
						echo '</table>';
					} 
					else
					{
						echo __('There are no items in your shopping cart.', 'Walleto');	
					}

				?>

                             <form method="post" action="<?php echo $current_file; ?>" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
<!--<input type="hidden" name="redirect" value="http://www.myscannerrental.com/thanks-from-rentscan.html">
<input type="hidden" name="errorredirect" value="http://www.myscannerrental.com/resubmit-rentscan-quote-request.html">-->

<div id="SignUp">
<table width="900" class="signupframe1" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<input type="hidden" name="action" value="register" />
     
    </tr>
	<tr>
      <td valign="top" align="left">

	          <?php _e('Company:',$current_theme_locale_name) ?><br />
  
        <input type="text" disabled=disabled name="company" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $company; ?>"><br />
  
	  
        <span class="required">*</span><?php _e('First Name:',$current_theme_locale_name) ?><br />
   <input type="text" name="first" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $firstname; ?>" ><br />
      
        <span class="required">*</span><?php _e('Last Name:',$current_theme_locale_name) ?><br />
 
        <input type="text" name="last" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $lastname; ?>"><br />
  
         <span class="required">*</span><?php _e('Phone:',$current_theme_locale_name) ?> <br />
    
        <input type="text" name="phone" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: 999-999-9999" value = "<?php echo $phone; ?>"><br />
  
        <span class="required">*</span><?php _e('E-mail:',$current_theme_locale_name) ?><br />
     
     <?php

 echo $user_email;
 ?><p>
 
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


															
											
		if ($current_user->USER_TYPE >= 3) { ?> 
		        <span class="required"></span><?php _e('Salesperson:',$current_theme_locale_name) ?><br />
				<select name="salespersonID"> 
				<option value="0">No Sales Credit </option>
				
				<?php
				if (isset($_SESSION['renew'])){
				$renew = $_SESSION['renew'];
   $query_result = $DBH->prepare("SELECT SALESPERSON_ID FROM wp_walleto_order_header ord WHERE ord.ORDER_ID = '$renew' ");
											   $query_result->execute($getsales);      
                                $data = $query_result->fetchAll(); 
										foreach($data as $row2){
												$salespersonID = $row2['SALESPERSON_ID'];
											}	
}	
				if (isset($_SESSION['edit'])){
				$edit = $_SESSION['edit'];
   $query_result = $DBH->prepare("SELECT SALESPERSON_ID FROM wp_quote_headers quote WHERE quote.QUOTE_ID = '$edit' ");
											   $query_result->execute($getsales);      
                                $data = $query_result->fetchAll(); 
										foreach($data as $row2){
												$salespersonID = $row2['SALESPERSON_ID'];
											}	
}											
	$query_result = $DBH->prepare("SELECT user.ID, umeta.meta_value FROM wp_users user, wp_usermeta umeta WHERE umeta.meta_key = 'first_name' AND umeta.user_id = user.ID AND user.USER_TYPE = 3 ORDER BY umeta.meta_value");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																
																$salesSelectID = $row2['ID'];
																if($current_user->ID == $salesSelectID){
																	$salespersonID = $current_user->ID;
																}
																$salesSelectFirst = $row2['meta_value'];

																$query_result = $DBH->prepare("SELECT umeta.meta_value FROM wp_users user, wp_usermeta umeta WHERE umeta.meta_key = 'last_name' 
																AND umeta.user_id = user.ID AND user.ID = '$salesSelectID'");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        ksort($data);
                                                                foreach($data as $row2){
																
																
																$salesSelectLast = $row2['meta_value'];
																}
															$salesSelectName = $salesSelectFirst.' '.$salesSelectLast;
															
														
?>
<option value="<?php echo $salesSelectID ?>" <?php if ($salespersonID == $salesSelectID) echo 'selected=selected';?>><?php echo $salesSelectName ?></option>
<?php } ?>
 </select><br /><br />
<?php }

	if ($current_user->USER_TYPE >= 3) { ?> 
		       <span class="required"></span><?php _e('Reseller(optional):',$current_theme_locale_name) ?><br />
				<select name="reseller_ID"> 
				<option value="">Direct</option>
				
				<?php
				if (isset($_SESSION['renew'])){
				$renew = $_SESSION['renew'];
   $query_result = $DBH->prepare("SELECT RESELLER_ID FROM wp_walleto_order_header ord WHERE ord.ORDER_ID = '$renew' ");
											   $query_result->execute($getres);      
                                $data = $query_result->fetchAll(); 
										foreach($data as $row2){
												$reseller_ID = $row2['RESELLER_ID'];
											}	
}	
				if (isset($_SESSION['edit'])){
				$edit = $_SESSION['edit'];
   $query_result = $DBH->prepare("SELECT RESELLER_ID FROM wp_quote_headers quote WHERE quote.QUOTE_ID = '$edit' ");
											   $query_result->execute($getres1);      
                                $data = $query_result->fetchAll(); 
										foreach($data as $row2){
												$reseller_ID = $row2['RESELLER_ID'];
											}	
}											
	$query_result = $DBH->prepare("SELECT DISTINCT(meta.user_id), meta.meta_value, user.ID FROM wp_users user, wp_usermeta meta WHERE meta.user_id = user.ID AND meta.meta_key='first_name' AND user.USER_TYPE = 2");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$resellerfirst = $row2['meta_value'];
																$aid = $row2['user_id'];
																$query_result1 = $DBH->prepare("SELECT meta.meta_value FROM  wp_usermeta meta WHERE meta.meta_key='company' AND meta.user_id = '$aid' ORDER BY meta.meta_value");
                                               $query_result1->execute($parms16);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resellerComp = $row2['meta_value'];
															}
														
?>
<option value="<?php echo $aid ?>" <?php if ($aid == $reseller_ID) echo 'selected=selected';?>><?php echo $resellerComp ?></option>
<?php }


 ?>
 </select><br /><br />
		
		
		<?php }
		
		if ($current_user->user_email == NULL) { ?> 
        <span class="required">*</span><?php _e('Password:',$current_theme_locale_name) ?><br />
     
        <input autocomplete="off" type="password" name="pass" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "" value = ""><br />
 
 <span class="required">*</span><?php _e('Re-type Password:',$current_theme_locale_name) ?><br />
     
        <input autocomplete="off" type="password" name="reppass" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "" value = ""><br />
<?php } ?>
</td>
</tr>
		<tr>


<?php

											
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
xmlhttp.open("GET","../wp-content/themes/Walleto/lib/getaddress.php?q="+str,true);
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
xmlhttp.open("GET","../wp-content/themes/Walleto/lib/getaddress.php?r="+str,true);
xmlhttp.send();
}
function showUser3(str)
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
xmlhttp.open("GET","./wp-content/themes/Walleto/lib/getaddress.php?u="+str,true);
xmlhttp.send();
}

</script>

</head>
<body>
<table>
<td><div id="txtHints"><b>Billing Information</b>

</td>
<td>


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
</script>-->
<select class="trunc1" name="addy" onchange="showUser(this.value)">



<option value="New Address">New Address</option>

<?php 
if (isset($_SESSION['tempuser'])){
$tempuser1 = $_SESSION['tempuser'];
}else{
$tempuser1 = $current_user->ID;
}

	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'BILLING_ADDRESS' AND USER_ID = '$tempuser1' ORDER BY ADDRESS1");
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



	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'SHIPPING_ADDRESS'  AND USER_ID = '$tempuser1' ORDER BY ADDRESS1");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$address_display2 = $row2['CUSTOMER_NAME'].', '.$row2['ADDRESS1'].', '
									.$row2['ADDRESS2'].', '.$row2['CITY'].', '.$row2['STATE'].', '.$row2['ZIP'];
?>
<option value="<?php echo $row2['ADDRESS_ID'] ?>" <?php if ($row2['ADDRESS_ID'] == $shipID) echo 'selected = selected' ?>><?php echo $address_display2 ?></option>
<?php }


 ?>
</select>
</tr><tr><td></td>
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


<tr><td style="width:100px">

	<div style="width:500px" id="txtHint"> <br />
  <span class="required">*</span><?php _e('Bill to Company Name:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="billcustomer" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billname; ?>" ><br />
		
		<span class="required"></span><?php _e('Bill to Attn:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="billattn" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billattn; ?>" ><br />
		
		<span class="required">*</span><?php _e('Bill to Address1:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone1" Request for Quotes type="text" name="billStreet1" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billStreet1; ?>" ><br />
		      
		<span class="required"></span><?php _e('Bill to Address2:',$current_theme_locale_name) ?><br />
		
		<input id="thisone2" Request for Quotes type="text" name="billStreet2" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billStreet2; ?>" ><br />
      
        <span class="required">*</span><?php _e('Bill to City:',$current_theme_locale_name) ?><br />
 
        <input id="thisone3" Request for Quotes type="text" name="billCity" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $billCity; ?>"><br />
  
       <div >
		<span class="required ">*</span><?php _e('Bill to State:',$current_theme_locale_name) ?><br />
    
       <select name="billState" Request for Quotes>
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
     
        <input id="thisone5" Request for Quotes type="text" name="billZip" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: sample@example.com" value = "<?php echo $billZip; ?>"><br />


</div>

	</td>

	
	<td>
	
		<div style="width:300px" id="txtHint2"><br />
  <span class="required">*</span><?php _e('Ship to Company Name:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="shipcustomer" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipname; ?>" ><br />
		
		<span class="required"></span><?php _e('Ship to Attn:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone" type="text" name="shipattn" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipattn; ?>" ><br />
		
		<span class="required">*</span><?php _e('Ship to Address1:',$current_theme_locale_name) ?><br />
		
		<input  id="thisone1" Request for Quotes type="text" name="shipStreet1" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipStreet1; ?>" ><br />
		      
		<span class="required"></span><?php _e('Ship to Address2:',$current_theme_locale_name) ?><br />
		
		<input id="thisone2" Request for Quotes type="text" name="shipStreet2" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipStreet2; ?>" ><br />
      
        <span class="required">*</span><?php _e('Ship to City:',$current_theme_locale_name) ?><br />
 
        <input id="thisone3" Request for Quotes type="text" name="shipCity" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $shipCity; ?>"><br />
    <div >
		<span class="required ">*</span><?php _e('Ship to State:',$current_theme_locale_name) ?><br />
    
       <select name="shipState" Request for Quotes>
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
     
        <input id="thisone5" Request for Quotes type="text" name="shipZip" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: sample@example.com" value = "<?php echo $shipZip; ?>"><br />

		</div>
	</td>
</tr>
</table>

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
    </tr>
    <input type="hidden" name="listid" value="32092">
    <input type="hidden" name="specialid:32092" value="7XT9">

    <input type="hidden" name="clientid" value="855981">
    <input type="hidden" name="formid" value="3882">
    <input type="hidden" name="reallistid" value="1">
    <input type="hidden" name="doubleopt" value="0">
 
    <tr align="center">
      <td>
	  						
						<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
						
	  						<input type="submit" name="update_card" value="Update Cart" /> 
      						<input type="submit" name="go_back_to_my_shopping_cart_me" value="Go back to My Cart" />
						      <input id="confirmSubmit" name="Submit" type="submit" value="Complete Quote"  /></td>
						<!-- <input type="submit" name="agree_and_pay" value="'.__('Proceed to Payment','Walleto'). '" /> -->

    </tr>
    </table>
</div>
</form>
</form>
         						<script>
						var form = document.getElementById('confirmSubmit');
							form.onclick = function () {
								// this method is cancelled if window.confirm returns false
								return window.confirm('Are you sure that you want to complete this quote?');
}
						
						</script>    
                </div>
                </div>

    
    <?php		
	
}
  } 
  
function Walleto_register_new_user_sitemile2( $fields_method, $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $newp,
				$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry, $shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry, $address10, $address11, $ctype,
				$taxexempt, $poApproved, $billname, $shipname, $billaddressID, $shipaddressID, $reseller_ID, $sameshipping, $billattn, $shipattn, $update, $salespersonID ) {
require './wp-content/themes/Walleto/connectPDO.php';


$cart = $_SESSION['my_cart'];
$shiptype = $_SESSION['shiptype'];
if (count($cart) == 0){ 
echo 'Your cart is empty';
header('Location: '.bloginfo('siteurl').'/rentscan/');
die;
}


global $current_user;

if ($address10 != NULL){
$billaddressID = NULL;
}
if ($address11 != NULL){
$shipaddressID = NULL;
}
			
/*	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'BILLING_ADDRESS' AND ADDRESS_ID = '$address10'");
                                               $query_result->execute($parms2);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																
																$billname = $row2['CUSTOMER_NAME'];
												
															
																}

				
				
	$query_result = $DBH->prepare("SELECT * FROM wp_user_addresses  WHERE ADDRESS_TYPE = 'SHIPPING_ADDRESS' AND ADDRESS_ID = '$address11'");
                                               $query_result->execute($parms1);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$shipname = $row2['CUSTOMER_NAME'];
										
																
																}
		
	*/															


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
	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );
	$start_date = apply_filters( 'start_date', $start_date );
	$firstname = apply_filters( 'firstname', $firstname );
	$lastname = apply_filters( 'lastname', $lastname );
	$phone = apply_filters( 'phone', $phone );
	$industry = apply_filters( 'industry', $industry );
	$description = apply_filters( 'description', $description );
	$newp = apply_filters( 'password', $newp );
	$billStreet1 = apply_filters( 'billStreet1', $billStreet1 );
	$billStreet2 = apply_filters( 'billStreet2', $billStreet2 );
	$billCity = apply_filters( 'billCity', $billCity );
	$billState = apply_filters( 'billState', $billState );
	$billZip = apply_filters( 'billZip', $billZip );
	$shipStreet1 = apply_filters( 'shipStreet1', $shipStreet1 );
	$shipStreet2 = apply_filters( 'shipStreet2', $shipStreet2 );
	$shipCity = apply_filters( 'shipCity', $shipCity );
	$shipState = apply_filters( 'shipState', $shipState );
	$shipZip = apply_filters( 'shipZip', $shipZip );

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



			// Check the description


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

	$tempuser = $_SESSION['tempuser'];


								
	if (isset($_SESSION['tempuser'])){

	 $query_result = $DBH->prepare("SELECT user_email FROM wp_users WHERE ID = $tempuser");
                                               $query_result->execute($parms3);      
                                $data1 = $query_result->fetchAll();  

								
                                
                                                                foreach($data1 as $row1){
																$user_email1 = $row1['user_email'];
                                                                }
} else if (($current_user->user_email <> NULL && $tempuser == NULL)){
$user_email1 = $current_user->user_email;
}
									$s = "select users.ID, users.USER_TYPE, users.user_pass from ".$wpdb->prefix."users users WHERE users.user_email = '$user_email1'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $uid       = $row1->ID;
								 $usertype       = $row1->USER_TYPE;
								 $userP       = $row1->user_pass;

                                }

								if ($salespersonID != 0 || $salespersonID != NULL){
								$s = "select users.ORACLE_SALESREP_ID from ".$wpdb->prefix."users users WHERE users.ID = '$salespersonID'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $oracleSalesID       = $row1->ORACLE_SALESREP_ID;

                                }
								}else{
								$salespersonID = 0;
								$oracleSalesID = -3;
								}
						
							$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email1'");
                                               $query_result->execute($parms5);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
                                                               	$company = $row2['meta_value'];
																}

									$query_result->execute($parms16); 
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
					

$x=0;
		// Check the firstname

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
	}
 else if (!(preg_match("/[(. ]?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})/", $phone))) {
  echo '<font size="2" color="red"><b>&nbsp;* The phone is incorrect.</b></font><br/>';
  $x = 1;
}
/* if ($_GET['thekey'] ==NULL){
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
*/
	$cart 		= $_SESSION['my_cart'];

						foreach($cart as $item)
						{
						
							$tax = $item['tax'];
							$shipTaxTotal = $item['shipTaxTotal'];
							}
						
			// Check the industry
	if ( ($tax == -1) ) {
		echo '<font size="2" color="red"><b>&nbsp;* Please verify your address.</b></font><br/>';
		$x = 1;
	} 
	if ( ($shipTaxTotal == -1) ) {
		echo '<font size="2" color="red"><b>&nbsp;* Invalid shipping tax.</b></font><br/>';
		$x = 1;
	} 
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
		if ( ($shipState == 'Select') ||  ($shipState == NULL)) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping state.</b></font><br/>';
		$x = 1;
	} 
		if ( $shipZip == '' ) {
		echo '<font size="2" color="red"><b>&nbsp;* Need shipping zip.</b></font><br/>';
		$x = 1;
	}

	if ($x==1){
	return 1;
	}
$query_result = $DBH->prepare("UPDATE  `wp_user_addresses` SET  ENABLED_FLAG = 0 WHERE `USER_ID` = '$uid'");	
$query_result->execute($parms15);  						
if ($current_user->user_email <> NULL){

									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :industry WHERE `user_id` = '$uid' AND meta_key = 'industry'");
									$parm0[':industry'] = $industry;
									$query_result->execute($parm0); 
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :first WHERE `user_id` = '$uid' AND meta_key = 'first_name'");
									$parm1[':first'] = $firstname;
									$query_result->execute($parm1);          
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :last WHERE `user_id` = '$uid' AND meta_key = 'last_name'");
									$parm2[':last'] = $lastname;
									$query_result->execute($parm2);          
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :phone WHERE `user_id` = '$uid' AND meta_key = 'user_phone'");
									$parm3[':phone'] = $phone;
									$query_result->execute($parm3);          
									$query_result = $DBH->prepare("UPDATE  `wp_usermeta` SET  meta_value = :company WHERE `user_id` = '$uid' AND meta_key = 'company'");
									$parm4[':company'] = $company;
									$query_result->execute($parm4);          
									$query_result = $DBH->prepare("UPDATE  `wp_users` SET  user_nicename = :first WHERE `ID` = '$uid'");
									$parm5[':first'] = $firstname;
									$query_result->execute($parm5);
/*
									$query_result = $DBH->prepare("UPDATE  `wp_users` SET BILL_TO_ADDRESS1 = :billStreet1, BILL_TO_ADDRESS2 = :billStreet2, 
									BILL_TO_CITY = :billCity, BILL_TO_STATE = :billState, BILL_TO_ZIP = :billZip, BILL_TO_COUNTRY = :billCountry, SHIP_TO_ADDRESS1 = :shipStreet1, SHIP_TO_ADDRESS2 = :shipStreet2, SHIP_TO_CITY = :shipCity, 
									SHIP_TO_STATE = :shipState, SHIP_TO_ZIP = :shipZip, SHIP_TO_COUNTRY = :shipCountry WHERE `ID` = '$uid'");
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
									$query_result->execute($parm7);   
									*/
}else{

                                                                                                              
                                                                                                                
          //create user
                                                                               
          wp_create_user( $company, $user_pass, $firstname, $lastname, $user_email, $user_phone, $industry);
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
if ($update != NULL){
header('Location: ./checkout');
die;
}

	$s = "select ADDRESS_ID, CUSTOMER_NAME from ".$wpdb->prefix."user_addresses address WHERE ((address.CREATION_DATE = '$today') OR (address.ADDRESS_ID = '$address10')) AND address.ADDRESS_TYPE = 'BILLING_ADDRESS'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $billID       = $row1->ADDRESS_ID;
								$billname       = $row1->CUSTOMER_NAME;
                                }

								$s = "select ADDRESS_ID, CUSTOMER_NAME from ".$wpdb->prefix."user_addresses address WHERE ((address.CREATION_DATE = '$today') OR (address.ADDRESS_ID = '$address11')) AND address.ADDRESS_TYPE = 'SHIPPING_ADDRESS'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row1)
                                                                                {
                                $shipID       = $row1->ADDRESS_ID;
								$shipname       = $row1->CUSTOMER_NAME;
                                }
				$renew = $_SESSION['renew'];					
$cart 		= $_SESSION['my_cart'];

						foreach($cart as $item)
						{
						
							
							$shipRate = $item['taxRate'];
							
							$shipTaxTotal = $item['shipTaxTotal'];
							$oracleRMA = $item['oracleRMA'];
							$oracleRMAHeader = $item['oracleRMAHeader'];
							$post_au 	= get_post($item['pid']);
							$pp 		= Walleto_get_item_price_sale($item['pid']);
							if ($pp == NULL)
							$pp 		= Walleto_get_item_price($item['pid']);
							$dur		= $item['duration'];
							if ($dur == NULL) $dur = 1;
							if ($item['disc'] == 'percent'){
							$pct = $item['percent'];
							$dec = $pct / 100;
							$prc 		= $item['quant'] * $pp * $dur * (1 - $dec) ;
							}
							else if ($item['disc'] == 'numberamount'){
							$pct = $item['percent'];
							
							$prc 		= ($item['quant'] * $pp * $dur ) - $pct ;
							} else {
							$prc 		= $item['quant'] * $pp * $dur;
							}
							$discount 		= $item['quant'] * $pp * $dur * $dec ;
							if($renew != NULL){
							$shp1 = 0;
							}else{
							if ($shiptype == 'Ground'){
							$shp		= get_post_meta($item['pid'], 'ground_shipping', true);
							$ship_sku = get_post_meta($item['pid'], 'ground_shipping_sku', true);
							}
							if ($shiptype == '2 Day Shipping'){
							$shp		= get_post_meta($item['pid'], '2_day_shipping', true);
							$shp_sku		= get_post_meta($item['pid'], '2_day_sku', true);
							}
							if ($shiptype == 'Overnight Shipping'){
							$shp		= get_post_meta($item['pid'], 'overnight_shipping', true);
							$shp_sku		= get_post_meta($item['pid'], 'overnight_shipping_sku', true);
							}
							if ($shiptype == 'Free Shipping'){
							$shp		= 0;
							$shp_sku		= '';
							}
							$shp1 		+= $item['quant'] * $shp;	
							}
							$prc_t += $prc;
							
							$prc1 = $prc1 + $prc; 
							$quant += $item['quant'];
							$total1 = $item['total'];
							$total = (float) str_replace(',', '', $total1);
							}

					
					
					if ($_SESSION['arrivaldate'] == 'Immediately'){
					$arrivaldate = $today;
					}
					else{
					$arrivaldate = $_SESSION['arrivaldate'];
					$arrivaldate = date("Y-m-d H:i:s", strtotime($arrivaldate));
					}
					

					global $current_user;
					
					if ($current_user->USER_TYPE == 2){
					$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = wp_users.ID AND wp_users.user_email = '$user_email'");
                                               $query_result->execute($getresellercomp);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
                                                               	$resellerComp = $row2['meta_value'];
																}
						$reseller_ID = $current_user->ID;
					
					}
					if ($reseller_ID != NULL){
										$query_result = $DBH->prepare("SELECT * FROM wp_users, wp_usermeta WHERE wp_usermeta.meta_key = 'company' AND wp_usermeta.user_id = '$reseller_ID'");
                                               $query_result->execute($getresellercomp);      
                                $data = $query_result->fetchAll();        
                                
                                                                foreach($data as $row2){
                                                               	$resellerComp = $row2['meta_value'];
																}
					}
					
					
					if(isset ($_SESSION['editquote1'])){
					$editquote = $_SESSION['editquote1'];
					unset($_SESSION['editquote1']);
				
					$query_result = $DBH->prepare("DELETE FROM `wp_quote_lines` WHERE QUOTE_ID = :edit");
					$quotelinesdel[':edit'] = $editquote;

					$query_result->execute($quotelinesdel); 
					
					$query_result = $DBH->prepare("DELETE FROM `wp_quote_headers` WHERE QUOTE_ID = :edit");
					$quoteheaddel[':edit'] = $editquote;

					$query_result->execute($quoteheaddel); 


					}
					if($salespersonID == 0)
					$oracleSalesID = -3;

					$query_result = $DBH->prepare("INSERT INTO `wp_quote_headers` (`QUOTE_ID`, `QUOTE_NUMBER`, `TOTAL_TAX_AMOUNT`, `TOTAL_AMOUNT`, `SALESPERSON_ID`, `ORACLE_SALESREP_ID`,
					`RESELLER_ID`, `RESELLER_COMPANY_NAME`, `CUSTOMER_ID`, `FIRST_NAME`, `LAST_NAME`, `COMPANY`, `USER_PHONE`, `USER_EMAIL`, `USER_TYPE`, 
					`BILL_TO_ADDRESS_ID`, `BILL_TO_CUSTOMER`, `BILL_TO_ATTENTION`, `BILL_TO_ADDRESS1`, `BILL_TO_ADDRESS2`, `BILL_TO_CITY`, `BILL_TO_STATE`, `BILL_TO_ZIP`, `BILL_TO_COUNTRY`, 
					`SHIP_TO_ADDRESS_ID`, `SHIP_TO_CUSTOMER`, `SHIP_TO_ATTENTION`, `SHIP_TO_ADDRESS1`, `SHIP_TO_ADDRESS2`, `SHIP_TO_CITY`, `SHIP_TO_STATE`, `SHIP_TO_ZIP`, `SHIP_TO_COUNTRY`, 
					`EXPECTED_ARRIVAL_DATE`, `ORIGINAL_ORDER_ID`, `ORACLE_RMA_NUMBER`, `ORACLE_RMA_HEADER_ID`, `EMAIL_SENT_DATE`, 
					`EULA_ACCEPT_STATUS`, `EULA_DATETIME`, `EULA_ACCEPTANCE_UID`, `EULA_IP_ADDRESS`, `STATUS`, 
					`CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATE_BY`) 
					VALUES 
										('$editquote', NULL, :totalTaxAmount, :total_amount, :salesid, :oracleSalesID, :resellerID, :resellerComp, :uid, :firstname, :lastname, :company, :user_phone, :user_email, :user_type, 
					:billID, :billname, :billattn, :billStreet1, :billStreet2, :billCity, :billState, :billZip, :billCountry, 
					:shipID, :shipname, :shipattn, :shipStreet1, :shipStreet2, :shipCity, :shipState, :shipZip, :shipCountry, 
					:arrivaldate, :original, :oracleRMA, :oracleRMAHeader, '$today', NULL, NULL, NULL, NULL, 'ACTIVE', '$today', :createdid, NULL, NULL)");

					$parms8[':billID'] = $billID;
					$parms8[':billname'] = $billname;
					$parms8[':billattn'] = $billattn;
					$parms8[':shipID'] = $shipID;
					$parms8[':shipname'] = $shipname;
					$parms8[':shipattn'] = $shipattn;
					$parms8[':total_amount'] = $total;
					$parms8[':firstname'] = $firstname;
					$parms8[':lastname'] = $lastname;
					$parms8[':company'] = $company;
					$parms8[':user_phone'] = $phone;
					$parms8[':user_email'] = $user_email1;
					$parms8[':user_type'] = $usertype;
					$parms8[':salesid'] = $salespersonID;
					$parms8[':oracleSalesID'] = $oracleSalesID;
					$parms8[':billStreet1'] = $billStreet1;
					$parms8[':billStreet2'] = $billStreet2;
					$parms8[':billCity'] = $billCity;
					$parms8[':billState'] = $billState;
					$parms8[':billZip'] = $billZip;
					$parms8[':billCountry'] = $billCountry;
					$parms8[':shipID'] = $shipID;
					$parms8[':shipname'] = $shipname;
					$parms8[':shipStreet1'] = $shipStreet1;
					$parms8[':shipStreet2'] = $shipStreet2;
					$parms8[':shipCity'] = $shipCity;
					$parms8[':shipState'] = $shipState;
					$parms8[':shipZip'] = $shipZip;
					$parms8[':shipCountry'] = $shipCountry;
					$parms8[':arrivaldate'] = $arrivaldate;
					$parms8[':original'] = $renew;
					$parms8[':resellerID'] = $reseller_ID;
					$parms8[':resellerComp'] = $resellerComp;
					$parms8[':createdid'] = $current_user->ID;
					$parms8[':oracleRMA'] = $oracleRMA;
					$parms8[':oracleRMAHeader'] = $oracleRMAHeader;
					$parms8[':totalTaxAmount'] = $tax;
				


					$parms8[':uid'] = $uid;

					$query_result->execute($parms8);  
					
if($editquote == NULL){
					$query_result = $DBH->prepare("SELECT quote.QUOTE_ID FROM wp_quote_headers quote WHERE quote.CUSTOMER_ID = '$uid' AND CREATION_DATE = '$today'");
                                               $query_result->execute($parms9);      
                                $data = $query_result->fetchAll();        
                         
                                                                foreach($data as $row2){
                                                                $qid = $row2['QUOTE_ID'];
														
                                                                }
																}else{
																$qid = $editquote;
																}
			$cart 		= $_SESSION['my_cart'];
					foreach($cart as $item)
						{
						unset($serialDB, $rmaDB);
						if(isset($item['serialDB']))
						 $serialDB = $item['serialDB'];
						if(isset($item['rmaDB']))
						 $rmaDB = $item['rmaDB'];
						 if(isset($item['orderLineID']))
						 $orderLineID = $item['orderLineID'];
							$taxPerLine = $item['taxPerLine'];
							$post_au 	= get_post($item['pid']);
							$uom=get_post_meta($item['pid'],'uom',true);
							$pp 		= Walleto_get_item_price_sale($item['pid']);

							$digital_good = get_post_meta($item['pid'],'digital_good',true);
							if ($pp == NULL)
							$pp = Walleto_get_item_price($item['pid']);
														$dur		= $item['duration'];
							if ($dur == NULL){ $dur = 1;}
							if ($item['disc'] == 'percent'){
							$pct = $item['percent'];
							$dec = $pct / 100;
							$prc 		= $item['quant'] * $pp * $dur * (1 - $dec) ;
							$discount 		= $item['quant'] * $pp * $dur * $dec ;
							}
							else if ($item['disc'] == 'numberamount'){
							$pct = $item['percent'];
							
							$prc 		= ($item['quant'] * $pp * $dur ) - $pct ;
							$discount 		=  $pct ;
							} else {
							$prc 		= $item['quant'] * $pp * $dur;
							}
							
							if($renew != NULL){
							$shp = 0;
							}else{
							if ($shiptype == 'Ground'){
							$shp		= get_post_meta($item['pid'], 'ground_shipping', true);
							$shp 		= $item['quant'] * $shp;
							$shp_sku = get_post_meta($item['pid'], 'ground_shipping_sku', true);
							}
							if ($shiptype == '2 Day Shipping'){
							$shp		= get_post_meta($item['pid'], '2_day_shipping', true);
							$shp 		= $item['quant'] * $shp;
							$shp_sku		= get_post_meta($item['pid'], '2_day_sku', true);
							}
							if ($shiptype == 'Overnight Shipping'){
							$shp		= get_post_meta($item['pid'], 'overnight_shipping', true);
							$shp 		= $item['quant'] * $shp;
							$shp_sku		= get_post_meta($item['pid'], 'overnight_shipping_sku', true);
							}
							if ($shiptype == 'Free Shipping'){
							
							$shp 		= 0;
							$shp_sku		= '';
							}
							
							}
							$shipRate=(float)$shipRate;
							if ($shipTaxTotal != 0){
							 $shipLineTax = ($shp * ($shipRate + 100))/100;
							 $shipLineTax1 = ($shp * $shipRate)/100;

							}
							else{
							$shipLineTax = $shp;
							$shipLineTax1 = 0;
							}
							$prc_t += $prc;
							$single_tax = $item['quant'] * 0.00;
							$discount1 += $discount;
							$prc1 = $prc1 + $prc; 

							
							
							$renew = $_SESSION['renew'];
							$items = $item['pid'];
							$sku = get_post_meta($item['pid'],'_sku',true);
				
							$rental_number = get_post_meta($item['pid'],'rental_part_number',true);
							
						/*	if($renew != NULL){
							$query_result = $DBH->prepare("SELECT orderlines.SERIAL_NUMBER, orderlines.ORDER_LINE_ID FROM wp_walleto_order_lines orderlines 
							WHERE orderlines.ORDER_ID = '$renew' AND orderlines.POST_ID = '$items'");
                                               $query_result->execute($parms10);      
                                $data = $query_result->fetchAll();        
                         
                                                                foreach($data as $row2){
                                                                $qline = $row2['ORDER_LINE_ID'];
																$serialNumber = $row2['SERIAL_NUMBER'];
														
                                                                }
																

					}*/
					if (preg_match("/\bwkly\b/i", $uom, $match))
					$mthWkly = 'WK';
					else 
					$mthWkly = 'MTH';
					$query_result = $DBH->prepare("INSERT INTO `wp_quote_lines` (`QUOTE_LINE_ID`, `QUOTE_ID`, `POST_ID`,
					`MODEL_NUMBER`, `PART_NUMBER`, `SERIAL_NUMBER`, `RENTAL_PART_NUMBER`, 
					`UNIT_PRICE`, `QUANTITY`, `DURATION`, `UOM`, `PRODUCT_AMOUNT`, `FREIGHT_AMOUNT`, `TAX_AMOUNT`, `DISCOUNT_AMOUNT`, `DISCOUNT_PERCENT`, `TOTAL_LINE_AMOUNT`, `SHIP_TYPE`, `SHIP_SKU`,
					`ORACLE_RMA_LINE_ID`, `ORIGINAL_ORDER_LINE_ID`, `PROMOTION_CODE`, `STATUS`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATE_BY`) 
					VALUES
					('', :quote, :postid, :model, :sku, :serialDB , :rental_number, :unit_price, :quantity, :duration, :mthWkly, :single_products_amount, :single_freight_amount, 
					:taxPerLine, :discount, '',:total_line_amount, :shiptype, :shp_sku, :rmaDB, :original_line, '', 'ACTIVE', '$today', :createdid, '', '')");

					$parms[':quote'] = $qid;
					$parms[':postid'] = $item['pid'];
					$parms[':model'] = $post_au->post_title;
					$parms[':quantity'] = $item['quant'];
					
					$parms[':original_line'] = $orderLineID;
					$parms[':mthWkly'] = $mthWkly;

					$parms[':single_products_amount'] = $prc;
					$parms[':unit_price'] = $pp;
					//$parms[':single_freight_amount'] = $shipLineTax;
					$parms[':single_freight_amount'] = $shp;
					$parms[':total_line_amount'] =   floatval($prc) + floatval( $shipLineTax) +  floatval($taxPerLine  * $item['quant'] * $dur);
					$parms[':createdid'] = $current_user->ID;
					$parms[':duration'] = $dur;
					$parms[':discount'] = $discount;
					$parms[':shiptype'] = $shiptype;
					$parms[':sku'] = $sku;
					$parms[':shp_sku'] = $shp_sku;
					$parms[':serialDB'] = $serialDB;
					$parms[':taxPerLine'] =  floatval($taxPerLine * $item['quant'] * $dur) +  floatval($shipLineTax1);
					//$parms[':taxPerLine'] = $taxPerLine + $shipLineTax1;
					$parms[':rmaDB'] = $rmaDB;
					$parms[':rental_number'] = $rental_number;

					$query_result->execute($parms);      
					
}	

/*
					$query_result = $DBH->prepare("INSERT INTO `wp_walleto_orders` VALUES ('','','','',
					'$today','',
					'', '', '', '','', '', 
					:quote, '', '', '', :freight_amount, :total_amount, :uid, '', '', '', 
					'','','','','','','','','','','',:first, :last, :company, :phone, :email,
					:billStreet1,:billStreet2, :billCity, :billState, :billZip, :billCountry,
					:shipStreet1, :shipStreet2, :shipCity, :shipState, :shipZip, :shipCountry,
					'ACTIVE', 'WAITING_FOR_USER_ACTION')");

					$parms9[':quote'] = $qid;
					$parms9[':freight_amount'] = $shp1;
					$parms9[':total_amount'] = $total;
					$parms9[':uid'] = $uid;
					
					$parms9[':first'] = $first_name;
					$parms9[':last'] = $last_name;
					$parms9[':company'] = $company;
					$parms9[':phone'] = $phone;
					$parms9[':email'] = $current_user->user_email;
					
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

					$query_result->execute($parms9);   

$query_result = $DBH->prepare("UPDATE  `wp_quote_detail` SET  PROCESS_STATUS = 'WAITING_FOR_USER_DETAIL' WHERE `QUOTE_ID` = '$qid'");
									$parm1[':first'] = $first_name;
									$query_result->execute($parm1); */
								
				$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$salespersonID'");


					$query_result->execute($salesfirstname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$salesFirst = $row['meta_value'];
			}
			$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$salespersonID'");


					$query_result->execute($saleslastname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$salesLast = $row['meta_value'];
			}

			$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'user_phone' AND user_id = '$salespersonID'");


					$query_result->execute($salesPhoneCheck); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$salesPhone = $row['meta_value'];
			}
			$query_result = $DBH->prepare("SELECT user_email FROM wp_users WHERE ID = '$salespersonID'");


					$query_result->execute($saleslastname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$salesEmail = $row['user_email'];
			}
		
			$salesFullName = $salesFirst.' '.$salesLast;
		
$createdid = $current_user->ID;
						$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$createdid'");


					$query_result->execute($preparefirstname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$preparedFirst = $row['meta_value'];
			}
			$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$createdid'");


					$query_result->execute($preparelastname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$preparedLast = $row['meta_value'];
			}
			$query_result = $DBH->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'user_phone' AND user_id = '$createdid'");


					$query_result->execute($preparePhone); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$preparedPhone = $row['meta_value'];
			}
			$query_result = $DBH->prepare("SELECT user_email FROM wp_users WHERE ID = '$createdid'");


					$query_result->execute($preparelastname); 
					
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$preparedEmail = $row['user_email'];
			}
			
			$preparedFullName = $preparedFirst.' '.$preparedLast;	
			
include ('./wp-content/themes/Walleto/lib/my_account/eulapdf.php');
$tax = (float)$tax;
$today = date('Y-m-d H:i:s');
generatepdf($shiptype, $uid, $qid, $today, $company, $firstname, $lastname, $description, 
$user_email1, $phone, $start_date, $industry, $newp, 
				$billStreet1, $billStreet2, $billCity, $billState, $billZip, $billCountry, 
				$shipStreet1, $shipStreet2, $shipCity, $shipState, $shipZip, $shipCountry, 
				$po, $billname, $shipname, $discount1, $arrivaldate, $billattn, $shipattn, 
				$tax, $total, $serialDB, 1, 0, $salesFullName, $salesEmail, $salesPhone, $preparedFullName, $preparedEmail, $preparedPhone, $orderDate, $orderNumber);
				$admin_email = get_admin_email();
                                                                                                                
	
//include './test_encrypt.php';
//encryptthis();	
//require_once './wp-content/themes/Walleto/encryptf.php';
//encryptedFile();			  

              

$admin_email = get_admin_email();
 /*                                                                                                               
        $message = "Hi {$first},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\nStep 2: Review your quotation\nStep 3: Click &quot;pay&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$id}\nPassword: {$user_pass}\r\n\r\nWe recommend changing your password after your initial login. Once you are logged in, under the My Account Menu click on the &rsquo;Personal Info&rsquo; link to change your password.\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
"; 
        $message1 = "Hi {$first},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\nStep 2: Review your quotation\nStep 3: Click &quot;pay&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$id}\r\n\r\nWe recommend changing your password after your initial login. Once you are logged in, under the My Account Menu click on the &rsquo;Personal Info&rsquo; link to change your password.\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
"; 
*/

if ($userP == NULL){
				 $user_pass = wp_generate_password( 8, false);
				 $userPassMd = wp_hash_password($user_pass);
				 
				 $query_result = $DBH->prepare("UPDATE  `wp_users` 
								SET `user_pass` = :userPassMd
								WHERE `user_email` = :user_email AND `ID` = :uid");
								
									$userPassImp[':userPassMd'] = $userPassMd;
									$userPassImp[':uid'] = $uid;
									$userPassImp[':user_email'] = $user_email1;
									
									$query_result->execute($userPassImp);
									
if($salespersonID !=0){
								$s = "select users.user_email from  ".$wpdb->prefix."users users,
								".$wpdb->prefix."quote_headers qid WHERE users.ID = qid.SALESPERSON_ID AND qid.QUOTE_ID = '$qid'";
                                $r = $wpdb->get_results($s);     
                                                                foreach($r as $row2)
                                                                                {
       
		$sales_email = $row2->user_email;

                                }
}
	    $message = "Hi {$firstname},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\nStep 2: Review your quotation\nStep 3: Click &quot;Proceed to Process&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$user_email1}\nPassword: {$user_pass}\r\n\r\nWe recommend changing your password after your initial login. Once you are logged in, under the My Account Menu click on the &rsquo;Personal Info&rsquo; link to change your password.\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
"; 
        $message1 = "Hi {$firstname},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\nStep 2: Review your quotation\nStep 3: Click &quot;pay&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$user_email1}\r\n\r\nWe recommend changing your password after your initial login. Once you are logged in, under the My Account Menu click on the &rsquo;Personal Info&rsquo; link to change your password.\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
"; 

                                Walleto_send_email($user_email1, $subject = "Complete Your RentScan Order", $message);
							
                               
                                Walleto_send_email1($sales_email, $subject = "Complete Your RentScan Order", $message1, 'quote_create', 'inside_sales'); 
								
								}else{
								
								$message = "Hi {$firstname},\r\n\r\nWe&rsquo;ve uploaded your information so that you can easily and securely complete your RentScan order online:\r\n\r\nStep 1: Login using the info below to view your quote\r\nStep 2: Review your quotation\r\nStep 3: Click &quot;Proceed to Process&quot; to submit payment and complete your order.\r\n\r\nNOTE: We cannot ship your scanner until you submit payment.\r\n\r\nURL: ".network_site_url('/wp-login.php')."\nUser Name: {$user_email1}\r\n\r\nIf you experience any difficulties or need assistance completing your order, please contact us at (888) 425-8228 for Sales or (800) 626-4686 for Technical Support.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team
";  
                                Walleto_send_email($user_email1, $subject = "RentScan Quote Approved", $message);
								 Walleto_send_email1($sales_email, $subject = "Complete Your RentScan Order", $message, 'quote_create', 'inside_sales'); 
								}
									$parm11[':pass'] = $user_pass;
									$query_result->execute($parm11);                                                                                                   

	  
if(($current_user->USER_TYPE >= 3) && ($tempuser != NULL))								
$redirect_to = get_permalink(get_option('Walleto_my_account_page_id')).'/my-finances';
else
$redirect_to = get_permalink(get_option('Walleto_my_account_page_id'));
//unset ($_SESSION['tempuser'], $_SESSION['renew'], $_SESSION['my_cart'], $_SESSION['tempcomp'], $_SESSION['renew']);
	
header('Location: ../wp-content/themes/Walleto/confirmation.php');		
die;	
wp_redirect($redirect_to);
die;

									
									
									    


  	if (isset($send_email)){
	

								
          

$admin_email = get_admin_email();
                                                                                                                
                                $message = "{$firstname}, \r\n\r\n      A quote has been created for you. To view your quote, Please login into your account using the information below:
                                \r\n".network_site_url('/wp-login.php')." \r\n\r\n Usename: {$user_email1} \r\n Password: {$user_pass} \r\n\r\n 
                                We recommend you change your password after your initial login. Once you are logged in, under the My Account Menu click on the 'Personal Info' link to change your password..\r\n\r\n

If you experience any difficulties, please contact us at (888) 425-8228.";
                                $message1 = "{$firstname}, \r\n\r\n      A quote has been created for you. To view your quote, Please login into your account using the information below:
                                \r\n".network_site_url('/wp-login.php')." \r\n\r\n Usename: {$user_email1} \r\n\r\n 
                                We recommend you change your password after your initial login. Once you are logged in, under the My Account Menu click on the 'Personal Info' link to change your password..\r\n\r\n

If you experience any difficulties, please contact us at (888) 425-8228.
";
                                Walleto_send_email($user_email1, $subject = "RentScan Quote Approved", $message);
                               // Walleto_send_email1($sales_email, $subject = "RentScan Quote Approved", $message1, 'quote_create', 'inside_sales'); 
sync_logging('New User', 'New User created for '.$email);
sync_logging('New Quote', 'New Quote created for '.$email.' with Quote #:'.$quote_number);   
/*	require 'connectPDO.php';
$query_result = $DBH->prepare("INSERT INTO `request_a_quote` VALUES ('',:first_name,:last_name,
								:user_email,:user_phone,
								:company,:industry,
								:start_date,:fields_method,
								:description,'$today',
								'', '$today', 'WAITING_FOR_SYNC')");
	$parms[':first_name'] = $first_name;
	$parms[':user_email'] = $user_email;
	$parms[':user_phone'] = $user_phone;
	$parms[':last_name'] = $last_name;
	$parms[':company'] = $company;
	$parms[':industry'] = $industry;
	$parms[':start_date'] = $start_date;
	$parms[':fields_method'] = $fields_method;
	$parms[':description'] = $description;
	$query_result->execute($parms);
	*/
	}
	$user_message = "Thank you for submitting your quote request. Please review the information below and make sure that the contact information you provided is accurate. \r\n
A Fujitsu representative will contact you within 24 hours. If you need immediate assistance, please contact us at (888) 425-8228.\r\n
Would Like By: {$start_date}\r\n\r\nCompany: {$company}\r\nName: {$firstname} {$lastname}\r\nIndustry: {$industry}\r\n\r\nE-Mail: {$user_email}\r\nPhone: {$phone}\r\n\r\nComments: {$description}";
                if ( ! $query_result ) {
                $errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', $current_theme_locale_name ), get_option( 'admin_email' ) ) );
                                return $errors;
                }
                logging(-1, 'Quote requested', 'walleto-special-page-template.php');
                Walleto_send_email1($user_email1, $subject = "{$firstname} {$lastname} requested a quote", $user_message, 'request_quote', 'inside_sales');

	
	return $user_id;
}

?>