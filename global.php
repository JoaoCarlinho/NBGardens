<?php
session_start();
require('../local/connect.php');
//checking if the sessions are set
if(isset($_SESSION['username'])){
    $session_username = $_SESSION['username'];
    $session_pass = $_SESSION['pass'];
    $session_id = $_SESSION['id'];
    
    //check if the customer exists
    $query = $db->prepare("SELECT * FROM customer WHERE id = '$session_id' AND authenticationCode = $Session_pass LIMIT 1") or die("could not check member");
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
    $query = $db->prepare("SELECT * FROM customer WHERE id = '$session_id' AND authenticationCode = $Session_pass LIMIT 1") or die("could not check member");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
    if($count > 0){
        foreach($result as $info){
            $session_username = $info['email'];
        }
            
            
        
        //create session
        $_SESSION['username'] = $session_username;
        $_SESSION['id'] = $session_id;
        $_SESSION['pass'] = $session_pass;
        
        //logged in stuff here
        $logged = 1;
        
    }else{
        header("Location: logout.php");
        exit();
    }
}else{
    //if the user is not logged in
    $logged = 0;
    
}
?>

<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <title>NB Gardens Web</title>
        <link rel="stylesheet" href="inventory.css" type="text/css" />
        <link rel="stylesheet" href="productInfo.css" type="text/css" />
        <link rel="stylesheet" href="carousel.css" type="text/css" />
        
    </head>
    <body>
        
    </body>
</html>