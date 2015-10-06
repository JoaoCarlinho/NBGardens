<?php
    require('../local/connect.php');
    $message = "";
    $db = connect();
    
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        
        //ensure all account details have been entered
        //error handling
        if((!$username)||(!$fname)||(!$lname)||(!$pass1)||(!$pass2)){
            $message = 'Please insert all fields in the form below!';
        }else{
            //ensure both passwords match
            if($pass1 != $pass2){
                $message='Your password fields do not match!';
            }else{
                //securing the data
                $fname = preg_replace("#[^0-9a-z]#i","",$fname);
                $lname = preg_replace("#[^0-9a-z]#i","",$lname);
                $pass1 = $pass1;
                
                //check for duplicate emails
                $user_query = $db->prepare("SELECT email FROM customer WHERE email = '$username' LIMIT 10") or die("Could not check username");
                $user_query->execute();
                $result = $user_query->fetchAll(PDO::FETCH_ASSOC);
                $count_username = count($result);
                
                if($count_username > 0)
                {
                    $message = 'Duplicate email submitted!';
                }else{
                    //create verification token and send in an email
                    $length = 30;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $db = connect();
                    $query = $db->prepare("INSERT INTO customer (firstName, lastName, authenticationCode, ip_address, email, verifyToken)VALUES('$fname','$lname','$pass1','$ip_address','$username', '$randomString')") or die("Could not set up Account");
                    $query->execute();
                    $customerID = $db->lastInsertId();
                    mkdir("customers/$customerID",0755);
                    $message = "Thank you for signing up with NBGardens Web!"; 
                    
                    //send verification email
                    include('verifyEmail.php');
                    
                    header("Location: accountVerification.php?verifyToken=<?ehco($randomString)?>");
                }
            }
        } 
        
    }
?>

<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <title>Create NB Gardens Web Account</title>
        <link rel="stylesheet" href="inventory.css" type="text/css" />
        <link rel="stylesheet" href="productInfo.css" type="text/css" />
        <link rel="stylesheet" href="carousel.css" type="text/css" />
        <link rel="stylesheet" href="global.css" type="text/css" />
        
    </head>
    <body>
        <?php include('header.php'); ?>    
        <?php include('searchBar.php'); ?>
        
        </div>
      	<div class="container">
			  <h1>Welcome to the NB Gardens Account Registration!</h1>
              <p><?php echo $message; ?></p>
                <div id="registration_form">
                    <form action="register.php" method="post">
                        <input type="email" name="username" placeholder="Email Adress" /><br/>
                        <input type="text" name="fname" placeholder="First name" /><br/>
                        <input type="text" name="lname" placeholder="Last name" /><br/>
                        <input type="password" name="pass1" placeholder="Password" /><br/>
                        <input type="password" name="pass2" placeholder="Validate Password" /><br/>
                        <input type="submit" value="Register!"/>
                    </form>
                </div>
		</div>
        
        <?php include('footer.php'); ?>    
        
    </body>
</html>