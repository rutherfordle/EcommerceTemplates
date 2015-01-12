<?php
/*
Template Name: Walleto_Special_Page
*/
?>

<?php
get_header();

unset($company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry);	

		if(function_exists('bcn_display'))
		{
		    echo '<div class="my_box3 breadcrumb-wrap"> ';	
		    bcn_display();
			echo '</div> ';
		}
		
		 switch( $_REQUEST["action"] ) 
		  {
			

			  			case 'register':
			
		require_once( ABSPATH . WPINC . '/registration-functions.php');
				$fields_method = trim($_POST['fields_method']);
				$company = trim($_POST['company']);
				$firstname = trim($_POST['first']);
				$lastname = trim($_POST['last']);
				$description = trim($_POST['description']);
				$user_email = trim($_POST['user_email']);
				$phone = trim($_POST['phone']);
				$start_date = trim($_POST['start_date']);
				$industry = trim($_POST['industry']);
				$location = trim($_POST['location']);
				
				$sanitized_user_login = $user_login;
			$firstname = stripslashes($firstname);
			$lastname = stripslashes($lastname);
			$company = stripslashes($company);
			$description = stripslashes($description);
			



				$errors = Walleto_register_new_user_sitemile1($fields_method, $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $location);

		unset($_SESSION['security_code']);
				if (!is_wp_error($errors)) 
					{	
						$ok_reg = 1;
						unset($company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $location);						
					}	


			  			default:
			
			global $real_ttl;
			$real_ttl = __("Register", $current_theme_locale_name);			
			add_filter( 'wp_title', 'Walleto_sitemile_filter_ttl', 10, 3 );	
			
		
			
		
				
				?>
				
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="description" content="Over 15 years of document scanning and document management experience assures success with your document scanning project. Our focus on customer service means you realize exceptional value with every high speed document scanner we rent." />
<meta name="keywords" content="document scanning, document management software, document management solution, rentscan, rent high speed scanners, high speed scanners, best scanner, scanning solution, high-volume document scanning" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RentScanTM by EchoStone Inc.</title>


<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/global.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/global.css">
<script type="text/javascript">
//-->
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="js/slides.min.jquery.js"></script>


<meta name="y_key" content="9680d3d1c6514373" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1288792-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php if ( 1 == $ok_reg ) { 
popup();
}?>

</head>
<body>
<table width="980" border="0" cellspacing="0" cellpadding="0" class="center">
<?php
if(!is_user_logged_in()){

?>
<table width="980" border="0" cellspacing="0" cellpadding="0" class="center" style="padding-top:0px">
<?php } ?>


  <tr>
    <td align="left"><a href="home"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/logo.jpg" alt="rentscan high speed document scanner rental logo" /></a></td>
    <td class="phone" align="right">
    
    
    <a href="home" 
    onmouseover="document.images['home'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/home1.jpg'" 
    onmouseout="document.images['home'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/home.jpg'">
    <img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/home.jpg" name="home"  /></a>
    
    <a href="what-we-do" 
    onmouseover="document.images['what-we-do'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/what-we-do1.jpg'" 
    onmouseout="document.images['what-we-do'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/what-we-do.jpg'">  
    <img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/what-we-do.jpg" name="what-we-do"  /></a>
    
    <a href="what-we-rent" 
    onmouseover="document.images['what-we-rent'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/what-we-rent1.jpg'" 
    onmouseout="document.images['what-we-rent'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/what-we-rent.jpg'">  
    <img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/what-we-rent.jpg" name="what-we-rent"  /></a>
    
    <a href="why-rentscan" 
    onmouseover="document.images['why-rentscan'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/why-rentscan1.jpg'" 
    onmouseout="document.images['why-rentscan'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/why-rentscan.jpg'">   
    <img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/why-rentscan.jpg" name="why-rentscan"/></a>
    
	<a href="partners" 
    onmouseover="document.images['scanner-rental-partners'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/partners1.jpg'" 
    onmouseout="document.images['scanner-rental-partners'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/partners.jpg'">  
    <img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/partners.jpg" name="scanner-rental-partners" /></a>
 <?php
if(is_user_logged_in())
								{
									
									global $current_user;
									get_currentuserinfo();
									$user = $current_user->user_login;
									?>
									
							
								<a href="./wp-login.php?action=logout"
								onmouseover="document.images['login'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/logout1.jpg'" 
								onmouseout="document.images['login'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/logout.jpg'">
								<img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/logout.jpg" alt="" name="login" id="login" /></a>    <br />
									
									<?php
								}
								else
									{
										
							
							?>
							
								<a class="<?php echo $class_log; ?>" href="<?php bloginfo('siteurl') ?>/wp-login.php"
								onmouseover="document.images['login'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/login1.jpg'" 
								onmouseout="document.images['login'].src='<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/login.jpg'">
								<img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/login.jpg" alt="" name="login" id="login" /></a>    <br />
							<?php } ?> 


    Call (888) 425-8228<br />
 <table>
    <tr>
    
<td class="card">Nationwide&nbsp;&nbsp;</td></tr>
<?php 
								$tempuser	= $_SESSION['tempcomp'];
								$cart 		= $_SESSION['my_cart'];
								$renew = $_SESSION['renew'];
								$edit = $_SESSION['edit'];
								error_reporting(E_ERROR | E_PARSE);
									foreach($cart as $item){
									$quant += $item['quant'];
									}
									if (isset($tempuser))
									$temp = $tempuser;
									if (isset($_SESSION['renew']))
									$temp = 'Renew Order # '.$renew;
									if (isset($_SESSION['edit']))
									$temp = 'Edit Quote # '.$edit;
									if ($quant == NULL)
									$quant = 0;
									if(is_user_logged_in()){
?>
<tr><td  ><a href="<?php echo bloginfo('siteurl').'/shopping-cart' ?>" >&nbsp; <?php echo '<font size="2">My Cart('.$quant.')</font>'?></a></td>
<td><font size="2"><?php echo $temp ?></font></td></tr><?php } ?></table>
    </td>
	
  </tr>

  </table>

<table width="980" height="334" border="0" cellspacing="0" cellpadding="0" class="center">		
  <tr>
    <td>
       
<div id="example">
         <div id="i" align=center height="334">
		 <a href="javascript:slidelink()">
		<IMG SRC="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/slidebg_clutter.jpg" NAME="slideshow" BORDER=0 HEIGHT="334" WIDTH="100%"></a>

			<div class="overlay">
			<form METHOD="LINK" ACTION="JavaScript:slideshowBack()" style="height:0px;">
			<input type="image" src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/arrow-next.png" alt="Submit Form" class="this" >
			<METHOD="LINK" ACTION="JavaScript:slideshowUp()">
			<input type="image" src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/arrow-prev.png" alt="Submit Form" class="that">
			</form></div>
			</form></div>		
		<SCRIPT LANGUAGE="JavaScript"> 
		var num=1
		var whichimage=1
		setInterval(slideshowUp, 5000);
		img1 = new Image ()
		img1.src = "<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/slidebg_clutter.jpg"
		img2 = new Image ()
		img2.src = "<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/slidebg_packages.jpg"
		img3 = new Image ()
		img3.src = "<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/slidebg_servicevan.jpg"

		function slideshowUp()
		{
			num=num+1
			if (num==4)
			{num=1}
			document.slideshow.src=eval("img"+num+".src")
			whichimage=num
		}

		function slideshowBack()
		{
			num=num-1
			if (num==0)
			{num=3}
			document.slideshow.src=eval("img"+num+".src")
			whichimage=num
		}
               function slidelink(){
			if (whichimage==1)
			window.location="why-rentscan"
			else if (whichimage==2)
			window.location="what-we-rent"
			else if (whichimage==3)
			window.location="about-us"
}

		</script>
		</div>
    </td>
  </tr>
</table>
       
<table width="980" border="0" cellspacing="0" cellpadding="0" class="center">
  <tr>
    <td width="641">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="18" bgcolor="#DBDBDB">&nbsp;</td>
    <td width="280" bgcolor="#DBDBDB">&nbsp;</td>
  </tr>
</table>



<table width="980" border="0" cellspacing="0" cellpadding="0" class="center bg1">
  <tr>
    <td width="642" valign="top">
    <div class="pad1">
<div id="new_div"align=left>
            	<section id = "main_section">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php /* ?>
<div class="pad1">
<h4>Welcome to <span class="red">Rent</span><span class="black">Scan<sup class="size2">TM</sup></span> by Fujitsu</h4>
RentScan<sup class="size4">TM</sup> is a provider of High-Speed Document Scanning Rental Solutions.
Short term scanning project? No Problem. Long Term scanning solution? We have you covered. 
<h5><a class="link1" href="what-we-rent">View Products</a></h5>
&nbsp;
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="td5"  width="60%" height="200">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<?php
					global $wp_query;
					$query_vars = $wp_query->query_vars;
					$post_per_page = 4;				
					query_posts( "post_status=draft,publish&meta_key=".$key."&post_type=product&order=".$desc."&orderby=".$val."&author=".$uid."&posts_per_page=" . $post_per_page . "&paged=" . $query_vars['paged'] );
	
					if(have_posts()) :
echo '   <table border="0" cellspacing="0" cellpadding="0" style="margin-top: -22px">';
					while ( have_posts() ) : the_post();

						walleto_active_products_get_product2();

					endwhile; 
					
					if(function_exists('wp_pagenavi')):
					wp_pagenavi(); endif;
					
					else:
					
					_e("There are no active products yet.",'Walleto');
					
					endif;
					
					wp_reset_query();
					?>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center" valign="top" width="290" height="167">"We had over five years of client files to be scanned (over 700,000 pages). During the project, Rentscan associates were always available for questions, training and they even remotely configured the machine to fit
our needs. We ended up finishing the project several weeks ahead of schedule! 
"Rashi Karpf - Karpf &amp; Karpf, 
PCBensalem, PA</td>
<td align="center" valign="top" width="25"></td>
<td align="center" valign="top" width="304">"As a small business owner, the rental scanner was
a perfect option for a large but short term scanning project. My experience was wonderful. Fast and friendly service, excellent technical support and easy delivery options. I am officially paperless and a more efficient business!"
Marie McClaflin - Owner, Arc Brand Marketing
Charlotte, NC</td>
</tr>
</tbody>
</table>
</div>
<?php */?>	
<?php the_content(); ?>			
<?php endwhile; // end of the loop.
add_shortcode('walleto_my_account_home', 'Walleto_my_account_display_home_page');
 ?>
	</section>
					
         
</div></td>
    <td width="40" valign="top" class="doth"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/whiteblank.gif" alt="" border="0" /></td>
    <td width="19" valign="top" bgcolor="#DBDBDB" class="doth">&nbsp;</td>
    <td width="279" valign="top" bgcolor="#DBDBDB"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/getaquote.gif" alt="" />
     <table width="262" border="0" cellspacing="0" cellpadding="0" class="bg3">
        <tr>
          <td><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/form_top.gif" alt="rentscan scanner rental quote top image" HEIGHT="16" WIDTH="100%"/></td>
        </tr>
        <tr>
          <td align="left"><div class="pad2">
		  <?php if ( isset($errors) && isset($_POST['action']) ) : ?>
						  <div class="error">
							<ul>
							<?php
							foreach($errors as $error) {
							if(count($error) > 0) {
							
							foreach($error as $e) echo "<li>".$e[0]."</li>";
							
							
							}
							}
							?>
							</ul>
						  </div>
						  <?php endif; ?>
              <form method="post" action="<?php echo $current_file; ?>" name="icpsignup" id="icpsignup3882" accept-charset="UTF-8" >
<!--<input type="hidden" name="redirect" value="http://www.myscannerrental.com/thanks-from-rentscan.html">
<input type="hidden" name="errorredirect" value="http://www.myscannerrental.com/resubmit-rentscan-quote-request.html">-->

<div id="SignUp">
<table width="230" class="signupframe" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<input type="hidden" name="action" value="register" />
     
    </tr>
	<tr>
      <td valign="top" align="left">

        <span class="required">*</span><?php _e('First Name:',$current_theme_locale_name) ?><br />
   <input type="text" name="first" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo stripslashes($firstname); ?>" ><br />
      
        <span class="required">*</span><?php _e('Last Name:',$current_theme_locale_name) ?><br />
 
        <input type="text" name="last" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $lastname; ?>"><br />
  
         <span class="required">*</span><?php _e('Phone:',$current_theme_locale_name) ?> <br />
    
        <input type="text" name="phone" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: 999-999-9999" value = "<?php echo $phone; ?>"><br />
  
        <span class="required">*</span><?php _e('E-mail:',$current_theme_locale_name) ?><br />
     
        <input type="text" name="user_email" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" title = "Format: sample@example.com" value = "<?php echo $user_email; ?>"><br />
         <?php _e('Company:',$current_theme_locale_name) ?><br />
  
        <input type="text" name="company" style ="background:url(<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/inp1bg.gif) repeat-x; margin:2px 0 7px 0; padding:0; border:0; width:222px; height:20px" value = "<?php echo $company; ?>"><br />
  
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
          <option value="Government"<?php if(isset($industry) && $$industry == 'Government') 
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
        </select>
		<br />
<div class="pad-top">
		<span class="required ">*</span><?php _e('Location:',$current_theme_locale_name) ?><br />
    
       <select name="location">
          <option>Select</option>
          <option value="Alabama"<?php if(isset($location) && $location == 'Alabama') 
          echo ' selected="selected"';
    ?>>Alabama</option>
          <option value="Alaska"<?php if(isset($location) && $location == 'Alaska') 
          echo ' selected="selected"';
    ?>>Alaska</option>
          <option value="American Samoa"<?php if(isset($location) && $location == 'American Samoa') 
          echo ' selected="selected"';
    ?>>American Samoa</option>
          <option value="Arizona"<?php if(isset($location) && $location == 'Arizona') 
          echo ' selected="selected"';
    ?>>Arizona</option>
          <option value="Arkansas"<?php if(isset($location) && $location == 'Arkansas') 
          echo ' selected="selected"';
    ?>>Arkansas</option>
          <option value="California"<?php if(isset($location) && $location == 'California') 
          echo ' selected="selected"';
    ?>>California</option>
          <option value="Colorado"<?php if(isset($location) && $location == 'Colorado') 
          echo ' selected="selected"';
    ?>>Colorado</option>
          <option value="Connecticut"<?php if(isset($location) && $location == 'Connecticut') 
          echo ' selected="selected"';
    ?>>Connecticut</option>
          <option value="Delaware"<?php if(isset($location) && $location == 'Delaware') 
          echo ' selected="selected"';
    ?>>Delaware</option>
          <option value="District of Columbia"<?php if(isset($location) && $location == 'District of Columbia') 
          echo ' selected="selected"';
    ?>>District of Columbia</option>
          <option value="Florida"<?php if(isset($location) && $location == 'Florida') 
          echo ' selected="selected"';
    ?>>Florida</option>
	          <option value="Georgia"<?php if(isset($location) && $location == 'Georgia') 
          echo ' selected="selected"';
    ?>>Georgia</option>
	          <option value="Guam"<?php if(isset($location) && $location == 'Guam') 
          echo ' selected="selected"';
    ?>>Guam</option>
	          <option value="Hawaii"<?php if(isset($location) && $location == 'Hawaii') 
          echo ' selected="selected"';
    ?>>Hawaii</option>
	          <option value="Idaho"<?php if(isset($location) && $location == 'Idaho') 
          echo ' selected="selected"';
    ?>>Idaho</option>
	          <option value="Illinois"<?php if(isset($location) && $location == 'Illinois') 
          echo ' selected="selected"';
    ?>>Illinois</option>
	          <option value="Indiana"<?php if(isset($location) && $location == 'Indiana') 
          echo ' selected="selected"';
    ?>>Indiana</option>
	          <option value="Iowa"<?php if(isset($location) && $location == 'Iowa') 
          echo ' selected="selected"';
    ?>>Iowa</option>
	          <option value="Kansas"<?php if(isset($location) && $location == 'Kansas') 
          echo ' selected="selected"';
    ?>>Kansas</option>
		          <option value="Kentucky"<?php if(isset($location) && $location == 'Kentucky') 
          echo ' selected="selected"';
    ?>>Kentucky</option>
		          <option value="Louisiana"<?php if(isset($location) && $location == 'Louisiana') 
          echo ' selected="selected"';
    ?>>Louisiana</option>
		          <option value="Maine"<?php if(isset($location) && $location == 'Maine') 
          echo ' selected="selected"';
    ?>>Maine</option>
		          <option value="Maryland"<?php if(isset($location) && $location == 'Maryland') 
          echo ' selected="selected"';
    ?>>Maryland</option>
		          <option value="Massachusetts"<?php if(isset($location) && $location == 'Massachusetts') 
          echo ' selected="selected"';
    ?>>Massachusetts</option>
		          <option value="Michigan"<?php if(isset($location) && $location == 'Michigan') 
          echo ' selected="selected"';
    ?>>Michigan</option>
		          <option value="Minnesota"<?php if(isset($location) && $location == 'Minnesota') 
          echo ' selected="selected"';
    ?>>Minnesota</option>
		          <option value="Mississippi"<?php if(isset($location) && $location == 'Mississippi') 
          echo ' selected="selected"';
    ?>>Mississippi</option>
		          <option value="Missouri"<?php if(isset($location) && $location == 'Missouri') 
          echo ' selected="selected"';
    ?>>Missouri</option>
		          <option value="Montana"<?php if(isset($location) && $location == 'Montana') 
          echo ' selected="selected"';
    ?>>Montana</option>
		          <option value="Nebraska"<?php if(isset($location) && $location == 'Nebraska') 
          echo ' selected="selected"';
    ?>>Nebraska</option>
		          <option value="Nevada"<?php if(isset($location) && $location == 'Nevada') 
          echo ' selected="selected"';
    ?>>Nevada</option>
		          <option value="New Hampshire"<?php if(isset($location) && $location == 'New Hampshire') 
          echo ' selected="selected"';
    ?>>New Hampshire</option>
		          <option value="New Jersey"<?php if(isset($location) && $location == 'New Jersey') 
          echo ' selected="selected"';
    ?>>New Jersey</option>
		          <option value="New Mexico"<?php if(isset($location) && $location == 'New Mexico') 
          echo ' selected="selected"';
    ?>>New Mexico</option>
		          <option value="New York"<?php if(isset($location) && $location == 'New York') 
          echo ' selected="selected"';
    ?>>New York</option>
		          <option value="North Carolina"<?php if(isset($location) && $location == 'North Carolina') 
          echo ' selected="selected"';
    ?>>North Carolina</option>
		          <option value="North Dakota"<?php if(isset($location) && $location == 'North Dakota') 
          echo ' selected="selected"';
    ?>>North Dakota</option>
		          <option value="Northern Mariana Islands"<?php if(isset($location) && $location == 'Northern Mariana Islands') 
          echo ' selected="selected"';
    ?>>Northern Mariana Islands</option>
		          <option value="Ohio"<?php if(isset($location) && $location == 'Ohio') 
          echo ' selected="selected"';
    ?>>Ohio</option>
		          <option value="Oklahoma"<?php if(isset($location) && $location == 'Oklahoma') 
          echo ' selected="selected"';
    ?>>Oklahoma</option>
		          <option value="Oregon"<?php if(isset($location) && $location == 'Oregon') 
          echo ' selected="selected"';
    ?>>Oregon</option>
			          <option value="Pennsylvania"<?php if(isset($location) && $location == 'Pennsylvania') 
          echo ' selected="selected"';
    ?>>Pennsylvania</option>
			          <option value="Puerto Rico"<?php if(isset($location) && $location == 'Puerto Rico') 
          echo ' selected="selected"';
    ?>>Puerto Rico</option>
			          <option value="Rhode Island"<?php if(isset($location) && $location == 'Rhode Island') 
          echo ' selected="selected"';
    ?>>Rhode Island</option>
			          <option value="South Carolina"<?php if(isset($location) && $location == 'South Carolina') 
          echo ' selected="selected"';
    ?>>South Carolina</option>
			          <option value="South Dakota"<?php if(isset($location) && $location == 'South Dakota') 
          echo ' selected="selected"';
    ?>>South Dakota</option>
			          <option value="Tennessee"<?php if(isset($location) && $location == 'Tennessee') 
          echo ' selected="selected"';
    ?>>Tennessee</option>
			          <option value="Texas"<?php if(isset($location) && $location == 'Texas') 
          echo ' selected="selected"';
    ?>>Texas</option>
			          <option value="United States Virgin Islands"<?php if(isset($location) && $location == 'United States Virgin Islands') 
          echo ' selected="selected"';
    ?>>United States Virgin Islands</option>
			          <option value="Utah"<?php if(isset($location) && $location == 'Utah') 
          echo ' selected="selected"';
    ?>>Utah</option>
			          <option value="Vermont"<?php if(isset($location) && $location == 'Vermont') 
          echo ' selected="selected"';
    ?>>Vermont</option>
			          <option value="Virginia"<?php if(isset($location) && $location == 'Virginia') 
          echo ' selected="selected"';
    ?>>Virginia</option>
			          <option value="Washington"<?php if(isset($location) && $location == 'Washington') 
          echo ' selected="selected"';
    ?>>Washington</option>
			          <option value="West Virginia"<?php if(isset($location) && $location == 'West Virginia') 
          echo ' selected="selected"';
    ?>>West Virginia</option>
			          <option value="Wisconsin"<?php if(isset($location) && $location == 'Wisconsin') 
          echo ' selected="selected"';
    ?>>Wisconsin</option>
			          <option value="Wyoming"<?php if(isset($location) && $location == 'Wyoming') 
          echo ' selected="selected"';
    ?>>Wyoming</option>
			          <option value="Other"<?php if(isset($location) && $location == 'Other') 
          echo ' selected="selected"';
    ?>>Other</option>
	
        </select><br />
  </div>
  <div class="pad-top">
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
 </div>
        <span class="required">*</span><?php _e('Project Details:',$current_theme_locale_name) ?><br />
        
         <textarea rows="3" cols="25" name="description"><?php echo htmlspecialchars($description);?></textarea><br /><br />        
        
      </td>
    </tr>
    <input type="hidden" name="listid" value="32092">
    <input type="hidden" name="specialid:32092" value="7XT9">

    <input type="hidden" name="clientid" value="855981">
    <input type="hidden" name="formid" value="3882">
    <input type="hidden" name="reallistid" value="1">
    <input type="hidden" name="doubleopt" value="0">
 <tr><td><img src="<?php bloginfo('siteurl')?>/wp-content/themes/Walleto/CaptchaSecurityImages.php?width=140&height=60&characters=5" /><br />
		<label for="security_code">Security Code: </label><input id="security_code" name="security_code" type="text" /><br />
		*Case Sensitive</td></tr>
    <tr align="center">
      <td>
	  <div class="pad-top">
      <input name="Submit" type="image" value="Submit" src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/button_get-a-quote.jpg" /></td>
    </tr>
    </table>
</div>
</form>

<?php  } 



function Walleto_register_new_user_sitemile1( $fields_method, $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $location ) {
	$errors = new WP_Error();
	//$apos = array("'", '"');
	//$aposrep = array("&rsquo;","&quot;");
	  

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
	$location = apply_filters( 'industry', $location );
	$description = apply_filters( 'description', $description );
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
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.', $current_theme_locale_name ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.', $current_theme_locale_name ) );
		$user_email = '';
	} 
		if ( $phone == '' ) {
		$errors->add( 'empty_phone', __( '<strong>ERROR</strong>: Need phone number.', $current_theme_locale_name ) );
	} else if (!(preg_match("/[(. ]?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})/", $phone))) {
  $errors->add( 'invalid_phone', __( '<strong>ERROR</strong>: The phone is incorrect.', $current_theme_locale_name ) );
}

		// Check the firstname
	if ( $firstname == '' ) {
		$errors->add( 'empty_firstname', __( '<strong>ERROR</strong>: Need first name.', $current_theme_locale_name ) );
	} 
			// Check the lastname
	if ( $lastname == '' ) {
		$errors->add( 'empty_lastname', __( '<strong>ERROR</strong>: Need last name.', $current_theme_locale_name ) );
	} 
			// Check the industry
	if ( $industry == 'Select' ) {
		$errors->add( 'empty_industry', __( '<strong>ERROR</strong>: Need industry.', $current_theme_locale_name ) );
	} 
	// Check the $location
	if ( $location == 'Select' ) {
		$errors->add( 'empty_location', __( '<strong>ERROR</strong>: Need location.', $current_theme_locale_name ) );
	} 
			// Check the description
	if ( $description == '' ) {
		$errors->add( 'empty_description', __( '<strong>ERROR</strong>: Need description.', $current_theme_locale_name ) );
	} 
		// Check the start_date
	if ( $start_date == 'Select' ) {
		$errors->add( 'empty_start_date', __( '<strong>ERROR</strong>: Need start date.', $current_theme_locale_name ) );
	} 
	   				 if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
		// Insert you code for processing the form here, e.g emailing the submission, entering it into a database. 
 } else {
		// Insert your code for showing an error message here
		$errors->add( 'empty_code', __( '<strong>ERROR</strong>: Sorry, you have provided an invalid security code', $current_theme_locale_name ) );
   }
	do_action( 'register_post', $company, $firstname, $lastname, $description, $user_email, $phone, $start_date, $industry, $location, $fields_method, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email, $start_date, $industry, $fields_method );
	if ( $errors->get_error_code() )
		return $errors;

	$user_pass = wp_generate_password( 12, false);
	if($industry == 'Select'){$industry = '';}
	$company = esc_sql( $company );
	$first_name = esc_sql( $firstname );
	$last_name = esc_sql( $lastname );
	$description = esc_sql( $description );
	$user_email = esc_sql( $user_email);
	$user_phone = esc_sql( $phone);
	$start_date = esc_sql( $start_date);
	$industry = esc_sql( $industry);
	$location = esc_sql( $location);
	$fields_method = esc_sql( $fields_method);
	$user_pass = $password;
	$today = date('Y-m-d H:i:s');
	require 'connectPDO.php';
$query_result = $DBH->prepare("INSERT INTO `request_a_quote` VALUES ('',:first_name,:last_name,
								:user_email,:user_phone,
								:company,:industry,:location,
								:start_date,
								:description,'$today',
								'', '$today', 'WAITING_FOR_SYNC')");
	$parms[':first_name'] = $first_name;
	$parms[':user_email'] = $user_email;
	$parms[':user_phone'] = $user_phone;
	$parms[':last_name'] = $last_name;
	$parms[':company'] = $company;
	$parms[':industry'] = $industry;
	$parms[':location'] = $location;
	$parms[':start_date'] = $start_date;

	$parms[':description'] = $description;
	$query_result->execute($parms);
	$user_message = "Hi {$first_name}, \r\n\r\nThank you for submitting your RentScan By Fujitsu scanner rental quote request. Please review the information below to make sure the contact information you provided is accurate.\r\n\r\nIf you see an error, then please resubmit your quote request or call us at (888) 425-8228.\r\n\r\nA Fujitsu representative will contact you within 24 hours to discuss your scanning project requirements. If you would like to discuss immediately, then please call us at (888) 425-8228.\r\n\r\nEstimated Project Start Date: {$start_date}\r\n\r\nCompany: {$company}\r\nName: {$first_name} {$last_name}\r\nIndustry: {$industry}\r\nLocation: {$location}\r\n\r\nE-Mail: {$user_email}\r\nPhone: {$phone}\r\n\r\nComments: {$description}\r\n\r\nWe look forward to helping you complete your scanning project.\r\n\r\nHave a great day,\r\n\r\nThe RentScan By Fujitsu Team";
	
	
                if ( ! $query_result ) {
                $errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', $current_theme_locale_name ), get_option( 'admin_email' ) ) );
                                return $errors;
                }
                logging(-1, 'Quote requested', 'walleto-special-page-template.php');
				//wp_mail($user_email, $subject = "Your RentScan Quote Request", $user_message, $headers = 'Inside Sales Test');
                Walleto_send_email1($user_email, $subject = "Your RentScan Quote Request", $user_message, 'request_quote', 'inside_sales');

	
	return $user_id;
}

?>

          </div></td>
        </tr>
        <tr>
          <td><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/Walleto/images/form_bot.gif" alt="" /></td>
        </tr>
      </table>
      <p></p>
</td>
  </tr>
</table>



  
<?php get_footer(); ?>