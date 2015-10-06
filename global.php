<?php
//This page handles account verification, authentication and session persistence    
$logged = 0;    
session_start();
require_once('../local/connect.php');
//checking if sessions are set for the browser
$db = connect();
if(isset($_SESSION['pass']) && isset($_SESSION['email']) && isset($_SESSION['customerID'])){ 
        $session_email = $_SESSION['email'];
        $session_pass = $_SESSION['pass'];
        $session_id = $_SESSION['customerID'];
    //Authenticate customer using current session
    $query = $db->prepare("SELECT * FROM customer WHERE customerID = '$session_id' AND authenticationCode = '$session_pass' LIMIT 1") or die("could not check member");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
    
    //verify user
    if($count > 0){
        foreach($result as $info){
                $verified = $info['verified'];
            }
        
        
        //logged in stuff here
        $logged = 1;
        
        if ($verified==1){//account verified, so do nothing
            
            
            }else{//send verification code to email and ask user to check email for verification code
                    $length = 30;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $db = connect();
                    $verifyQuery = $db->prepare("UPDATE customer SET verifyToken=? WHERE email=?") or die("Could not send verification token");
                    $verifyQuery->execute(array($randomString, $session_email));
                    $customerID = $db->lastInsertId();
                    mkdir("customers/$customerID",0755);
                    $message = "Thank you for signing up with NBGardens Web!"; 
                    
                    //send verification email
                    $email_from = "accounts@NBGardens.com";
    		        $email_subject = "NBGardens Customer Portal Account Verification";
 		            $email_to=$session_email;
 
    		        $comments = 'Congratulations! \n
                        You are ready to verify your account for\n
                        NBGardens Customer Portal!\n

                        Please click on the link below to verify your account and begin shopping with NBGardens\n\n
                        
                        <h4><a href="accountVerification.php?verifyToken=$randomString&username=$username&pass=$pass"></h4>';
    
    		        $error_message = "";
 
    		        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  		            if(!preg_match($email_exp,$session_email)) {
    			        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  		            }
   		
  		            if(strlen($error_message) > 0) {die($error_message);}
 
    		        function clean_string($string) {
      			        $bad = array("content-type","bcc:","to:","cc:","href");
      			        return str_replace($bad,"",$string);
    		        }
    		        $email_message = clean_string($comments)."\n";
 
		            // create email headers
		            $headers = "From: ". $email_from ."\r\n";
		            mail($email_to, $email_subject, $email_message, $headers);
                  

                    header("Location: accountVerification.php?verifyToken=$randomString");
                     
            }
        
    }else{
        $logged = 0;
        //header("Location: logout.php");
        echo('user not authenticated');
        //exit();
    }
} 

 //Authenticate customer using cookies
else if(isset($_COOKIE['id_cookie'])){
    $session_id = $_COOKIE['id_cookie'];
    $session_pass = $_COOKIE['pass_cookie'];
    
    //check if the customer exists
    $query = $db->prepare("SELECT * FROM customer WHERE customerID = '$session_id' AND authenticationCode = '$session_pass' LIMIT 1") or die("could not check member");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
    if($count > 0){
        $logged = 1;
        foreach($result as $info){
            $session_email = $info['email'];
    }
                     
        
        //if user exists, and is authenticated, make sure account is verified before allowing user to continue shopping
         $verifyQuery = $db->prepare("SELECT * FROM customer WHERE customerID = '$session_id' LIMIT 1") or die("could not check member");
         $query->execute();
         $result = $query->fetchAll(PDO::FETCH_ASSOC);
         $count = count($result);
         
         //verify user
         if($count > 0){
            foreach($result as $info){
                $verified = $info['verified'];
            }
        
            if ($verified==1){//account verified, redirect home and flash account verification success once
            
            
            }else{//send verification code to email and ask user to check email for verification code
                    $length = 30;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $db = connect();
                    $verifyQuery = $db->prepare("UPDATE customer SET verifyToken=? WHERE email=?") or die("Could not send verification token");
                    $verifyQuery->execute(array($randomString, $session_email));
                    $customerID = $db->lastInsertId();
                    mkdir("customers/$customerID",0755);
                    $message = "Thank you for signing up with NBGardens Web!"; 
                    
                    //send verification email
                    include('verifyEmail.php');
                    header("Location: accountVerification.php?verifyToken=$randomString&username=$username&pass=$pass");
                     
            }
        
        }else{
            //if user info inaccurate, send to logout page and request login
            $logged = 0;
            header("Location: logout.php");
            exit();
        }
    }else{
    //if the user is not logged in
    $logged = 0;
    //header("Location: logout.php");
        echo('user not authenticated');
        //exit();
    
    }
}
?>