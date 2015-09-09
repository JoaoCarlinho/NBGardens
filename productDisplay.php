<?php
    require('product.php');
    $productID = $_GET['productID']; 
    
    require('../local/connect.php');
    $db = connect();
    $getquery = $db->prepare("SELECT productName, retailPrice, productDescription FROM inventory WHERE productID = :productID"); 
    $getquery->bindParam(':productID', $productID);
    $getquery->execute(); 
    $result = $getquery->fetchAll(PDO::FETCH_ASSOC);
    
           $pageProduct = new Product($result[0]);
       
        
   $result = null;   
    
    include('productTemplate.php');
    
    
    
    
    
?>