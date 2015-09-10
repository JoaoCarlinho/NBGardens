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
    </head>
    <body>
      	<div>
			  <h1>Welcome to NBGardens Web Portal</h1>
              This is the logged in display
		</div>
		
		<div>
		    <a href="logout.php">Click here to logout</a>
		</div>
    </body>
</html>