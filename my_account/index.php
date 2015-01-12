<!DOCTYPE HTML>
<?php include('header.php') ?>
   <div class="span5">
            <!--Form containing item parameters and seller credentials needed for SetExpressCheckout Call-->
            <form class="form" action="paypal_ec_redirect.php" method="POST">
               <div class="row-fluid">
                  <div class="span6 inner-span">
                        <!--Demo Product details -->
                        <table>
                        <tr><h3> DIGITAL SLR CAMERA </h3></tr>
                        <tr><img src="img/camera.jpg" width="300" height="250"/></tr>
                        <tr><td><p class="lead"> Buyer Credentials:</p></td></tr>
                        <tr><td>Email-id:&nbsp;&nbsp;&nbsp;<input type="text" id="buyer_email" name="buyer_email" readonly></input> </td></tr>
                        <tr><td>Password:<input type="text" id="buyer_password" name="buyer_password" readonly></input></td></tr>
                        </table>
                  </div>
                  <div class="span6 inner-span">
                        <p class="lead"> Item Specifications:</p>
                        <table>
                        <tr><td>Item Name:</td><td><input type="text" name="L_PAYMENTREQUEST_0_NAME0" value="DSLR Camera"></input></td></tr>
                        <tr><td>Item ID: </td><td><input type="text" name="L_PAYMENTREQUEST_0_NUMBER0" value="A0123"></input></td></tr>
                        <tr><td>Description:</td><td><input type="text" name="L_PAYMENTREQUEST_0_DESC0" value="Autofocus Camera"></input></td></tr>
                        <tr><td>Quantity:</td><td><input type="text" name="L_PAYMENTREQUEST_0_QTY0" value="1" readonly></input></td></tr>
                        <tr><td>Price:</td><td><input type="text" name="PAYMENTREQUEST_0_ITEMAMT" value="1000.00" readonly></input></td></tr>
                        <tr><td>Tax:</td><td><input type="text" name="PAYMENTREQUEST_0_TAXAMT" value="2" readonly></input></td></tr>
                        <tr><td>Shipping Amount:</td><td><input type="text" name="PAYMENTREQUEST_0_SHIPPINGAMT" value="5" readonly></input></td></tr>
                        <tr><td>Handling Amount:</td><td><input type="text" name="PAYMENTREQUEST_0_HANDLINGAMT" value="1" readonly></input></td></tr>
                        <tr><td>Shipping Discount:</td><td><input type="text" name="PAYMENTREQUEST_0_SHIPDISCAMT" value="-3" readonly></input></td></tr>
                        <tr><td>Insurance Amount:</td><td><input type="text" name="PAYMENTREQUEST_0_INSURANCEAMT" value="2" readonly></input></td></tr>
                        <tr><td>Total Amount:</td><td><input type="text" name="PAYMENTREQUEST_0_AMT" value="1007" readonly></input></td></tr>
                        <tr><td><input type="hidden" name="LOGOIMG" value=<?php echo('http://'.$_SERVER['HTTP_HOST'].preg_replace('/index.php/','img/logo.jpg',$_SERVER['SCRIPT_NAME'])); ?>></input></td></tr>
                        <tr><td>Currency Code:</td><td><select name="currencyCodeType">
						<option value="AUD">AUD</option>
						<option value="BRL">BRL</option>
						<option value="CAD">CAD</option>
						<option value="CZK">CZK</option>
						<option value="DKK">DKK</option>
						<option value="EUR">EUR</option>
						<option value="HKD">HKD</option>
						<option value="MYR">MYR</option>
						<option value="MXN">MXN</option>
						<option value="NOK">NOK</option>
						<option value="NZD">NZD</option>
						<option value="PHP">PHP</option>
						<option value="PLN">PLN</option>
						<option value="GBP">GBP</option>
						<option value="RUB">RUB</option>
						<option value="SGD">SGD</option>
						<option value="SEK">SEK</option>
						<option value="CHF">CHF</option>
						<option value="THB">THB</option>
						<option value="USD">USD</option><br></td></tr>
                        <tr><td>Payment Type: </td><td><select>
                                                           <option value="Sale">Sale</option>
                                                           <option value="Authorization">Authorization</option>
                                                           <option value="Order">Order</option>
                                                         </select><br></td></tr>
                        <tr><td colspan="2"><input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" alt="Check out with PayPal"/></td></tr>
						<tr><td> -- OR -- </td></tr>
						<tr><td ><input type="Submit" alt="Proceed to Checkout" class="btn btn-primary btn-large" value="Proceed to Checkout" name="checkout"/></td></tr>
                        </table>
                  </div>
               </div>
            </form>
   </div>
   <div class="span2">
   </div>
   <div class="span5">
      <div class="row-fluid">
         <div class="span12 inner-span">
               <p class="lead"> README: </p>
               <p>
                  1) Click on ‘Checkout with PayPal’ button and see the experience.  
                  <br>
                  2) If you get any Firewall warning, add rule to the Firewall to allow incoming connections for your application.
                  <br>
                  3) Checkout with PayPal using a buyer sandbox account provided on this page. And you're done!
                  <br>
                  4) The sample code uses default sandbox credentials which are set in config.php. You can create your own credentials by creating PayPal Seller and Buyer accounts on Sandbox  <i><a href="https://developer.paypal.com/webapps/developer/applications/accounts/create" target="_blank">here</a></i>.
                  <br>
                  5) Make following changes in config.php:<br>
                  - If using your own Sandbox seller account, update PP_USER_SANDBOX, PP_PASSWORD_SANDBOX and PP_SIGNATURE_SANDBOX values with your sandbox credentials<br>
                  - SANDBOX_FLAG: Kept true for working with Sandbox, it will be false for live.<br> 
                  6) For trying out Mobile-EC, change the user-agent of your browser by installing a user agent switcher plugin and see how your website will appear on mobile devices.
               </p>
               <p class="lead"> Instructions to integrate 'Checkout with PayPal' on your website </p>
               1) Copy the files and folders under 'Checkout' package to the same location where you have your shopping cart page.
               <br>
               2) Copy the below  &lt;form&gt; .. &lt;/form&gt; to your shopping cart page. 
               <br><br>            
   <pre><code>&lt;form action="paypal_ec_redirect.php" method="POST"&gt;
      &lt;input type="hidden" name="PAYMENTREQUEST_0_AMT" value="10.00"&gt;&lt;/input&gt;
      &lt;input type="hidden" name="currencyCodeType" value="USD"&gt;&lt;/input&gt;
      &lt;input type="hidden" name="paymentType" value="Sale"&gt;&lt;/input&gt;
      <i>&lt;!--Pass additional input parameters based on your shopping cart. For complete list of all the parameters <a href="https://developer.paypal.com/webapps/developer/docs/classic/api/merchant/SetExpressCheckout_API_Operation_NVP/" target=_blank>click here</a></i> --&gt;
      &lt;input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" alt="Check out with PayPal"&gt;&lt;/input&gt;
&lt;/form&gt;</code></pre>
               3) Open your browser and navigate to your Shopping cart page. Click on 'Proceed to Checkout' button and complete the flow.<br>
               4) Read more details on Express Checkout API <a href="https://developer.paypal.com/webapps/developer/docs/classic/products/#ec" target=_blank>here</a>                    
         </div>
      </div>
   </div>
   <div class="span1">
   </div>
   <!--Script to dynamically choose a seller and buyer account to render on index page-->
   <script type="text/javascript">
      function getRandomNumberInRange(min, max) {
          return Math.floor(Math.random() * (max - min) + min);
      }
     
      
      var buyerCredentials = [{"email":"ron@hogwarts.com", "password":"qwer1234"},
                        {"email":"sallyjones1234@gmail.com", "password":"p@ssword1234"},
                        {"email":"joe@boe.com", "password":"123456789"},
                        {"email":"hermione@hogwarts.com", "password":"123456789"},
                        {"email":"lunalovegood@hogwarts.com", "password":"123456789"},
                        {"email":"ginnyweasley@hogwarts.com", "password":"123456789"},
                        {"email":"bellaswan@awesome.com", "password":"qwer1234"},
                        {"email":"edwardcullen@gmail.com", "password":"qwer1234"}];
      var randomBuyer = getRandomNumberInRange(0,buyerCredentials.length);
      
      document.getElementById("buyer_email").value =buyerCredentials[randomBuyer].email;
      document.getElementById("buyer_password").value =buyerCredentials[randomBuyer].password;
      
      
   </script>                              
<?php include('footer.php') ?>
