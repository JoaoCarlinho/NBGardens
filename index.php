<?php
include_once('global.php');
if($logged ==1){
    header("Location:home.php");
    exit();
}

require_once('../local/connect.php');
include('product.php');
$output = '';
$db = connect();
if(isset($_POST['search'])){
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
        <link rel="stylesheet" href="index.css" type="text/css" />
        <link rel="stylesheet" href="inventory.css" type="text/css" />
        <link rel="stylesheet" href="productInfo.css" type="text/css" />
        <link rel="stylesheet" href="carousel.css" type="text/css" />
        
    </head>
    <body>
        <?php include('header.php'); ?>
        
        <?php include('searchBar.php'); ?>
        <div>
            <div style="height:20px; width:200px; margin:0 auto 0 auto;"><?php echo("$resultCount")?>
        </div>
        
        <div id="main_slider">
                <a href="NBGardensInventory.php"><img id="imagen" src="images/nbWebBanner.jpg" alt="" style="width:700px; height:570px; z-index:-1;"></a>
                <div id="left_holder"><img onclick="slide(-1)" src="images/gnomeButton.png" alt="previous product" style="width:100px; height:100px; "></div>
                    
                <div id="right_holder"><img onclick="slide(1)" src="images/gnomeButton.png" alt="next product" style="width:100px; height:100px; "></div>
                    
        </div>
        <div><?php echo("$output")?>
        </div>
        
        <?php include('footer.php'); ?>
        <script type="text/javascript" src="carousel.js"></script>
    </body>
</html>