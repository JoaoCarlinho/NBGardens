<?php
    include('global.php');
    require_once('../local/connect.php');
    $db = connect();
    if(isset($_SESSION['email'])&&isset($_SESSION['customerID'])){
        echo("User ".$_SESSION['email']." logged in with id: ".$_SESSION['customerID']);
    }
    else{
        header("Location:logout.php");
    }
   
?>