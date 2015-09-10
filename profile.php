<?php
require('../local/connect.php');
$db = connect();

if($_logged==0){
    echo("Must log in to view profiles");
    exit();
}

if(isset($_GET['customerID'])){
    $customerID = $GET["customerID"];
    $customerID = preg_replace("#[0-9]#","",$customerID);
}else{
    $customerID = $_SESSION['customerID'];
}

//collect member information
$query = $db->prepare("SELECT * FROM customer WHERE customerID = '.$customerID.' LIMIT 1") or die("could not collect user informtion");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$count_mem = count($result);
if($count_mem ==0){
    echo("Member not found!");
    exit();
}
foreach($result as $info){
    $email = $info['email'];
    $fname = $info['firstName'];
    $lname = $info['lastName;'];
    $profile_id = $info['customerID'];
    
    if($session_id == $profile_id){
        $owner = true;
    }else{
        $owner = false;
    }
    
}

?>

<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <title><php? echo $firstname." ".$lastname;."'s profile" ?></title>
        <link rel="stylesheet" href="index.css" type="text/css" />
        <link rel="stylesheet" href="inventory.css" type="text/css" />
        <link rel="stylesheet" href="productInfo.css" type="text/css" />
        <link rel="stylesheet" href="carousel.css" type="text/css" />
        
    </head>
    <body>
        <?php include('header.php'); ?>
        
        <?php include('searchBar.php'); ?>
        <div class="container">
            <h1><?php echo("email")?></h1>
            <?php
            if($owner==true){
            ?>
            <a href="#">edit profile</a><br/>
            <a href="#">acount settings</a>
            <?php
            }else{
            ?>
            <a href="#">private message</a><br/>
            <a href="#">add as a friend</a>
            <?php
            }
            ?>
        </div>
        
        <?php include('footer.php'); ?>
        <script type="text/javascript" src="carousel.js"></script>
    </body>
</html>