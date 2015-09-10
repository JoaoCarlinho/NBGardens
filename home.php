<?php
    require('../local/connect.php');
    $message = "";
    $db = connect();
    if($logged ==0){
    header("Location:index.php");
    exit();
    }

   
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>NBGardens Web Portal </title>
        <link rel="stylesheet" href="global.css" type="text/css" /> 
        <link rel="stylesheet" href="index.css" type="text/css" />
        <link rel="stylesheet" href="inventory.css" type="text/css" />
        <link rel="stylesheet" href="productInfo.css" type="text/css" />
        <link rel="stylesheet" href="carousel.css" type="text/css" />
    </head>
    <body>
         <?php include('header.php'); ?>
         <div>
		    <a href="logout.php">Click here to logout</a>
		</div>
        
        <?php include('searchBar.php'); ?>
      	<div>
			  <h1>Welcome to NBGardens Web Portal</h1>
              This is the logged in display
		</div>
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