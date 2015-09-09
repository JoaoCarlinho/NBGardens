<?php
session_start();
require('../local/connect.php');
include('product.php');
$output = '';
if(isset($_POST['search'])){
    $db = connect();
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
    $query = $db->prepare("SELECT * FROM inventory WHERE productName LIKE '%$searchq%' OR retailPrice LIKE '%$searchq%' OR color LIKE '%$searchq%'") or die("could not search");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
    if($count == 0){
        $resultCount = 'No results found';
    }else{
        $resultCount=$count.' matches found';
        foreach($result as $info){
            $productNumber = $info['productID'];
            $productString = $info['productName'];
            $productPrice = $info['retailPrice'];
            $productColor = $info['color'];
            $Description = $info['productDescription'];
            
            $output .= '<a href="productDisplay.php?productID='.$productNumber.'" > <div style="height:75px; width:400px; margin:0 auto 0 auto; font:25px bold;"> <img src="images/'.$productNumber.'.jpg" alt="'.$Description.';" height="50px" width="50px">'.$productString.': '.$productColor.': $'.$productPrice.'</div></a>';
        }
    }     
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
        <div class="header">
            <div class="logoLeft">
            
            </div>
            <div class="accountSection">
                <a href="login.php">Login</a>|<a href="register.php">Register</a>
            </div>
        
        </div>
        
        <div class="searchBar">
            <form action="index.php" method="post">
                <div style="  width:343px;  position:absolute; top:0px; left:0px;">
                    <input type="text" name="search" placeholder="Search NB Gardens" size="41"/>
                </div>
                <div style=" width:57px; position:absolute; top:8px; right:0px;">
                    <input type="submit" value="Search"/>
                </div>
            </form>
        </div>
        <div>
            <div style="height:20px; width:200px; margin:0 auto 0 auto;"><?php echo("$resultCount")?>
        </div>
        
        <div id="main_slider">
                <a href="#"><img id="imagen" src="images/nbWebBanner.jpg" alt="" style="width:700px; height:570px; z-index:-1;"></a>
                <div id="left_holder"><img onclick="slide(-1)" src="images/gnomeButton.png" alt="previous product" style="width:100px; height:100px; "></div>
                    
                <div id="right_holder"><img onclick="slide(1)" src="images/gnomeButton.png" alt="next product" style="width:100px; height:100px; "></div>
                    
        </div>
        <div><?php echo("$output")?>
        </div>
        
        <div class="footer">
            
            <div class="indexFoot">
                <div class="indexInfo">Place company info in this box along with link to home page
            
                </div>
            </div>
        </div>
        <script type="text/javascript" src="carousel.js"></script>
    </body>
</html>