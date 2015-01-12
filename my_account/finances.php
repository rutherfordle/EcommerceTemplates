<?php
/***************************************************************************
*
*      Walleto - copyright (c) - sitemile.com
*      The best wordpress premium theme for having a marketplace. Sell and buy all kind of products, including downloadable goods. 
*      Have a niche marketplace website in minutes. Turn-key solution.
*
*      Coder: Andrei Dragos Saioc
*      Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
*      More info about the theme here: http://sitemile.com/products/walleto-wordpress-marketplace-theme/
*      since v1.0.1
*
*      Dedicated to my wife: Alexandra
*
***************************************************************************/

if(!function_exists('Walleto_my_account_display_finances_page'))
{
function Walleto_my_account_display_finances_page()
{
require './wp-content/themes/Walleto/connectPDO.php';
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");





//header('Location: ../../wp-login.php?action=logout');
unset($_SESSION['tempuser'], $_SESSION['renew'], $_SESSION['tempcomp'], $_SESSION['my_cart'], 
$_SESSION['editquote'], $_SESSION['renewal'], $_SESSION['edit'], $_SESSION['renew'], $_SESSION['editquote1'], $_SESSION['arrivaldate'], $_SESSION['shiptype'], $_SESSION['form_token']);
	   	$deleteQid = $_GET['qid'] ;

       if (isset($deleteQid))
       {
              if (!empty($deleteQid))
              {
              global $wpdb;
              $pd = date('Y-m-d H:i:s');
              $s = "select CUSTOMER_ID from ".$wpdb->prefix."quote_headers WHERE wp_quote_headers.id = '$deleteQid'";
              $r = $wpdb->get_results($s);       
                     foreach($r as $row1)
              {
                     $uid   = $row1->CUSTOMER_ID;
              }             
              logging($uid, 'Cancel', 'finance.php');
              
              //$s = "delete from  ".$wpdb->prefix."walleto_orders where id='$oid'";
              //$s = "update ".$wpdb->prefix."walleto_orders set paid='1', paid_on='$pd' where id='$oid'";

	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
		$s = "update ".$wpdb->prefix."quote_headers headers
		set headers.STATUS='CANCELLED', headers.LAST_UPDATE_DATE='$pd', headers.LAST_UPDATE_BY='$uid' WHERE headers.QUOTE_ID = '$deleteQid' ";
		$wpdb->query($s);
		$s = "update ".$wpdb->prefix."quote_lines line
		set line.STATUS='CANCELLED', line.LAST_UPDATE_DATE='$pd', line.LAST_UPDATE_BY='$uid' WHERE line.QUOTE_ID = '$deleteQid' ";
		$wpdb->query($s);

header( 'Location: ../my-account/my-finances/');
die;

              }
       }

unset ($_SESSION['tempuser'], $_SESSION['renew'], $_SESSION['my_cart'], $_SESSION['tempcomp']);
                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   $user_status = $current_user->USER_TYPE;
								   if($user_status == 2) {
								   $reseller = '(orders.RESELLER_ID = '.$uid.' OR orders.CUSTOMER_ID =' .$uid. ') AND orders.CUSTOMER_ID = users.ID AND ';
								   $reseller2 =  '(quote.RESELLER_ID = '.$uid.' OR  quote.CUSTOMER_ID =' .$uid. ') AND quote.CUSTOMER_ID = users.ID AND ';
								   
								   }
								   	if($user_status < 2) {
								   $reseller = ' orders.CUSTOMER_ID =' .$uid. ' AND ';
								   $reseller2 = ' quote.CUSTOMER_ID =' .$uid. ' AND ';
					
								   
								   }
			if ($user_status >= 3){					   
if(isset($_GET['res'])){
$uid = $_GET['res'];
 $reseller = ' orders.RESELLER_ID = '.$uid.' AND ';
 $reseller2 = ' quote.RESELLER_ID = '.$uid.' AND ';
}
if($_GET['res'] == 'Direct'){
 $reseller = ' orders.RESELLER_COMPANY_NAME ="Direct" AND ';
 $reseller2 = ' quote.RESELLER_COMPANY_NAME ="Direct" AND ';
}

if(isset($_GET['sales'])){
$uid = $_GET['sales'];
 $reseller = ' orders.SALESPERSON_ID = '.$uid.' AND ';
 $reseller2 = ' quote.SALESPERSON_ID = '.$uid.' AND ';
}

?>
<div id="content">

                     <div class="my_box2">
 <form id="form1" name="form1" method="post" action="<?php $current_file?>" >
 Salesperson:
  <select name="salespersonID"  onchange="window.location.href=this.value"> 
				<option value="<?php bloginfo('siteurl'); ?>/my-finances/">All Orders</option>
			
								   				<?php

	$query_result = $DBH->prepare("SELECT user.ID, umeta.meta_value FROM wp_users user, wp_usermeta umeta WHERE umeta.meta_key = 'first_name' AND umeta.user_id = user.ID AND user.USER_TYPE = 3 ORDER BY umeta.meta_value");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																
																$salesSelectID = $row2['ID'];
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
<option value="<?php echo '?sales='.$salesSelectID ?>" <?php if($salesSelectID == $_GET['sales'])
          echo ' selected="selected"';
    ?>><?php echo $salesSelectName ?></option>
<?php }


 ?>
 </select>    
								   				        
&nbsp;&nbsp;&nbsp;&nbsp;Reseller:
<select name="reseller_ID"  onchange="window.location.href=this.value"> 
				<option value="<?php bloginfo('siteurl'); ?>/my-finances/">All Orders</option>
				<option value="<?php echo '?res=Direct' ?>" <?php if ($uid == 0) echo 'selected = selected' ?>>Direct</option>
								   				<?php

	$query_result = $DBH->prepare("SELECT DISTINCT(meta.user_id), meta.meta_value, user.ID FROM wp_users user, wp_usermeta meta WHERE meta.user_id = user.ID AND meta.meta_key='company' AND user.USER_TYPE = 2 ORDER BY meta.meta_value");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$resellercomp = $row2['meta_value'];
																$aid = $row2['user_id'];
											
															
?>
<option value="<?php echo '?res='.$aid ?>" <?php if ($aid == $uid) echo 'selected = selected' ?>><?php echo $resellercomp ?></option>
<?php }


 ?>
 </select>    
                     </form>
		</div></div>						

<?php
}
       $oid = $_GET['oid'] ;
	   $qid = $_GET['qouteid'] ;
       $desc = $_GET['des'] ;
	   $frag = $_GET['frag'] ;
	   if (isset($_GET['reseller']) && (isset($_GET['assignid']))){
	   $reseller_ID = $_GET['reseller'];
	   $assign_ID = $_GET['assignid'];
	   $quoteid = $_GET['quoteid'];
	   if($reseller_ID == 0){
	   $rescompname = NULL;
	   }
																$query_result1 = $DBH->prepare("SELECT meta.meta_value FROM  wp_usermeta meta WHERE meta.meta_key='company' AND meta.user_id = '$reseller_ID'");
                                               $query_result1->execute($parms70);      
                                $data1 = $query_result1->fetchAll();    
                                
                                                                foreach($data1 as $row2){}
														$rescompname = $row2['meta_value'];
														 $reseller_ID;
															
												   if($reseller_ID == 0){
	   $rescompname = 'Direct';
	   }					
																
	   									$query_result = $DBH->prepare("UPDATE  `wp_quote_headers` SET  RESELLER_ID = :reseller_ID, RESELLER_COMPANY_NAME = :rescompname WHERE `QUOTE_ID` = :quoteid");
									$parm0[':reseller_ID'] = $reseller_ID;
									$parm0[':quoteid'] = $quoteid;
									$parm0[':rescompname'] = $rescompname;
									$query_result->execute($parm0); 
									
									$query_result = $DBH->prepare("UPDATE  `wp_walleto_order_header` SET  RESELLER_ID = :reseller_ID, RESELLER_COMPANY_NAME = :rescompname WHERE `ORDER_ID` = :assign_ID");
									$parm1[':reseller_ID'] = $reseller_ID;
									$parm1[':assign_ID'] = $assign_ID;
									$parm1[':rescompname'] = $rescompname;
									$query_result->execute($parm1); 
						}			
	   
	   
       if (!isset($desc)){
       $desc = 'DESC';
       }
       if ($desc == NULL){
       $asc = 'DESC';
       }

/*
User taxonomy:
3: Admin
2: Reseller
1: (Available for use)
0: Customer
*/
unset ($_SESSION['my_cart']);

								   

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

<div id="content">

                     <div class="my_box7">
            
<div id="tabs" class="ui-widget1">
  <ul>
    <li><a href="#fragment-1"><span>Not Paid Orders</span></a></li>
    <li><a href="#fragment-2"><span>Paid & Not Shipped Orders</span></a></li>
    <li><a href="#fragment-3"><span>Paid & Shipped Orders</span></a></li>
       <li><a href="#fragment-4"><span>Completed</span></a></li>
  </ul>
  <div id="fragment-1">


              
        
          <?php

              
                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;

                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                            
                                   $page = $_GET['pj1'];
                                   if(empty($page)) $page = 1;
                                   $total_count = 0;
                                   //---------------------------------
                                   
                                   
                                   
                            global $wpdb;       
                            $querystr2 = "SELECT quote.QUOTE_ID FROM ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users
                                                        WHERE $reseller2 users.ID = quote.CUSTOMER_ID AND usermeta.user_id = quote.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.STATUS = 'ACTIVE'";
                            
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
 
                            $querystr =   "SELECT * FROM ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users
                                                        WHERE $reseller2 users.ID = quote.CUSTOMER_ID AND usermeta.user_id = quote.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.STATUS = 'ACTIVE'                               
                                                        ORDER BY quote.QUOTE_ID $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
              
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 50;

                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed">
                            <thead class="widefat1"> <tr>
                                   <th><a class="white" href="<?php echo network_site_url('my-account/my-finances?des='.$asc.'&frag=fragment-1')  ?>">Quote#</a></th>
                               
								   <th>Order date</th>
                                   <th>Customer</th>
                                   <th>Salesperson</th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								   <th>Reseller</th>
								   <?php } ?>
                    <th>Total Amount</th>
                                   <th>Contact Details</th>
                                   <th>Edit</th>
								   <th>Cancel</th>
                                   
                            </tr>
                            </thead> <tbody>
                     
                     
                                    <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                                   unset($company, $last_name);
           
                              $quotenum = $post->QUOTE_ID;
							  $company = $post->COMPANY;
							  $first = $post->FIRST_NAME;
							  $last = $post->LAST_NAME;
											unset($salesperson, $sales_first);
                                          $doclink             = $post->PDF_FILE_NAME;
                                         $buyer                      = get_userdata($post->uid);
                                         $totalprice   = ($post->totalprice);

                                          $datemade = date("m-d-Y", strtotime($post->CREATION_DATE));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quote_number = $post->QUOTE_NUMBER;
                                          $salesperson  = $post->SALESPERSON_ID;
										  
										  $query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
        
												foreach($data as $row){
													$sales_first = $row->meta_value;
												}
											$query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
											          
												foreach($data as $row){
													$sales_last = $row->meta_value;
												}
                                        
                                          if($post->PaypalTransactionDate!=0 && $post->PaypalTransactionDate!=NULL){
                                          $transactionDate = date("m-d-Y", strtotime($post->PaypalTransactionDate));
                                          $transactionDate = str_replace('-', '/', $transactionDate);
                                          }      
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
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
											if($sales_first == NULL)
											$salesName = 'No Sales Credit';
											else
											$salesName = $sales_first.' '.$sales_last;
                                   ?>
                     
                    <tr>
                                   
                     <th class="five"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $quotenum; ?></a></th>
               
					<th class="ten"><?php echo $datemade; ?></th>
                                   <th class="twnety"><?php echo $company; ?></th>
                                   <th class="twenty"><?php echo $salesName; ?></th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								   								   <th>
								    <form id="form1" name="form1" method="post" action="<?php $current_file?>" >
								   				<select class="trunc" name="reseller_ID"  onchange="window.location.href=this.value"> 
				<option value="<?php echo '?reseller=0&assignid='.$pid.'&quoteid='.$quotenum.'pj1=' . $i.'&frag=fragment-1' ?>">Direct</option>
				
								   				<?php
$query_result1 = $DBH->prepare("SELECT quote.RESELLER_ID FROM wp_quote_headers quote WHERE quote.QUOTE_ID='$quotenum'");
                                               $query_result1->execute($parms17);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resID = $row2['RESELLER_ID'];
															}
	$query_result = $DBH->prepare("SELECT DISTINCT(meta.user_id), meta.meta_value, user.ID FROM wp_users user, wp_usermeta meta WHERE meta.user_id = user.ID AND meta.meta_key='first_name' AND user.USER_TYPE = 2");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$resellerfirst = $row2['meta_value'];
																$aid = $row2['user_id'];
																$query_result1 = $DBH->prepare("SELECT meta.meta_value FROM  wp_usermeta meta WHERE meta.meta_key='company' AND meta.user_id = '$aid
																' ORDER BY meta.meta_value");
                                               $query_result1->execute($parms16);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resellercomp = $row2['meta_value'];
															}
															
?>
<option value="<?php echo '?reseller='.$aid.'&assignid='.$pid.'&quoteid='.$quotenum.'pj1=' . $i.'&frag=fragment-1' ?>" <?php if ($aid == $resID) echo 'selected = selected' ?>><?php echo $resellercomp ?></option>
<?php }


 ?>
 </select>          

              
                     </form>
								   </th>
								   <?php } ?>
                    <th class="twenty"><?php echo $ttl; ?></th>
                                   <th class="five"><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>contact=<?php echo $post->QUOTE_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   		   <th>
		   <?php 
		   if (!isset($post->ORIGINAL_ORDER_ID)){
		   ?>
		   <form action="<?php echo bloginfo('siteurl').'/shopping-cart'; $_SESSION['editquote'] = 1; ?>">
					<input type="hidden" name="edit" value="<?php echo $quotenum; unset($_SESSION['my_cart'])?>"  />
					<input type="submit" value="Revise Quote"  /></form>
					<?php } else { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';} ?> 
					</th><th>
								   <div><form id="form1" name="form1" method="post" action="<?php echo network_site_url('my-account/my-finances?qid='). $quotenum;?>" 
                                   onclick="return confirm('This is irreversible. Are you sure?');">
                                   <input type="hidden" name="act" value="run">
                                   <input id="btnDelete" name="btnDelete" type="image" src="../../wp-content/themes/Walleto/images/cancel.jpg" height="25"/>
                                   </form></th>
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
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj1=' .$start_me.'&des='.$desc.'&frag=fragment-1"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj1='.$previous_pg.'&des='.$desc.'&frag=fragment-1"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {
                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/my-finances?').'pj1=' . $i.'&frag=fragment-1">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj1=' . $next_pg.'&des='.$desc.'&frag=fragment-1"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj1=' . $end_me.'&des='.$desc.'&frag=fragment-1">>></a>';
                                                 ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
                     <?php _e('There are no items yet','Walleto'); ?>
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   
                                   ?>
                
        
        
       
       
       
       
        
        
   
       

  </div>
  <div id="fragment-2" >
         
        
     
          <?php

                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   
                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                            
                                   $page = $_GET['pj2'];
                                   if(empty($page)) $page = 1;
                                   $total_count = 0;
                                   //---------------------------------
                                   
                                   
                                   
                            global $wpdb;       
                            $querystr2 = "SELECT *,orders.CREATION_DATE, orders.SALESPERSON_ID, quote.QUOTE_ID,  orders.ORDER_ID, orders.EXPECTED_ARRIVAL_DATE, orders.PROCESS_STATUS FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users
                                                        WHERE $reseller users.ID = orders.CUSTOMER_ID AND usermeta.user_id = orders.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.QUOTE_ID = orders.QUOTE_ID AND orders.SHIPPED_STATUS='NOT_SHIPPED' AND orders.PAID='1' AND orders.STATUS = 'PAID' AND ((orders.PROCESS_STATUS = 'WAITING_FOR_SYNC') OR (orders.PROCESS_STATUS = 'WAITING_FOR_SHIPMENT'))  ";
                            
                            
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
                     
                                   
                                                        $querystr =   "SELECT *,orders.CREATION_DATE, orders.TOTAL_AMOUNT, orders.SALESPERSON_ID, orders.PO_FILE_NAME, orders.EXPECTED_ARRIVAL_DATE, quote.QUOTE_ID,  orders.ORDER_ID, orders.PROCESS_STATUS FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users
                                                        WHERE $reseller users.ID = orders.CUSTOMER_ID AND usermeta.user_id = orders.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.QUOTE_ID = orders.QUOTE_ID AND orders.SHIPPED_STATUS='NOT_SHIPPED' AND orders.PAID='1' AND orders.STATUS = 'PAID' AND ((orders.PROCESS_STATUS = 'WAITING_FOR_SYNC') OR (orders.PROCESS_STATUS = 'WAITING_FOR_SHIPMENT'))                              
                                                        ORDER BY orders.ORDER_ID $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
              
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;
                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed">
                                   <thead class="widefat1"> <tr>
                                   <th><a class="white" href="<?php echo network_site_url('my-account/my-finances?des='.$asc.'&frag=fragment-2')  ?>">Order#</a></th>
                    <th class="five">Order Date</th>
                                   <th>Future Ship Date</th>
								   <th>Quote#</th>
                                   <th>Customer</th>
                                   <th>Salesperson</th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								   <th>Reseller</th>
								   <?php } ?>
                    <th>Total Amount</th>
                                   <th>Contact Details</th>
                    
                                   <th>Paid Date</th>

                                   
                            </tr>
                            </thead> <tbody>
                     
                     
                                    <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                                   unset($company, $last_name, $salesperson, $sales_first);
              $oid = $post->id;    
          
                             $quotenum = $post->QUOTE_ID;
                                          $doclink             = $post->PO_FILE_NAME;
                                         $buyer                      = get_userdata($post->uid);
                                         $totalprice   = ($post->totalprice);
											
                                          $expectedArrivalDate = date("m-d-Y", strtotime($post->EXPECTED_ARRIVAL_DATE));
                                          $expectedArrivalDate = str_replace('-', '/', $expectedArrivalDate);
										  if($expectedArrivalDate == '12/31/1969')
										  $expectedArrivalDate = 'Immediately';
										  
										  $datemade = date("m-d-Y", strtotime($post->CREATION_DATE));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quote_number = $post->QUOTE_ID;
                                          $salesperson  = $post->SALESPERSON_ID;
										  if($salesperson == 0){
										  $salesperson = NULL;
										  }
										
										  	$query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
        
												foreach($data as $row){
													$sales_first = $row->meta_value;
												}
											$query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
											          
												foreach($data as $row){
													$sales_last = $row->meta_value;
												}
                                          
                                          if($post->TRANSACTION_DATE!=0 && $post->TRANSACTION_DATE!=NULL){
                                          $transactionDate = date("m-d-Y", strtotime($post->TRANSACTION_DATE));
                                          $transactionDate = str_replace('-', '/', $transactionDate);
                                          }      
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
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
                                          $pid=$post->ORDER_ID; 
									
										  
											if($sales_first == NULL)
											$salesName = 'No Sales Credit';
											else
											$salesName = $sales_first.' '.$sales_last;
                                   ?>
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
xmlhttp.open("GET","../wp-content/themes/Walleto/lib/getaddress.php?w="+str,true);
xmlhttp.send();
}
					</script> 
                    <tr>
                     <th class = "five"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $post->ORDER_ID; ?></a></th>
                    <th class = "ten"><?php echo $datemade; ?></th>
					<th class = "ten"><?php echo $expectedArrivalDate; ?></th>
                    <th class = "ten"><?php echo $quote_number; ?></th>
                                   <th class = "twenty"><?php echo $post->COMPANY; ?></th>
                                   <th class = "twenty"><?php echo $salesName; ?></th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								   <th>
								    <form id="form1" name="form1" method="post" action="<?php $current_file?>" >
								   				<select class="trunc" name="reseller_ID"  onchange="window.location.href=this.value"> 
				<option value="<?php echo '?reseller=0&assignid='.$pid.'&quoteid='.$quotenum.'pj1=' . $i.'&frag=fragment-2' ?>">Direct</option>
								   				<?php
$query_result1 = $DBH->prepare("SELECT ord.RESELLER_ID FROM wp_walleto_order_header ord WHERE ord.ORDER_ID='$pid'");
                                               $query_result1->execute($parms17);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resID = $row2['RESELLER_ID'];
															}
	$query_result = $DBH->prepare("SELECT DISTINCT(meta.user_id), meta.meta_value, user.ID FROM wp_users user, wp_usermeta meta WHERE meta.user_id = user.ID AND meta.meta_key='first_name' AND user.USER_TYPE = 2");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$resellerfirst = $row2['meta_value'];
																$aid = $row2['user_id'];
																$query_result1 = $DBH->prepare("SELECT meta.meta_value FROM  wp_usermeta meta WHERE meta.meta_key='company' AND meta.user_id = '$aid
																' ORDER BY meta.meta_value");
                                               $query_result1->execute($parms16);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resellercomp = $row2['meta_value'];
															}
															
?>
<option value="<?php echo '?reseller='.$aid.'&assignid='.$pid.'&quoteid='.$quote_number.'pj4=' . $i.'&frag=fragment-2' ?>" <?php if ($aid == $resID) echo 'selected = selected' ?>><?php echo $resellercomp ?></option>
<?php }


 ?>
 </select>   
 

              
                     </form>
								   </th>
								   <?php } if ($post->PO_FILE_NAME != NULL) {?>
                    <th class = "fifteen"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc1='.urlencode(base64_encode($doclink)).'&qid1='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $ttl ?></a></th>
					<?php } else { ?>
					<th class = "fifteen"><?php echo $ttl; ?></th>
					<?php } ?>
                                   <th class = "ten"><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>contact1=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   <form id="form1" name="form1" method="post" action="javascript:javascript:history.go(-1)" >

              
                     </form>
                     </div>
                                   <th><?php echo $transactionDate ?></th>   

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
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj2=' .$start_me.'&des='.$desc.'&frag=fragment-2"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj2='.$previous_pg.'&des='.$desc.'&frag=fragment-2"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="'.network_site_url('my-account/my-finances?').'pj2=' . $i.'&frag=fragment-2">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/my-finances?').'pj2=' . $i.'&frag=fragment-2">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)

              echo '<a href="'.network_site_url('my-account/my-finances?').'pj2=' . $next_pg.'&des='.$desc.'&frag=fragment-2"> '.__('Next','Walleto').' </a>';                                    
                        
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj2=' . $end_me.'&des='.$desc.'&frag=fragment-2">>></a>';
                                                 
                            
                                   ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
                     <?php _e('There are no items yet','Walleto'); ?>
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   
                                   ?>
                
        
        
       
       
       
        
       
       
       

                </div>
  <div id="fragment-3">

       
          <?php
		
                                   global $current_user;
                                   get_currentuserinfo();
                                   $uid = $current_user->ID;
                                   
                                   global $wp_query;
                                   $query_vars = $wp_query->query_vars;
                                   $nrpostsPage = 50;                         
                                   $total_count = 0;
                                   $page = $_GET['pj3'];
                                   if(empty($page)) $page = 1;
                                   
                                   //---------------------------------
                                   
                                   
                                   
                            global $wpdb;       
                            $querystr2 = "SELECT MAX(DATEDIFF(DATE_FORMAT(orderlines.RETURN_DATE, '%Y-%m-%d'), DATE_FORMAT(now(),'%Y-%m-%d'))) AS REMAINING_DAYS, orderlines.DELIVERED_DATE, MAX(orderlines.RETURN_DATE) AS RETURN_DATE, orders.CURRENT_ORDER_ID, orders.COMPANY, orders.TOTAL_AMOUNT, orders.ORDER_ID, orders.PROCESS_STATUS, quote.QUOTE_ID, orders.SALESPERSON_ID, orders.ORACLE_RMA_NUMBER FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users,  wp_walleto_order_lines orderlines
                                                        WHERE orders.ORDER_ID = orderlines.ORDER_ID AND $reseller users.ID = orders.CUSTOMER_ID AND usermeta.user_id = orders.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.QUOTE_ID = orders.QUOTE_ID AND orders.PAID='1' AND orders.STATUS = 'PAID' AND ((orders.PROCESS_STATUS = 'WAITING_FOR_RETURN') || (orders.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_SYNC') || (orders.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL'))   
                                                        GROUP BY orders.ORDER_ID ORDER BY REMAINING_DAYS, orders.ORDER_ID  ";
                            $r = $wpdb->get_results($querystr2);      
                            foreach($r as $row)
                                   {
                                          $total_count=$total_count+1;
                                   }
                            $my_page = $page;    
                            $pages_curent = $page;
							if($desc == '')
							$desc1 = 'DESC';
							else
							$desc1 = '';
                     //-----------------------------------------------------------------------           
                            
                            $totalPages = ($total_count > 0 ? ceil($total_count / $nrpostsPage) : 0);
                            $pagess = $totalPages;
                                   
                                                        $querystr =   "SELECT MAX(DATEDIFF(DATE_FORMAT(orderlines.RETURN_DATE, '%Y-%m-%d'), DATE_FORMAT(now(),'%Y-%m-%d'))) AS REMAINING_DAYS, orderlines.DELIVERED_DATE, MAX(orderlines.RETURN_DATE) AS RETURN_DATE, orders.CURRENT_ORDER_ID, orders.COMPANY, orders.TOTAL_AMOUNT, orders.ORDER_ID, orders.PROCESS_STATUS, quote.QUOTE_ID, orders.SALESPERSON_ID, orders.ORACLE_RMA_NUMBER FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users,  wp_walleto_order_lines orderlines
                                                        WHERE orders.ORDER_ID = orderlines.ORDER_ID AND $reseller users.ID = orders.CUSTOMER_ID AND usermeta.user_id = orders.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.QUOTE_ID = orders.QUOTE_ID AND orders.PAID='1' AND orders.STATUS = 'PAID' AND ((orders.PROCESS_STATUS = 'WAITING_FOR_RETURN') || (orders.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_SYNC') || (orders.PROCESS_STATUS = 'WAITING_FOR_DELIVERY_DETAIL'))      
                                                        GROUP BY orders.ORDER_ID ORDER BY REMAINING_DAYS, orders.ORDER_ID  $desc1 LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
                            
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;

                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed">
                                   <thead class="widefat1"> <tr>
                                   <th>Order#</th>
                                   <th>RMA#</th>
                                   
                                   <th>Customer</th>
                                   <th>Salesperson</th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								   <th>Reseller</th>
								   <?php } ?>
                    <th>Total Amount</th>
                                   <th>Contact Details</th>
                    
                                   <th>Order Details</th>
								   <th>Arrival Date</th>
                                   <th>Scheduled Return Date</th>
                                   <th><a class="white" href="<?php echo network_site_url('my-account/my-finances?des='.$asc.'&frag=fragment-3')  ?>">Days Remaining</a></th>
								   <th>Renewal</th>

                                   
                            </tr>
                            </thead> <tbody>
                     
                     
                                    <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                                   unset($company, $last_name, $salesperson, $sales_first);
              $oid = $post->ORDER_ID;                        

                             $quotenum = $post->QUOTE_ID;
							 

												
									$returndate = 1;
								$deliveredDate1 = $post->DELIVERED_DATE;
                                   if(($post->RETURN_DATE=='0000-00-00 00:00:00') || ($post->RETURN_DATE==NULL)){
								   $returndate = 0;
								   }
								   
								   if(($post->DELIVERED_DATE=='0000-00-00 00:00:00') || ($post->DELIVERED_DATE==NULL)){
								   $deliveredDate1 = 0;
								   }
								  
								  
								  $returndate2 = $post->RETURN_DATE;
								  										  
										  $returnDate1 = date("m-d-Y", strtotime($returndate2));
                                          $returnDate1 = str_replace('-', '/', $returnDate1);
										  if(($post->RETURN_DATE=='0000-00-00 00:00:00') || ($post->RETURN_DATE==NULL)){
										  $returnDate1 = ' ';
										  }
								          $timeToEnd = $post->REMAINING_DAYS;
											if($returndate == 0)
											$timeToEnd = ' ';
											else
											$timeToEnd = intval($timeToEnd);

                                         $totalprice   = ($post->totalprice);
                                          $rma                 = $post->ORACLE_RMA_NUMBER;
                                          $datemade = date("m-d-Y", strtotime($post->datemade));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quote_number = $post->QUOTE_ID;
                                          $salesperson  = $post->SALESPERSON_ID;
										  
										  $query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
        
												foreach($data as $row){
													$sales_first = $row->meta_value;
												}
											$query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
											          
												foreach($data as $row){
													$sales_last = $row->meta_value;
												}

                                          $contact             = $post->meta_value.' '.$last_name;
                                       
										
                                          $deliveredDate = date("m-d-Y", strtotime($deliveredDate1));
                                          $deliveredDate = str_replace('-', '/', $deliveredDate);
										   if($deliveredDate1 == NULL){
										  $deliveredDate = ' ';
										  }

                                          $today = strtotime(date('Y-m-d'));
                                          $expireDay = strtotime($post->RETURN_DATE);

											if($timeToEnd < 0 && $post->PROCESS_STATUS != 'RETURNED'){
											$timeToEnd = abs($timeToEnd). ' days overdue';
                                          
                                          }
										  else if($timeToEnd == 0 && $post->PROCESS_STATUS != 'RETURNED'){
											$timeToEnd = abs($timeToEnd). ' ';
                                          
                                          }
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_SHIPMENT')
                                                 $status = 'Waiting for Shipment';
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_RETURN')
                                                 $status = 'Shipped';
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
											    $pid = $post->ORDER_ID;  
									if(($post->DELIVERED_DATE=='0000-00-00 00:00:00') || ($post->DELIVERED_DATE==NULL)){
										$timeToEnd = ' ';
								   }	
								   if($sales_first == NULL)
											$salesName = 'No Sales Credit';
											else
											$salesName = $sales_first.' '.$sales_last;
                                   ?>
                     
                    <tr>
                     <th class="five"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $post->ORDER_ID; ?></a></th>
                    <th class="ten"><?php echo $rma; ?></th>
                    
                                   <th class="fifteen"><?php echo $post->COMPANY; ?></th>
                                   <th class="fifteen"><?php echo $salesName; ?></th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								    <th>
								    <form id="form1" name="form1" method="post" action="<?php $current_file?>" >
								   				<select class="trunc" name="reseller_ID"  onchange="window.location.href=this.value"> 
				<option value="<?php echo '?reseller=0&assignid='.$pid.'&quoteid='.$quotenum.'pj1=' . $i.'&frag=fragment-3' ?>">Direct</option>
								   				<?php
$query_result1 = $DBH->prepare("SELECT ord.RESELLER_ID FROM wp_walleto_order_header ord WHERE ord.ORDER_ID='$pid'");
                                               $query_result1->execute($parms17);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resID = $row2['RESELLER_ID'];
															}
	$query_result = $DBH->prepare("SELECT DISTINCT(meta.user_id), meta.meta_value, user.ID FROM wp_users user, wp_usermeta meta WHERE meta.user_id = user.ID AND meta.meta_key='first_name' AND user.USER_TYPE = 2");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$resellerfirst = $row2['meta_value'];
																$aid = $row2['user_id'];
																$query_result1 = $DBH->prepare("SELECT meta.meta_value FROM  wp_usermeta meta WHERE meta.meta_key='company' AND meta.user_id = '$aid
																' ORDER BY meta.meta_value");
                                               $query_result1->execute($parms16);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resellercomp = $row2['meta_value'];
															}
															
?>
<option value="<?php echo '?reseller='.$aid.'&assignid='.$pid.'&quoteid='.$quote_number.'pj4=' . $i.'&frag=fragment-3' ?>" <?php if ($aid == $resID) echo 'selected = selected' ?>><?php echo $resellercomp ?></option>
<?php }


 ?>
 </select>          

              
                     </form>
								   </th>
								   <?php } if ($post->PO_FILE_NAME != NULL) {?>
                    <th class = "fifteen"><a class="fancybox-media italic"  href="<?php echo '../../wp-content/pdf/po_uploads/'.$post->PO_FILE_NAME; ?>" ><?php echo $ttl ?></a></th>
					<?php } else { ?>
					<th class = "fifteen"><?php echo $ttl; ?></th>
					<?php } ?>
                                   <th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>contact1=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   
                                   <th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>orders=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   <th class="ten"><?php echo $deliveredDate ?></th>
								   <th class="ten"><?php echo $returnDate1 ?></th>
                    <th><?php echo $timeToEnd; ?></th>
					<?php if(($timeToEnd != ' ') && $post->REMAINING_DAYS <= 15 && $post->PROCESS_STATUS != 'RETURNED') { ?>
					<th><form action="<?php echo bloginfo('siteurl').'/shopping-cart'; $_SESSION['renewal'] = 1; ?>">
					<input type="hidden" name="renew" value="<?php echo $oid; ?>"  />
					<input type="submit" value="Renew"  /></form></th>
					<?php } else if($post->CURRENT_ORDER_ID != 0){?>
					<th><?php echo 'Renewed';?></th>
					<?php } else { ?>
					<th></th>
					<?php } ?>
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
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj3=' .$start_me.'&des='.$desc.'&frag=fragment-3"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj3='.$previous_pg.'&des='.$desc.'&frag=fragment-3"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/my-finances?').'pj3=' . $i.'&frag=fragment-3">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj3=' . $next_pg.'&des='.$desc.'&frag=fragment-3"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj3=' . $end_me.'&des='.$desc.'&frag=fragment-3">>></a>';
                                                 ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
                     <?php _e('There are no items yet','Walleto'); ?>
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   
                                   ?>
                
        
        
         

                              </div>
  <div id="fragment-4">

         
       
          <?php
		
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
                            $querystr2 = "SELECT *, orders.CREATION_DATE, quote.QUOTE_ID, orders.ORDER_ID, orders.PROCESS_STATUS, orders.ORACLE_RMA_NUMBER FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users
                                                        WHERE $reseller users.ID = orders.CUSTOMER_ID AND usermeta.user_id = orders.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.QUOTE_ID = orders.QUOTE_ID  
														AND (orders.PROCESS_STATUS = 'RETURNED' OR orders.PROCESS_STATUS = 'RENEWED' OR orders.STATUS = 'CANCELLED' OR orders.PROCESS_STATUS = 'WAITING_FOR_RENEWAL_SYNC' OR orders.PROCESS_STATUS = 'WAITING_FOR_ORACLE_RENEWAL') ";
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
                     
                                   
                                                        $querystr =   "SELECT *, orders.CREATION_DATE, quote.QUOTE_ID, orders.ORDER_ID, orders.PROCESS_STATUS, orders.ORACLE_RMA_NUMBER FROM ".$wpdb->prefix."walleto_order_header orders,  ".$wpdb->prefix."quote_headers quote,  ".$wpdb->prefix."usermeta usermeta,  ".$wpdb->prefix."users users
                                                        WHERE $reseller users.ID = orders.CUSTOMER_ID AND usermeta.user_id = orders.CUSTOMER_ID AND usermeta.meta_key = 'first_name' AND quote.QUOTE_ID = orders.QUOTE_ID  
														AND (orders.PROCESS_STATUS = 'RETURNED' OR orders.PROCESS_STATUS = 'RENEWED' OR orders.STATUS = 'CANCELLED' OR orders.PROCESS_STATUS = 'WAITING_FOR_RENEWAL_SYNC' OR orders.PROCESS_STATUS = 'WAITING_FOR_ORACLE_RENEWAL')                       
                                                        ORDER BY orders.ORDER_ID $desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;  
                            
                            $pageposts = $wpdb->get_results($querystr, OBJECT);
                            
                            $posts_per = 7;
                            ?>
                                   
                                   <?php $i = 0; if ($pageposts): ?>
                     
                    <table class="widefat post fixed1">
                                   <thead class="widefat1"> <tr>
                                   <th><a class="white" href="<?php echo network_site_url('my-account/my-finances?des='.$asc.'&frag=fragment-4')  ?>">Order#</a></th>

                    <th>Order Date</th>
                                   <th>RMA#</th>
                                   <th>Quote#</th>
                                   <th>Customer</th>
                                   <th>Salesperson</th>
								   <?php if ($current_user->USER_TYPE >= 3){ ?>
								   <th>Reseller</th>
								   <?php } ?>
                    <th>Total Amount</th>
                                   <th>Contact Details</th>
                    <th>Order Details</th>
					<th>Status</th>
                                   <th>Received Date</th>

                                   
                            </tr>
                            </thead> <tbody>
                     
                     
                                    <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     <?php
                                   unset($company, $last_name, $salesperson, $sales_first);
                                   $oid = $post->ORDER_ID;                         
              $s = "select user.meta_value from ".$wpdb->prefix."walleto_orders orders, ".$wpdb->prefix."usermeta user WHERE orders.id = $oid AND user.meta_key = 'last_name' AND user.user_id = orders.uid";
              $r = $wpdb->get_results($s);       
                            foreach($r as $row1)
                                   {
              $last_name    = $row1->meta_value;
              }
              $s = "select user.meta_value from ".$wpdb->prefix."walleto_orders orders, ".$wpdb->prefix."usermeta user WHERE orders.id = $oid AND user.meta_key = 'company' AND user.user_id = orders.uid";
              $r = $wpdb->get_results($s);       
                            foreach($r as $row1)
                                   {
              $company      = $row1->meta_value;
              }                          
                              $quotenum = $post->QUOTE_ID;
							  $oid = $post->ORDER_ID;  
							  
							  $query_result = "SELECT MAX(RECEIVED_DATE) AS MAXDATE FROM wp_walleto_order_lines
							  WHERE ORDER_ID = $oid";
							 $data = $wpdb->get_results($query_result); 
       
												foreach($data as $row){
												
									$receivedate = 1;			
                                   if($row->MAXDATE==0 || $row->MAXDATE==NULL){
								   $receivedate = 0;
									}
									$receivedate2 = $row->MAXDATE;
								 $receivedate2 = date("m-d-Y", strtotime($receivedate2));
                                   $receivedate2 = str_replace('-', '/', $receivedate2);
							       if($row->MAXDATE==0 || $row->MAXDATE==NULL){
								   $receivedate2 = '';
								   }
								  }
									
							  
                                          $doclink             = $post->PDF_FILE_NAME;
                                         $buyer                      = get_userdata($post->uid);
                                         $totalprice   = ($post->totalprice);
                                          $rma                 = $post->ORACLE_RMA_NUMBER;
                                          $datemade = date("m-d-Y", strtotime($post->CREATION_DATE));
                                          $datemade = str_replace('-', '/', $datemade);
                                          $shp                 = Walleto_get_show_price($post->FREIGHT_AMOUNT);                                       
                                          $ttl                 = Walleto_get_show_price( $post->TOTAL_AMOUNT);
                                          $quote_number = $post->QUOTE_NUMBER;
                                          $salesperson  = $post->SALESPERSON_ID;

									 $query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'first_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
        
												foreach($data as $row1){
													$sales_first = $row1->meta_value;
												}
											$query_result = "SELECT meta_value FROM wp_usermeta WHERE meta_key = 'last_name' AND user_id = '$salesperson'";
											$data = $wpdb->get_results($query_result); 
											          
												foreach($data as $row1){
													$sales_last = $row1->meta_value;
												}
										  
                                          $contact             = $post->meta_value.' '.$last_name;
                                          

 
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_SHIPMENT')
                                                 $status = 'Waiting for Shipment';
                                          if($post->PROCESS_STATUS == 'WAITING_FOR_RETURN')
                                                 $status = '';
						if($post->STATUS == 'CANCELLED')
                                                 $status = 'Canceled';
						if($post->PROCESS_STATUS == 'RENEWED')
                                                 $status = 'Renewed';
						if(($post->PROCESS_STATUS == 'WAITING_FOR_RENEWAL')||($post->PROCESS_STATUS == 'WAITING_FOR_RENEWAL_SYNC') || ($post->PROCESS_STATUS == 'WAITING_FOR_ORACLE_RENEWAL'))
                                                 $status = 'Waiting for Renewal';
                                          if($post->PROCESS_STATUS == 'RETURNED'){
                                                 $status = 'Returned';
                                                 $timeToEnd = '';
                                                 }
												
                                          if($post->RECEIVED_DATE!=0 && $post->RECEIVED_DATE!=NULL){
                                          $receiveDate = date("m-d-Y", strtotime($post->RECEIVED_DATE));
                                          $receiveDate = str_replace('-', '/', $receiveDate);
                                          } 
                                           $pid = $oid;   
											if($sales_first == NULL)
											$salesName = 'No Sales Credit';
											else
											$salesName = $sales_first.' '.$sales_last;
                                    ?>
                     
                    <tr>
                     <th class="five"><a class="fancybox-media italic"  href="<?php echo (get_bloginfo('siteurl').'/wp-content/themes/Walleto/decrypt.php/?doc='.urlencode(base64_encode($quotenum))) ?>" ><?php echo $oid; ?></a></th>
                    <th class="ten"><?php echo $datemade; ?></th>
                                   <th class="ten"><?php echo $rma; ?></th>
                    <th class="ten"><?php echo $quotenum; ?></th>
                                   <th class="fifteen"><?php echo $post->COMPANY; ?></th>
                                    <th class="fifteen"><?php echo $salesName; ?></th>
									<?php if ($current_user->USER_TYPE >= 3){ ?>
																	    <th>
								    <form id="form1" name="form1" method="post" action="<?php bloginfo('siteurl')?>" >
								   				<select class="trunc" name="reseller_ID"  onchange="window.location.href=this.value"> 
				<option value="<?php echo '?reseller=0&assignid='.$pid.'&quoteid='.$quotenum.'pj1=' . $i.'&frag=fragment-4' ?>">Direct</option>
								   				<?php
$query_result1 = $DBH->prepare("SELECT ord.RESELLER_ID FROM wp_walleto_order_header ord WHERE ord.ORDER_ID='$pid'");
                                               $query_result1->execute($parms17);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resID = $row2['RESELLER_ID'];
															}
	$query_result = $DBH->prepare("SELECT DISTINCT(meta.user_id), meta.meta_value, user.ID FROM wp_users user, wp_usermeta meta WHERE meta.user_id = user.ID AND meta.meta_key='first_name' AND user.USER_TYPE = 2");
                                               $query_result->execute($parms15);      
                                $data = $query_result->fetchAll();        
                        
                                                                foreach($data as $row2){
																$resellerfirst = $row2['meta_value'];
																$aid = $row2['user_id'];
																		$query_result1 = $DBH->prepare("SELECT meta.meta_value FROM  wp_usermeta meta WHERE meta.meta_key='company' AND meta.user_id = '$aid
																' ORDER BY meta.meta_value");
                                               $query_result1->execute($parms16);      
                                $data1 = $query_result1->fetchAll();        
                        
                                                                foreach($data1 as $row2){
																$resellercomp = $row2['meta_value'];
															}
															
?>
<option value="<?php echo '?reseller='.$aid.'&assignid='.$pid.'&quoteid='.$quote_number.'pj4=' . $i.'&frag=fragment-4' ?>" <?php if ($aid == $resID) echo 'selected = selected' ?>><?php echo $resellercomp ?></option>
<?php }


 ?>
 </select>          

              
                     </form>
								   </th>
								   <?php } if ($post->PO_FILE_NAME != NULL) {?>
                    <th class = "fifteen"><a class="fancybox-media italic"  href="<?php echo '../../wp-content/pdf/po_uploads/'.$post->PO_FILE_NAME; ?>" ><?php echo $ttl ?></a></th>
					<?php } else { ?>
					<th class = "fifteen"><?php echo $ttl; ?></th>
					<?php } ?>
                                   <th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>contact1=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
                                   <th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>orders=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Details</a></th>
<?php
if($status == 'Renewed'){
?>
<th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>renewal=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Renewed-<?php echo $post->ORIGINAL_ORDER_ID ?></a></th>

<?php } 

else if($status == 'Waiting for renewal'){
?>
<th><a href="<?php echo network_site_url('my-account/reviewsfeedback?') ?>renewal=<?php echo $post->ORDER_ID; ?>" class="fancybox-media italic">Waiting for renewal</a></th>

<?php } 
else{
?>
				<th class="ten"><?php echo $status ?></th>
<?php } ?>
                            <th class="ten"><?php echo $receivedate2 ?></th>

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
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj4=' .$start_me.'&des='.$desc.'&frag=fragment-4"><<</a>';             
                     echo '<a href="'.network_site_url('my-account/my-finances?').'pj4='.$previous_pg.'&des='.$desc.'&frag=fragment-4"> '.__('Previous ','Walleto').'</a>';
              
              }
              //------------------------
              //echo $start." ".$end;
              for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

                     if ($i == $pages_curent && $i != $end) {
                            echo '<a class="activee" href="#">' .$i. '..</a>';
                     } else {
                     
                            echo '<a href="'.network_site_url('my-account/my-finances?').'pj4=' . $i.'&frag=fragment-4">'.$i.'</a>';
                            
                     }
              }
              
              //----------------------
              if($page < $totalPages)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj4=' . $next_pg.'&des='.$desc.'&frag=fragment-4"> '.__('Next','Walleto').' </a>';                                        
                                          
              if($totalPages > $my_page)
              echo '<a href="'.network_site_url('my-account/my-finances?').'pj4=' . $end_me.'&des='.$desc.'&frag=fragment-4">>></a>';
                                                 
                            
                                   ?>
                     </div>
                     
                     
                     
                     
                     <?php else: ?>
                     
                     <?php _e('There are no items yet','Walleto'); ?>
                     
                     <?php endif; ?>

                                   
                                   
                                   <?php
                                   
                                   wp_reset_query();
                                   
                                   ?>
                
        
        
         
         
          </div>
                
       


<script>
$( "#tabs" ).tabs();

</script>

</body>
</html>

      
</div>

                     </div>
                     </div> 

<?php

       echo Walleto_get_users_links();
       
       $output = ob_get_contents();
       ob_end_clean();
       return $output;
  header('Location: ./wp-content/themes/Walleto/encrypt.php');
die;     


}

}
?>

