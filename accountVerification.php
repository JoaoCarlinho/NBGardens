<?php
    require('../local/connect.php');
    $message = "";
    $db = connect();
    
    //make sure email, verifyToken and password all match then re-direct to login
    if( ((!isset($_GET['verifyToken']))&&(!isset($_POST['verifyToken']))) || 
        (!isset($_POST['username']) && (!isset($_GET['username']))) || 
        ((!isset($_POST['pass']))&&(!isset($_GET['pass'])))   ){
            echo('Please insert all fields in the form below!');
    }else{
        if(isset($_GET['$verifyToken'])){
             $verifyToken = $_GET['verifyToken'];
        }
        else{
            $verifyToken = $_POST['verifyToken'];
        }
        
        if(isset($_GET['username'])){
             $username = $_GET['username'];
        }
        elseif(isset($_POST['username'])){
            $username = $_POST['username'];
        }else{
            $username =  $_SESSION['email'];
        }
        
        if(isset($_GET['$pass'])){
             $pass = $_GET['pass'];
        }
        else{
            $pass = $_POST['pass'];
        }
        
        
        $pass = $_POST['pass'];
        
 
             //secure the data
             $query = $db->prepare("SELECT * FROM customer WHERE email = '$username' AND authenticationCode = '$pass' AND verifyToken = '$verifyToken' LIMIT 1") or die("Could not check customer info");
             $query->execute();
             $result = $query->fetchAll(PDO::FETCH_ASSOC);
             $count_query = count($result);
             //if info entered and not results found, re-enter info
             if($count_query == 0){
                    echo('could not validate information, please try again');
             }else{
                    //update customer info in DB with account verified boolean
                    $verifyQuery = $db->prepare("UPDATE customer SET verified=? WHERE email = ?") or die("Could update Account Verification status");
                    $verifyQuery->execute(array(1, $username));
                    session_start();
                    //start the session
                    $_SESSION['pass'] = $pass;
                    foreach($result as $info){
                            $email = $info['email'];
                            $id = $info['customerID'];
                    }
                    $_SESSION['email'] =$email;
                    $_SESSION['customerID'] =$id;
                    
                    if($remember =="yes"){
                        //create the cookies
                    setcookie("id_cookie".$id.time()+60*60*24*100,"/");
                    setcookie("pass_cookie".$pass.time()+60*60*24*100,"/");
                    $SESSION['pass'] = pass_cookie;
                    }        
                    header("Location: home.php");
             }       
    }
?>



<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <title>Verify Account Email Address</title>
        <link rel="stylesheet" href="inventory.css" type="text/css" />
        <link rel="stylesheet" href="productInfo.css" type="text/css" />
        <link rel="stylesheet" href="carousel.css" type="text/css" />
        <link rel="stylesheet" href="global.css" type="text/css" />
        
    </head>
    <body>
        <?php include('header.php'); ?>
        <div>
		    <a href="logout.php">Click here to logout</a>
		</div>    
        <?php include('searchBar.php'); ?>
        
        </div>
      	<div class="container">
			  <h1>Welcome to the NB Gardens Account Verification!</h1>
              <h2>You should have received a verification token in your email.<br> 
                   Please check your email and insert that token here to verify your account and continue shopping</h2>
                <div id="registration_form">
                    <form action="accountVerification.php" method="post">
                        <input type="text" name="verifyToken" placeholder="verification Token" /><br/>
                        <input type="email" name="username" placeholder="Email Adress" /><br/>
                        <input type="password" name="pass" placeholder="Password" /><br/>
                        <input type="submit" value="Verify Email!"/>
                    </form>
                </div>
		</div>
        
        <?php include('footer.php'); ?>    
        
    </body>
</html>