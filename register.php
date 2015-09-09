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
        
        //error handling
        if((!$username)||(!$fname)||(!$lname)||(!$pass1)||(!$pass2)){
            $message = 'Please insert all fields in the form below!';
        }else{
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
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $db = connect();
                    $query = $db->prepare("INSERT INTO customer (firstName, lastName, authenticationCode, ip_address, email)VALUES('$fname','$lname','$pass1','$ip_address','$username')") or die("Could not set up Account");
                    $query->execute();
                    $customerID = $db->lastInsertId();
                    mkdir("customers/$customerID",0755);
                    $message = "Thank you for signing up with NBGardens Web!"; 
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
        <div class="header">
            <div class="logoLeft">
            
            </div>
            <div class="accountSection">
                <a href="login.php">Login</a>
            </div>
        
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
        
        <div class="footer">
            
            <div class="indexFoot">
                <div class="indexInfo">Place company info in this box along with link to home page
            
                </div>
            </div>
        </div>
    </body>
</html>