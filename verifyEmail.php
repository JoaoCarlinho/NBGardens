<?					
					//send verification email
                    $email_from = "accounts@NBGardens.com";
    		        $email_subject = "NBGardens Customer Portal Account Verification";
 		            $email_to=$session_email;
 
    		        $comments = 'Congratulations! \n
                        You are ready to verify your account for\n
                        NBGardens Customer Portal!

                        Please click on the link below to verify your account and begin shopping with NBGardens\n\n
                        
                        <h4><a href="accountVerification.php?verifyToken=<?php echo $randomString ?>&username=<?php echo $username ?>&pass=<?php echo $pass ?>"></h4>';
    
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
?>