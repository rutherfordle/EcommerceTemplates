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


if(!function_exists('Walleto_my_account_display_home_page'))
{
function Walleto_my_account_display_home_page()
{

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");

unset($_SESSION['tempuser'], $_SESSION['renew'], $_SESSION['tempcomp'], $_SESSION['my_cart'], $_SESSION['editquote'], $_SESSION['renewal'], 
$_SESSION['edit'], $_SESSION['renew'], $_SESSION['shiptype'], $_SESSION['editquote1'], $_SESSION['arrivaldate'], $_SESSION['form_token'], $_SESSION['overnight']);
global $current_user;
if($current_user->DISCREPANT_FLAG == 1){
echo '<font size="2" color="red"><b>&nbsp;* Your Account is locked.  To unlock your account, please contact Customer Service at 888-425-8228 Option 5.</b></font><br/>';
}
	$qid = $_GET['qid'] ;
	if (isset($qid))
	{
		if (!empty($qid))
		{
		global $wpdb;
		$pd = date('Y-m-d H:i:s');
	
		logging($uid, 'Cancel', 'my_account.php');
		
		//$s = "delete from  ".$wpdb->prefix."walleto_orders where id='$oid'";
		//$s = "update ".$wpdb->prefix."walleto_orders set paid='1', paid_on='$pd' where id='$oid'";
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
		$s = "update ".$wpdb->prefix."quote_headers headers
		set headers.STATUS='CANCELLED', headers.LAST_UPDATE_DATE='$pd', headers.LAST_UPDATE_BY='$uid' WHERE headers.QUOTE_ID = '$qid' ";
		$wpdb->query($s);
		$s = "update ".$wpdb->prefix."quote_lines line
		set line.STATUS='CANCELLED', line.LAST_UPDATE_DATE='$pd', line.LAST_UPDATE_BY='$uid' WHERE line.QUOTE_ID = '$qid' ";
		$wpdb->query($s);
logging($uid, 'Cancel', 'my_account.php');

header( 'Location: ../my-account/');
die;

		}
	}
	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;

?>	

<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<div id="content">
			<div class="my_box6">
            
            	<div class="box_title my_account_title"><?php _e("My Quotes",'Walleto'); ?></div>
                <div class="box_content">   
                <?php
                 
			global $wpdb;
			

					
					global $wp_query;
					$query_vars = $wp_query->query_vars;
					$nrpostsPage = 8;				
					$total_count = 0;
					$page = $_GET['pj1'];
					if(empty($page)) $page = 1;
					
					//---------------------------------
					
	
				 $querystr2 = "select quote.ORIGINAL_ORDER_ID, quote.QUOTE_ID, quote.COMPANY, quote.CREATION_DATE, quote.TOTAL_AMOUNT from ".$wpdb->prefix."quote_headers quote where quote.CUSTOMER_ID='$uid' AND quote.STATUS='ACTIVE' ";
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
	
		//	$s = "select * from ".$wpdb->prefix."walleto_orders where uid='$uid' AND paid='0' order by id desc limit 3";
			$s = "select quote.ORIGINAL_ORDER_ID, quote.QUOTE_ID, quote.COMPANY, quote.CREATION_DATE, quote.TOTAL_AMOUNT from ".$wpdb->prefix."quote_headers quote where quote.CUSTOMER_ID='$uid' AND quote.STATUS='ACTIVE' order by quote.QUOTE_ID desc LIMIT ".($nrpostsPage * ($page - 1) ).",". $nrpostsPage ;
			//      select wp_walleto_orders.uid,wp_quote_detail.QUOTE_NUMBER,wp_quote_detail.PDF_FILE_NAME,wp_quote_detail.PRODUCTS_AMOUNT,wp_quote_detail.TAX_AMOUNT,wp_quote_detail.ProductName from wp_walleto_orders left join wp_quote_detail on wp_walleto_orders.QUOTE_ID = wp_quote_detail.id where wp_walleto_orders.uid=14 AND wp_walleto_orders.paid='0' order by wp_walleto_orders.id desc limit 3
			
			$r = $wpdb->get_results($s);
			
			if(count($r) > 0)
			{
				//echo $uid;
				//exit ("Has Some rows")

		   				

				?> 
			
			
            <div class="header_side" >
                <li class="thirtyone" align ="left"><div class="my_quote3" ><?php echo __('Quote Detail','Walleto'); ?></div></li>
				<li class = "ten" align ="center"><div class="my_quote3"><?php echo __('Quote Date','Walleto'); ?></div></li>
                <li class = "fifteen" align ="center"><div class="my_quote3"><?php echo __('Price','Walleto'); ?></div></li>
                <li class = "sixteen" align ="center"><div class="my_quote4"><?php echo __('Checkout','Walleto'); ?></div></li></br>
           <?php				
	
				foreach($r as $row)
				{
					walleto_display_unpaid_Quote_for_buyer($row);
					
				}
			
			}
			
			else
			{
				_e('There are no outstanding Quotes.','Walleto');	
			}
			
					$batch = 1000000000; //ceil($page / $nrpostsPage );
		$end = $batch * $nrpostsPage;


		if ($end > $pagess) {
			$end = $pagess;
		}
		$start = $end - $nrpostsPage + 1;
		
		if($start < 1) $start = 1;
		
		$links = '';
	
		
		$raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
		
		$start 		= $raport * $batch + 1; 
		$end		= $start + $batch - 1;
		$end_me 	= $end + 1;
		$start_me 	= $start - 1;
		
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
			echo '<a href="'.network_site_url('my-account/?').'pj1=' .$start_me.'&des='.$desc.'"><<</a>';		
			echo '<a href="'.network_site_url('my-account/?').'pj1='.$previous_pg.'&des='.$desc.'"> '.__('Previous ','Walleto').'</a>';
		
		}
		//------------------------
		//echo $start." ".$end;
		for($i = $page; $i <= $page +2 && $i <= $end; $i ++) {

			if ($i == $pages_curent && $i != $end) {
				echo '<a class="activee" href="#">' .$i. '..</a>';
			} else {
			
				echo '<a href="'.network_site_url('my-account/?').'pj1=' . $i.'">'.$i.'</a>';
				
			}
		}
		
		//----------------------
		if($page < $totalPages)
		echo '<a href="'.network_site_url('my-account/?').'pj1=' . $next_pg.'&des='.$desc.'"> '.__('Next','Walleto').' </a>';						
						
		if($totalPages > $my_page)
		echo '<a href="'.network_site_url('my-account/?').'pj1=' . $end_me.'&des='.$desc.'">>></a>';					
				
					 ?>
                     </div>
                     
                     


					
					
					<?php
					
					wp_reset_query();
					
					?>
                
        
        
         

				  </div>
			
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
	