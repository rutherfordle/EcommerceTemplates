<?php

function walleto_cart_area_function()
{
session_start();
global $post;
$z=0;
require './wp-content/themes/Walleto/connectPDO.php';
if(!is_user_logged_in())
								{
										header('Location: ../wp-login.php');
									 } 

	if(isset($_GET['remove_from_cart']))
	{

		$pids = $_GET['remove_from_cart'];
		$cart = $_SESSION['my_cart'];
		$i = 0;
		
		foreach($cart as $itm)
		{
			if($itm['pid'] == $pids)  { unset($_SESSION['my_cart'][$i]);  	
					if(!(get_post_meta($_SESSION['my_cart'][$i], 'overnight_shipping_sku', true))){
					unset($_SESSION['overnight']);
					$_SESSION['overnight']=0;
			}
		break; 
		}
			$i++;
		}
		$_SESSION['my_cart']=array_values($_SESSION['my_cart']);
		echo '<div class="saved-thing"><div class="padd10">'.__('Cart content updated.','Walleto').'</div></div>';
		 if($_SESSION['my_cart']==NULL){
		
		 unset($shiptype, $_POST['shipping'], $_SESSION['shiptype'], $_SESSION['arrivaldate']);
		 
		 }
		 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	 if(isset($_SESSION['arrivaldate']))
		$expected_arrival_date =  $_SESSION['arrivaldate'];
 
if(isset($_POST['ddate1'])){
$_SESSION['arrivaldate'] = $_POST['ddate1'];
 $expected_arrival_date = $_POST['ddate1'];	
 }

		$i=0;				
							
		$renew = $_SESSION['renew'];
		
		$cart = $_SESSION['my_cart']; $crt = array();

		if(is_array($_POST['cart_id_c']))
		{
			foreach($_POST['cart_id_c'] as $itm)
			{
				unset($uom, $postWkly);
				$post_au = get_post($itm);
				if ($_POST['uom'.$i] == "WK"){
				$uom=get_post_meta($itm,'uom',true);
				if (!preg_match("/\bwkly\b/i",$uom , $match))
				$postWkly = $uom.'-wkly';
				else
				$postWkly = $uom;
			
				$query_result = $DBH->prepare("SELECT posts.post_id
					FROM wp_postmeta posts
					WHERE posts.meta_key = 'uom'
					AND posts.meta_value = '$postWkly'");
					$query_result->execute($postWk); 
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$postID = $row['post_id'];
							$crt[$i]['pid'] = $postID;	
						}
					
				}else if($_POST['uom'.$i] == "MTH"){
				$uom=get_post_meta($itm,'uom',true);
				if($uom != NULL){
				$postWkly = str_replace('-wkly' ,'', $uom);

				$query_result = $DBH->prepare("SELECT posts.post_id
					FROM wp_postmeta posts
					WHERE posts.meta_key = 'uom'
					AND posts.meta_value = '$postWkly'");
					$query_result->execute($postWk); 
					$data = $query_result->fetchAll();           
						foreach($data as $row){
							$postID = $row['post_id'];
							$crt[$i]['pid'] = $postID;	
						}}else
						$crt[$i]['pid'] = $itm;
				}else
				$crt[$i]['pid'] = $itm;
				if($renew == NULL){
				$crt[$i]['quant'] = $_POST['cquant'.$itm];
				}else{
				$crt[$i]['quant'] = 1;
				}
				
				$crt[$i]['duration'] = $_POST['duration'.$i];
				$crt[$i]['uom'] = $_POST['uom'.$i];

				$i++;
			}
$x=0;
			foreach($cart as $itm)
			{ 			
				if ($itm['percent'] != NULL){
				
				$crt[$x]['percent'] = $itm['percent'];
				}
				if ($itm['disc'] != NULL){
				
				$crt[$x]['disc'] = $itm['disc'];
				}
				if ($itm['orderLineID'] != NULL){
				
				$crt[$x]['orderLineID'] = $itm['orderLineID'];
				}
				if ($itm['serialDB'] != NULL){
				
				$crt[$x]['serialDB'] = $itm['serialDB'];
				}
				if ($itm['rmaDB'] != NULL){
				
				$crt[$x]['rmaDB'] = $itm['rmaDB'];
				}
				if ($itm['oracleRMA'] != NULL){
				
				$crt[$x]['oracleRMA'] = $itm['oracleRMA'];
				}
				if ($itm['oracleRMAHeader'] != NULL){
				
				$crt[$x]['oracleRMAHeader'] = $itm['oracleRMAHeader'];
				}
				
				if ($itm['amount'] != NULL){
				$crt[$x]['disc'] = 'numberamount';
				$crt[$x]['percent'] = $itm['amount'];
}
				$x++;
			}
			
			$_SESSION['my_cart'] = $crt;
		}





	?>

<html><body>

    <div class="clear10"></div>

	
			<div class="my_box">
 <div class="box_title"><?php echo sprintf(__("My Cart Content",'Walleto')); ?></div>
            <table width="96%" align="center">
            	
                <div class="box_content">   
                 
                <?php
				
				$shiptype = $_SESSION['shiptype'];
				$today = date('m-d-Y');
				$ddate = $today;
				
				
					$cart 		= $_SESSION['my_cart']; $prc_t = 0; 
					$cart_id 	= get_option('Walleto_shopping_cart_page_id');
					$shp = 0;
					$x = 0;
					if (isset($_GET['renew'])){
					$x=1;
					}
					if (isset($_GET['edit'])){
					$x=1;
					}
					if (is_array($cart) and count($cart) > 0){
					$x = 1;
					}
					
					if ($x == 1) 
					{
					
					echo '<form method="post" action="'.$current_file.'">';	

											if  (($_SESSION['renewal']) == 1){
											unset($_SESSION['renewal']);
											
						$renewid = $_GET['renew'];

						$_SESSION['renew'] = $renewid;

					$query_result = $DBH->prepare("SELECT ordheader.ORACLE_RMA_HEADER_ID, ordheader.ORACLE_RMA_NUMBER, ordheader.CUSTOMER_ID, ordline.*
					FROM wp_walleto_order_lines ordline, wp_walleto_order_header ordheader
					WHERE ordline.ORDER_ID = '$renewid' AND ordheader.ORDER_ID = '$renewid' AND (ordline.PROCESS_STATUS = 'WAITING_FOR_RETURN' OR ordline.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_SYNC')
					AND ordline.RETURN_DATE <> '0000-00-00 00:00:00'");


					$query_result->execute($parms11); 
					$crt1 = array();
					$x=0;
					$data = $query_result->fetchAll();           
						foreach($data as $row){
								$cust = $row['CUSTOMER_ID'];
								 $post = $row['POST_ID'];
								$quant = $row['QUANTITY'];
								$return = $row['RETURN_DATE'];
								$serialDB = $row['SERIAL_NUMBER'];
								$orderLineID = $row['ORDER_LINE_ID'];
								$rmaDB = $row['ORACLE_RMA_LINE_ID'];
								$uom = $row['UOM'];
								$oracleRMA = $row['ORACLE_RMA_NUMBER'];
								$oracleRMAHeader = $row['ORACLE_RMA_HEADER_ID'];
							
									
		

				$crt1[$x]['pid'] = $post;
				$crt1[$x]['quant'] = $quant;

				$crt1[$x]['orderLineID'] = $orderLineID;
				$crt1[$x]['serialDB'] = $serialDB;
				$crt1[$x]['rmaDB'] = $rmaDB;
				$crt1[$x]['uom'] = $uom;
				$crt1[$x]['oracleRMA'] = $oracleRMA;
				$crt1[$x]['oracleRMAHeader'] = $oracleRMAHeader;
				$x++;

			
			$_SESSION['my_cart'] = $crt1;
		

						}
						$_SESSION['tempuser'] = $cust;
						header('Location: #');
						}

						if ((isset($_GET['edit'])) && (isset($_SESSION['editquote']))){
				
						 $_SESSION['editquote1'] = $_GET['edit'];

											unset($_SESSION['editquote']);
						$edit = $_GET['edit'];
						
						$_SESSION['edit'] = $edit;
						
						
					$query_result = $DBH->prepare("SELECT quoteheader.EXPECTED_ARRIVAL_DATE, quoteline.SHIP_TYPE, quoteheader.CUSTOMER_ID, quoteline.POST_ID, quoteline.DISCOUNT_AMOUNT, quoteline.DISCOUNT_PERCENT, 
					quoteline.QUANTITY, quoteline.DURATION
					FROM wp_quote_lines quoteline, wp_quote_headers quoteheader
					WHERE quoteline.QUOTE_ID = '$edit' AND quoteheader.QUOTE_ID = '$edit'");


					$query_result->execute($parms11); 
					$crt1 = array();
					$x=0;
					$data = $query_result->fetchAll();           
						foreach($data as $row){
												$edit_quote_line = $row['POST_ID'];
												$edit_discount_amount = $row['DISCOUNT_AMOUNT'];
												 $edit_discount_percent = $row['DISCOUNT_PERCENT'];
							$cust = $row['CUSTOMER_ID'];
								 $post = $row['POST_ID'];
								$quant = $row['QUANTITY'];
								$dur = $row['DURATION'];
								$shiptype = $row['SHIP_TYPE'];
								$expected_arrival_date = $row['EXPECTED_ARRIVAL_DATE'];
								
								$query_result->execute($parms11);
							$uom=get_post_meta($post ,'uom',true);
						$query_result = $DBH->prepare("SELECT pmeta.post_id
											FROM wp_terms term, wp_postmeta pmeta, wp_term_taxonomy pterm
											WHERE pmeta.meta_key = 'uom'
											AND pmeta.meta_value = term.slug
											AND term.slug = '$uom'
											AND pterm.term_id = term.term_id");

					$query_result->execute($termid); 

					$data = $query_result->fetchAll();           
						foreach($data as $row1){
						
							$tid = $row1['post_id'];
							
							

					 		if ($tid == $post)	{
							$crt1[$x]['duration'] = $dur;
							}
		}
				
				$crt1[$x]['pid'] = $post;
				$crt1[$x]['shiptype'] = $shiptype;
				$crt1[$x]['expected_arrival_date'] = $expected_arrival_date;
				$crt1[$x]['amount'] = $edit_discount_amount;
				$crt1[$x]['percent'] = $edit_discount_percent;
				$crt1[$x]['quant'] = $quant;
				
				$x++;

			
			$_SESSION['my_cart'] = $crt1;
		

						}
			$cart = $_SESSION['my_cart'];
						foreach($cart as $item)
						{	
						
						 $item['percent'];
						}
						
						$_SESSION['tempuser'] = $cust;
						header('Location: ');
						}
						if($current_user->USER_TYPE >= 3){
						
						}
						$renew = $_SESSION['renew'];
																?>
										
					<tr class="gray1"><div class="gray1">
					<td></td>
					<td align="middle"><strong>Product</strong></td>
					<?php
					if($renew != NULL){ ?>
					<td align="middle"><strong>Serial</strong></td>
					<td align="middle"><strong>RMA</strong></td>
					<?php } ?>
					<td align="middle"><strong>Quantity</strong></td>
					<?php
					if($renew != NULL){ ?>
					<td align="middle"><strong>UOM</strong></td>
					<?php } ?>
					<td align="middle"><strong>Duration</strong></td>
					<td align="middle"><strong>Unit Price</strong></td>
					<td align="middle"><strong>Total</strong></td>
					<td align="middle"><strong>Remove</strong></td>
					</div>
					</tr>
					
					
					<?php	
	
							
							$expected_arrival_date = date('m/d/Y', strtotime($expected_arrival_date));
							if ($expected_arrival_date <= date('m/d/Y',strtotime("+2 days")))
							$expected_arrival_date = 'Immediately';
							if($expected_arrival_date == '12/31/1969')
							$expected_arrival_date = 'Immediately';
							if($_POST['ddate1'] != NULL)
							$expected_arrival_date = $_POST['ddate1'];
							$x=0;
					
						foreach($cart as $item)
						{
						
						if(isset($_SESSION['shiptype']))
							$shiptype = $_SESSION['shiptype'];
							$ship_cart = $item['shiptype'];
									if($ship_cart != NULL){
	
		$_SESSION['shiptype'] = $ship_cart;
		$shiptype = $ship_cart;

		}

								if(isset($item['expected_arrival_date'])){
							$expected_arrival_date = $item['expected_arrival_date'];
							
							$expected_arrival_date = date('m/d/Y', strtotime($expected_arrival_date));
							}
								if ($_POST['shipping'] != NULL){

								 $_SESSION['shiptype'] = $_POST['shipping'];
									$shiptype = $_POST['shipping'];
									}
									

								if ($shiptype == NULL){
								$shiptype = 'Ground';
								$_SESSION['shiptype'] = 'Ground';
								}
								
							
							if($item['duration'] == NULL){
								if ($renew != NULL){
								$item['duration'] = 1;
								}
								$dur = 1;
								}
								$dur = $item['duration'];
							
								
							$post_au 	= get_post($item['pid']);
							$pp 		= Walleto_get_item_price_sale($item['pid']);
							if ($pp == NULL)
								$pp 		= Walleto_get_item_price($item['pid']);
							if ($dur == NULL)
								$prc 		= $item['quant'] * $pp;
							else
								$prc 		= $item['quant'] * $pp * $dur;

								$shp		= get_post_meta($item['pid'], 'ground_shipping', true);
								$ship_sku = get_post_meta($item['pid'], 'ground_shipping_sku', true);
							if(isset($_SESSION['edit']))
							
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
								
								$prc_t += $prc;
								$pp1 += $pp;
								$digital_good = get_post_meta($item['pid'],'digital_good',true);
							
							if ($i % 2 == 0){
								echo '<tr class="blue">';
							}else{
								echo '<tr class="grayish">';
							}
							echo ' <input type="hidden" name="cart_id_c[]" value="'.$item['pid'].'" />';
							echo '<td width="20" align="middle">'. Walleto_get_first_post_image($item['pid'], 60, 60, 'img_class') .'</td>';
							echo '<td align="middle"  width="400"><a href="'.get_permalink($item['pid']).'">'. $post_au->post_title .'</a></td>';
							if($renew == NULL){
								echo '<td align="right" width="10"><input style="text-align:right;" type="'.($digital_good == "1" ? "hidden" : "text").'" size="4" class="do_input" name="cquant'.$item['pid'].'" value="'.$item['quant'].'" /></td>';

							}else{
								echo '<td align="middle"  width="80">';
								echo $item['serialDB'].'</td>';
								echo '<td align="middle"  width="60">';
								echo $item['rmaDB'].'</td>';
								echo '<td align="middle" width="10"><input disabled=disabled style="text-align:right;" type="'.($digital_good == "1" ? "hidden" : "text").'" size="4" class="do_input" name="cquant'.$item['pid'].'" value="'.$item['quant'].'" /></td>';
								$item['quant'] = 1;
							?>
							<td align="middle"  width="180"><input style="text-align:right;" type="radio" size="4" class="do_input" <?php if ($item['uom']=='MTH') echo 'checked="checked"' ?>name="uom<?php echo $x ?>" value="MTH" />Monthly<br />
							<input style="text-align:right;" type="radio" size="4" class="do_input" <?php if($item['uom']=='WK') echo 'checked="checked"' ?>name="uom<?php echo $x ?>" value="WK" />Weekly</td>
							
							<?php
							}
							if ($item['duration'] == NULL)
							{
							echo '<td  width="10"></td>';
							}
							else{
							echo '<td align="middle"  width="10"><input style="text-align:right;" type="'.($digital_good == "1" ? "hidden" : "text").'" size="4" class="do_input" name="duration'.$x.'" value="'.$item['duration'].'" /></td>';
								}
							echo '<td class="pad-right" width="150">$'.Walleto_get_show_price($pp,2).'</td>';
							echo '<td class="pad-right" width="150">$'.Walleto_get_show_price($prc,2).'</td>';
							echo '<td align="middle"  width="200"><a class="remove-cart" href="'.walleto_get_remove_from_cart_link($item['pid']).'">'.__('Remove from Cart','Walleto'). '</a></td>';
							
							echo '</tr>';
							$i++;
							$x++;
						}
						if(isset($renew)){
							$shp1 = 0;
							}
							
						echo '<tr>';
						if($renew != NULL)
						echo '<td colspan="10"><hr color="#711"  /></td>';
						else
						echo '<td colspan="7"><hr color="#711"  /></td>';						
						echo '</tr>';
						
						//$shp = AT_get_shipping($prc_t, $uid);
						
						echo '<tr>';
						echo '<td></td><td></td><td></td><td></td><td></td>';
						if($renew != NULL)
						echo '<td></td><td></td><td></td>';
						echo '<td class="pad-right">';
						
						echo 'Subtotal:&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ '.Walleto_get_show_price($prc_t);
						echo '<br/></td></tr><tr>';
if((!isset($renew)) || ($renew != NULL)){
					
						
	 } else{echo '<td colspan="10"></td>';}



				
					?>
					
					<script>
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
xmlhttp.open("GET","../wp-content/themes/Walleto/lib/getaddress.php?t="+str,true);
xmlhttp.send();
}

</script>
</head>



<td></td>
<td>
<?php
if($renew == NULL){
?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

  <style>
  label {
    display: inline-block; width: 0;
  }
  fieldset div {
    margin-bottom: 0;
  }
  fieldset .help {
    display: inline-block;
  }
  .ui-tooltip {
    width: 230px;
  }
  </style>
  <script>
  $(function() {
    var tooltips = $( "[title]" ).tooltip({
      position: {
        my: "left top",
        at: "right+5 top-110"
      }
    });
  });
  </script>

Preferred Shipment Date:<br/>

  <script>
  $(function() {
    $( "#ddate" ).datepicker({ minDate: 1});
  });
  </script>

    <title>jQuery UI Date Picker</title>
 
    <script type="text/javascript" src="./wp-content/themes/Walleto/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="./wp-content/themes/Walleto/js/jquery-ui.js"></script>


<input type="text" id="ddate" name="ddate1" title = "This date will specify when the order leaves the warehouse. Transit times may vary 1-5 business days. If you need an estimated time, please contact customer support." value="<?php echo $expected_arrival_date ?>" >


 <?php } ?>     




</div>


<td class="pad-right"></td><td class="pad-right">

	<div style="width:50px" id="txtHint2" ><br/>
  

</div></td>
					


</head>
<body>

							
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
xmlhttp.open("GET","../wp-content/themes/Walleto/lib/getaddress.php?s="+str,true);
xmlhttp.send();
}

</script>
</head>


<td>
<?php
global $current_user;
$cart1 = $_SESSION['my_cart'];
		$a = 0;
		
		foreach($cart1 as $itm2)
		{
		if(!(get_post_meta($itm2['pid'], 'overnight_shipping_sku', true))){
			$_SESSION['overnight']=1;
		}
			$a++;
		}

if($renew == NULL){
	?>

	Ship Type:<br/>
	<select name="shipping" onchange="showUser(this.value)">

		<option <?php if($shiptype == 'Ground') echo 'selected=selected' ?> value="Ground">Ground</option>

		<option <?php if($shiptype == '2 Day Shipping') echo 'selected=selected' ?> value="2 Day Shipping">2-day Shipping</option>
		<?php 

	if($_SESSION['overnight'] != 1) { ?>
		<option <?php if($shiptype == 'Overnight Shipping') echo 'selected=selected' ?> value="Overnight Shipping">Overnight Shipping</option>
		<?php }
		
	if($current_user->USER_TYPE >= 3){ ?>
		<option <?php if($shiptype == 'Free Shipping') echo 'selected=selected' ?> value="Free Shipping">Free Shipping</option>
		<?php } ?>
		</select>
	<?php } ?>

</td>


</div>
<?php

						if($renew != NULL)
						echo '<td></td><td></td><td></td>'; 
						?>

<td class="pad-right">

	<div style="width:150px" id="txtHint" ><br/><?php echo 'Shipping:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ '.Walleto_get_show_price($shp1); ?><br/><?php echo 'Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ '.Walleto_get_show_price($prc_t + $shp1); ?>
  

</div></td>
					<?php
					

						
					
				
					
						
						
						
		$ctype = $_GET['ctype'];
		if ($ctype == NULL)
		$ctype = $today;
		
			if((!isset($renew)) || ($renew != NULL)){	?>
					

<?php } ?>


    <title>jQuery UI Date Picker</title>
 
    <script type="text/javascript" src="../wp-content/themes/Walleto/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../wp-content/themes/Walleto/js/jquery-ui.js"></script>
	

	
						
											      

					
					<?php


						global $current_user;
						
					
						
					

/* ?>



<input type="text" id="ddate" name="ddate" value="<?php $dateddatedisp = date("m-d-Y", strtotime($ddate));
                                          $dateddatedisp = str_replace('-', '/', $dateddatedisp); echo ' '.$dateddatedisp;?>">

      <td>

	  
<?php  */
						if($renew != NULL)
						echo '<tr><td colspan="10"><hr color="#711"  /></td></tr>';
						else
						echo '<tr><td colspan="7"><hr color="#711"  /></td></tr>';
						echo '<tr><td></td><td></td><td></td>';
						if($renew != NULL)
						echo '<td></td><td></td><td></td>';
						echo '<td class="pad-right">';
						echo '<td><input type="submit" name="continue_shopping_me" value="'.__('Continue Shopping','Walleto'). '" /></td>
						<td><input type="submit" name="update_card" value="'.__('Update Cart','Walleto'). '" /> </td>';
						
						echo '<td><input type="submit" name="submitcheckout" value="Checkout" />';
		
						echo '</td>
						</td>';
						echo '</tr><tr>';
						
						
						
						echo '</table></form>';
					}
					else
					{
						echo __('There are no items in your shopping cart.', 'Walleto');	
					}

				?>
                
                
                </div>
                </div>
          
    
    
    <?php	
	if ((isset($_POST['ddate1']) || ($_POST['submitcheckout'] != NULL)) && (!isset($_POST['update_card']))){

 $_SESSION['arrivaldate'] = $_POST['ddate1'];


header('Location: ./checkout/');

}
}

?>