<?php
    require('../local/connect.php');
    $message = "";
    $db = connect();
     if(isset($_POST['email'])){
         $email =$_POST['email'];
         $pass = $_POST['pass'];
         $remember = $_POST['remember'];
         
         //error handling
         if((!$email)||(!$pass)){
             $message = 'Please enter email AND password';
         }else{
             //secure the data
             $pass = $pass;
             $query = $db->prepare("SELECT * FROM customer WHERE email = '$email' AND authenticationCode = '$pass' LIMIT 1") or die("Could not check customer info");
             $query->execute();
             $result = $query->fetchAll(PDO::FETCH_ASSOC);
             
             $count_query = count($result);
             
             if($count_query == 0){
                    $message = 'username and password do not match';
                    //header("Location:logout.php");
                }else{
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
     }
   
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Login to NBGardens Web Portal</title>
        <link rel="stylesheet" href="global.css" type="text/css" />  
    </head>
    <body>
      	<div class="container">
			  <h1>Welcome to the NB Gardens Login!</h1>
              <p><?php echo $message; ?></p>
                <div id="login_form">
                   <form action="login.php" method="post">
                       <input type="text" name="email" placeholder="Enter Email"/><br/>
                       <input type="password" name="pass" placeholder="Enter Password"/><br/>
                       <input type="checkbox" name="remember" value="yes" checked="checked" />Remember me?<br />
                       <input type="submit" name="Login!" />
                   </form>
                </div>
		</div>
    </body>
</html>