<?php
include('sessionStatus.php');

if (isset($_SESSION['username']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['cellPhone']) && isset($_POST['shipStreet']) && isset($_POST['shipApt']) && isset($_POST['shipZip'])&& isset($_POST['billStreet']) && isset($_POST['billApt']) && isset($_POST['shipApt']) && isset($_POST['billZip'])  && isset($_POST['orderTotal'])  && isset($_POST['submitDate']) && isset($_POST['customerOrderID']) ){

		if (isset($_POST['firstName'])) {
    			$firstName = htmlentities(test_input($_POST["firstName"]), ENT_QUOTES, 'UTF,8');
		}
 
    		if (isset($_POST['lastName'])) {
    			$lastName = htmlentities(test_input($_POST["lastName"]), ENT_QUOTES, 'UTF,8');
		}
	
		if (isset($_POST['username'])) {
    			$email_to = htmlentities(test_input($_POST["username"]), ENT_QUOTES, 'UTF,8');
		}
 
		if (isset($_POST['cellPhone'])) {
    			$cellPhone = htmlentities(test_input($_POST["cellPhone"]), ENT_QUOTES, 'UTF,8');
		}
	
	
		if (isset($_POST['shipStreet'])) {
    			$shipStreet = htmlentities(test_input($_POST["shipStreet"]), ENT_QUOTES, 'UTF,8');
		}
	
		if (isset($_POST['shipApt'])) {
    			$shipApt = htmlentities(test_input($_POST["shipApt"]), ENT_QUOTES, 'UTF,8');
		}
		if (isset($_POST['shipZip'])) {
    			$shipZip = htmlentities(test_input($_POST["shipZip"]), ENT_QUOTES, 'UTF,8');
		}
		
		if (isset($_POST['billStreet'])) {
    			$billStreet = htmlentities(test_input($_POST["billStreet"]), ENT_QUOTES, 'UTF,8');
		}
	
		if (isset($_POST['billApt'])) {
    			$billApt = htmlentities(test_input($_POST["billApt"]), ENT_QUOTES, 'UTF,8');
		}
		if (isset($_POST['billZip'])) {
    			$billZip = htmlentities(test_input($_POST["billZip"]), ENT_QUOTES, 'UTF,8');
		}
	
		if (isset($_POST['homePhone'])) {
    			$homePhone = htmlentities(test_input($_POST["homePhone"]), ENT_QUOTES, 'UTF,8');
		}
		
		
		//show order total, billing and shipping information on next page once all fields are filled in
		            $email_from = "sales@NBGardens.com";
    		        $email_subject = "NBGardens Customer Order Confirmation";
 
    		        $comments = 'Thank you for using NBGardens Customer Portal! ' . $fname.'! \n
                        You have successfully placed an order!\n';
                        
                        /***Paste order details in here*****/
    
    		        $error_message = "";
 
    		        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  		            if(!preg_match($email_exp,$email)) {
    			        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  		            }
 
    		
  		            if(strlen($error_message) > 0) {died($error_message);}
 
 
    		        function clean_string($string) {
      			        $bad = array("content-type","bcc:","to:","cc:","href");
      			        return str_replace($bad,"",$string);
    		        }
 
    		        $email_message = clean_string($comments)."\n";
 
		            // create email headers
 
		            $headers = 'From: '. $email_from ."\r\n".
 
		            'Reply-To: '. $email_from ."\r\n" .
 
		            'X-Mailer: PHP/' . phpversion();
 
		            mail($email_to, $email_subject, $email_message, $headers);
                    $message = "Thank you for signing up with NBGardens Web!";
		////header(Location = "orderconfirmation.php?")
	
}
else{
	
    echo('<br> Please enter your information into the following feilds to confirm your order!');
}


?>

<html>
	<h1>Thank you for your order!</h1>
	
	<table cellpadding="2" cellspacing="2" border="1">
    <tr>
        <th>option</th><th>Id</th><th>Name</th><th>Price</th><th>Quantity</th><th>Sub Total</th>
    </tr>
    
    <tr>
        <?php
            $s = 0;
            $cart = $_SESSION['cart'];
            
            for($ci=0; $ci<count($cart); $ci++){
                $s += $cart[$ci][2] * $cart[$ci][3];
        ?>
            <tr>
                <td><a href="shoppingcart.php?index=<?php echo $index;?>" onclick"return confirm('Are you sure')">Deleted</a></td>
                <td><?php echo $cart[$ci][0]; ?></td> 
                <td><?php echo $cart[$ci][1]; ?></td> 
                <td><?php echo $cart[$ci][2]; ?></td> 
                <td><?php echo $cart[$ci][3]; ?></td> 
                <td><?php echo $cart[$ci][2] * $cart[$ci][3]; ?></td> 
            </tr>
        <?php 
           }
        ?>
    </tr>
    
</table>
<h1>Your order total is $<?php echo $_SESSION['orderTotal']; ?></h1>


    <div class = "main" d>
        <center><font color="black" size="5">Customer Info</font></center><br><br>
        <div id="register_box" style="color:#black; " >
            <!-- change action to <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> -->
            <form action="checkout.php" method="post" onsubmit="return checkForm(this);"><font size = "4">
                        <center>Shipping address:</center><br><br>
                        Street Number:<input type="text" name="ShipStreet" size="40"><br>
                        Apt Number:<input type="text" name="ShipApt" size="38"><br>
                        Zip:<input type="text" name="shipZip" size="5"><br><br>
                        <center>Billing address:</center><br><br>
                        Street Number:<input type="text" name="BillStreet" size="40"><br>
                        AptNumber<input type="text" name="BillApt" size="38"><br><br>
                        Zip:<input type="text" name="BillZip" size="5"><br><br>
                        Home Phone:<input type="tel" name="homePhone">     Cell Phone:(xxxxxxxxxx)<input type="tel" name="cellPhone" required><br><br>

                    </font><input type="submit" value="Submit">
            </form>
        </div>
    </div>
</html>