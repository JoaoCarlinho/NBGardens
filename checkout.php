<?php
include('sessionStatus.php');

if (isset($_POST['email']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['cellPhone']) && isset($_POST['shipStreet']) && isset($_POST['shipApt']) && isset($_POST['shipZip'])&& isset($_POST['billStreet']) && isset($_POST['billApt']) && isset($_POST['shipApt']) && isset($_POST['billZip'])  && isset($_POST['orderTotal'])  && isset($_POST['submitDate']) && isset($_POST['customerOrderID']) ){

		if (isset($_POST['firstName'])) {
    			$firstName = htmlentities(test_input($_POST["firstName"]), ENT_QUOTES, 'UTF,8');
		}
 
    		if (isset($_POST['lastName'])) {
    			$lastName = htmlentities(test_input($_POST["lastName"]), ENT_QUOTES, 'UTF,8');
		}
	
		if (isset($_POST['email'])) {
    			$email_from = htmlentities(test_input($_POST["email"]), ENT_QUOTES, 'UTF,8');
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
                $index = $ci;
        ?>
            <tr>
                <td><a href="shoppingcart.php?index=<?php echo $ci;?>productID=<?php echo $cart[$ci][0] ?>" onclick"return confirm('Are you sure')">Delete</a></td><!-- Delete Button -->
                <td><?php echo $cart[$ci][0]; ?></td><!-- productID -->
                <td><?php echo $cart[$ci][1]; ?></td><!-- productName --> 
                <td><?php echo $cart[$ci][2]; ?></td><!-- retailPrice --> 
                <td><?php echo $cart[$ci][3]; ?></td><!-- quantityNonPorous --> 
                <td><?php echo $cart[$ci][2] * $cart[$ci][3]; ?></td><!-- Total for this product --> 
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