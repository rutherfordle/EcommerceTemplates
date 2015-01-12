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


if(!function_exists('Walleto_my_account_display_awa_pay_page'))
{
function Walleto_my_account_display_awa_pay_page()
{
$action = $_GET['action'];
foreach($_GET as $loc=>$qid)
    $_GET[$loc] = urldecode(base64_decode($qid));

	 $qid 		= $_GET['qid'];
	$SubTotal = $_GET['Stot'];


	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
	$first = $current_user->first_name;
	$last = $current_user->last_name;
	$today = date('m-d-Y');
	
	
	
if ($action == 'work'){ ?>

 <?php
}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>An XHTML 1.0 Strict standard template</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
           <head>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <link rel="stylesheet" href="../../wp-content/themes/Walleto/fancybox/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
        <script type="text/javascript" src="../../wp-content/themes/Walleto/fancybox/fancybox/jquery.fancybox.pack.js"></script>
    </head>
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
</html>		   
<div id="content">
			<div class="my_box7">


	    <div class="header_side2" >

<?php
									get_currentuserinfo();
                                    $uid = $current_user->ID;
                                   $user_status = $current_user->USER_TYPE;
								   if($user_status == 2) {
?>
		<embed wmode="opaque" src="../../wp-content/pdf/RentScanResellerAgreement_v1.pdf" width="730" height="750"></embed>
<?php } else {  ?>

		<embed wmode="opaque" src="../../wp-content/pdf/RentScanEula.pdf" width="730" height="750"></embed>
<?php } ?>
<div><a class="fancybox-media italic"  href="<?php echo '../../wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($qid)) ?>" ><img src="../../wp-content/themes/Walleto/images/appendix.jpg"></a></div>

</div>

<div class="header_side10" >
<li class="sixty"><b>Note: Must accept RentScan Equipment Rental Agreement to complete transaction.</b></li>
		   <li>
         <form id="form" action="../../wp-content/themes/Walleto/lib/my_account/paypal_ec_redirect.php" method="POST">

                   
                        <input type="hidden" name="L_PAYMENTREQUEST_0_NUMBER0" value="<?php echo $qid ?>"></input>
                        <input type="hidden" name="PAYMENTREQUEST_0_ITEMAMT" value="<?php echo $SubTotal ?>" readonly></input>
                        <input type="hidden" name="PAYMENTREQUEST_0_AMT" value="<?php echo $SubTotal ?>" readonly></input>
                        <input type="hidden" name="LOGOIMG" value=<?php echo('http://'.$_SERVER['HTTP_HOST'].preg_replace('/index.php/','/wp-content/themes/Walleto/images/logo1.jpg',$_SERVER['SCRIPT_NAME'])); ?>></input>
						<input type="hidden" name="currencyCodeType" value="USD"></input>
                        <input type="hidden" name="paymentType" value="Sale"></input>
                        <div id="loading2" style="display:none;"><img src="../../wp-content/themes/Walleto/images/loading.gif" alt="Loading" />Loading!</div>                                 
                       <input id="submit" name="submit" type="image" src="../../wp-content/themes/Walleto/images/accept.jpg" height="25"/>
                     

            </form>
			<script type="text/javascript">
(function (d) {
  d.getElementById('form').onsubmit = function () {
   d.getElementById('submit').style.display = 'none'
    d.getElementById('loading2').style.display = 'block';
  };
}(document));
</script>
			<li><div class="my_quote_this"><a href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/lib/my_account/fpdf.php/?doc='.urlencode(base64_encode($qid)).'&stat='.urlencode(base64_encode($user_status))); ?>"><img src="../../wp-content/themes/Walleto/images/download.jpg"  width="100" height="25"></a></div>
	
			
			<li><form id="form1" name="form1" method="post" action="javascript:javascript:history.go(-1)" >

			<input id="submit" name="submit" type="image" src="../../wp-content/themes/Walleto/images/reject.jpg" height="25"/>
			</form></li>
			</div>
			
			</div>
			</div>
			


			
			
		</div> <!-- end div content -->


<?php

	echo Walleto_get_users_links();
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	
}
}
?>