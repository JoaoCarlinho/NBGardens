<?php
session_start();
require_once('../local/connect.php');
//checking if the sessions are set
if(isset($_SESSION['pass'])){
    $session_email = $_SESSION['email'];
    $session_pass = $_SESSION['pass'];
    $session_id = $_SESSION['customerID'];
    
    //check if the customer exists
    $query = $db->prepare("SELECT * FROM customer WHERE customerID = '$session_id' AND authenticationCode = $Session_pass LIMIT 1") or die("could not check member");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
    if($count > 0){
        //logged in stuff here
        $logged = 1;
    }else{
        header("Location: logout.php");
        exit();
    }
} else if(isset($_COOKIE['id_cookie'])){
    $session_id = $_COOKIE['id_cookie'];
    $session_pass = $_COOKIE['pass_cookie'];
    
    //check if the customer exists
    $query = $db->prepare("SELECT * FROM customer WHERE customerID = '$session_id' AND authenticationCode = $Session_pass LIMIT 1") or die("could not check member");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
    if($count > 0){
        foreach($result as $info){
            $session_email = $info['email'];
        }
            
            
        
        //create session
        $_SESSION['email'] = $session_email;
        $_SESSION['customerID'] = $session_id;
        $_SESSION['pass'] = $session_pass;
        
    }else{
        header("Location: logout.php");
        exit();
    }
}else{
    //if the user is not logged in
    $logged = 0;
    
}
?>