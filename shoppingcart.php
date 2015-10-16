<?php
include('sessionStatus.php');
    /**Read the user id from the session.  If no user iD read, skip to line 85**/
    if(isset($_SESSION['customerID'])){
        $customerID = $_SESSION['customerID'];
        
        //Remove items from the cart at the index from _GET request***************
        if(isset($_GET['index']) && isset($_GET['productID'])){
            echo('product ID = '.$_GET['productID'].', index = '.$_GET['index']);
            //remove product from array and set quantity for product to 0 in shopping cart in database
            $sql =("DELETE FROM shopping_cart WHERE productID = ?");
            $stmt = $db->prepare($sql);
            $stmt->execute(array($_GET['productID']));
            
            //Put cart into an array
            $cart = array();
            $query = $db->prepare("SELECT * FROM shopping_cart WHERE customerID = ".$_SESSION['customerID']." AND cartStatus = 1") or die("could not shopping carts");
            $query->execute();
            $row = $query->fetchAll(PDO::FETCH_ASSOC);
            $count = count($row);
            //read each returned item's info
             foreach($row as $info){
	        //put items into a basket for use today    
	            $creator[0]=$info['productID'];;
	            $creator[1]=$info['productName'];
                echo('putting '.$info['productName'].' into basket');
	            $creator[2]=$info['retailPrice'];
	            $creator[3]=$info['quantityNonPorous'];
	            $cart[]=$creator;
             } 
     }
     
     
     
    /**Query shopping_cart for items where customerID = $SESSION['customerID'];**/
        $query = $db->prepare("SELECT * FROM shopping_cart WHERE customerID = ".$_SESSION['customerID']." AND cartStatus = 1") or die("could not shopping carts");
        $query->execute();
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        $count = count($row);
        
        if($count > 0){
                //If user has an active cart, put into an array
                $cart = array();
                //read each returned item's info
                 foreach($row as $info){     
    	        //put items into a basket for use today    
    	            $creator[0]=$info['productID'];
    	            $creator[1]=$info['productName'];
    	            $creator[2]=$info['retailPrice'];
    	            $creator[3]=$info['quantityNonPorous'];
    	            $cart[]=$creator;                  
                 }
        }
          
        //add an item to an empty cart 
        else if(isset($_GET['id']) && ($count == 0)){
            echo('creating new cart for user'.$_SESSION['customerID'].' adding product #'.$_GET['id'].' to cart!');

               echo('No active carts for user');
                //Initialize empty cart
                $cart = array();
                
                $query = $db->prepare("SELECT * FROM inventory WHERE productID = ".$_GET['id']) or die("could not search");
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                //loop through retreived info and assign it to variables
                foreach($result as $info){
                   $temp[0]=$info['productID'];
	               $temp[1]=$info['productName'];
	               $temp[2]=$info['retailPrice'];
                }
	        $temp[3]= 1;
	        $cart[]=$temp;
	        $query = $db->prepare("INSERT INTO shopping_cart (customerID, productID, retailPrice, quantityNonPorous,  cartStatus, productName) VALUES(?, ?, ?, ?, ?, ?)") or die("could not search");
            $query->execute(array($_SESSION['customerID'], $info['productID'], $info['retailPrice'], 1, 1, $info['productName']));   
        }
    }
    
//Add items to an existing cart
if(isset($_GET['id']) &&isset($_SESSION['customerID']) && $count >0){
 
      
        //determine if the cart already has a product with same ID inside
	    echo 'checking for items already in cart ';
        $index = -1;
	    for($ci=0; $ci<count($cart); $ci++)
	        if($cart[$ci][0]==$_GET['id']){
                echo('product exists in cart');
	            $index=$ci;
	            break;
	        }
            //make new row in column if no item currently in cart with same id
	    if($index==-1){
            
             echo('Adding new item in cart for user '.$_SESSION['customerID']);
            //retrieve product info from database
            $query = $db->prepare("SELECT * FROM inventory WHERE productID = ".$_GET['id']) or die("could not search");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
             //loop through retreived info and assign it to variables
            foreach($result as $info){
               $temp[0]=$info['productID'];
	           $temp[1]=$info['productName'];
	           $temp[2]=$info['retailPrice'];
            }
	        $temp[3]= 1;
	        $cart[]=$temp;
	        $query = $db->prepare("INSERT INTO shopping_cart (customerID, productID, retailPrice, quantityNonPorous,  cartStatus, productName) VALUES(?, ?, ?, ?, ?, ?)") or die("could not search");
            $query->execute(array($_SESSION['customerID'], $info['productID'], $info['retailPrice'], 1, 1, $info['productName']));
	    }
            //increment quantity for product already in cart
	    else{
            
	        $cart[$index][3]++;
	    
	       $query = $db->prepare("UPDATE shopping_cart SET quantityNonPorous = ".$cart[$index][3]." WHERE productID = ".$_GET['id']." AND cartStatus = 1") or die("could not search");
            $query->execute();
            echo$info['productName']." successfully added to cart!";
       }
}

     
//send cart to checkout page if link for checkout is clicked
    if(isset($_GET['cartStatus'])){
            
            $_SESSION['cart'] = $cart;
            $s = 0;
            
            for($ci=0; $ci<count($cart); $ci++){
                $s += $cart[$ci][2] * $cart[$ci][3];
            }
                $_SESSION['orderTotal'] = $s;
            
            header("Location: checkout.php");
    }

?>
<table cellpadding="2" cellspacing="2" border="1">
    <tr>
        <th>option</th><th>Id</th><th>Name</th><th>Price</th><th>Quantity</th><th>Sub Total</th>
    </tr>
    
    <tr>
        <?php
            $s = 0;
            
            for($ci=0; $ci<count($cart); $ci++){
                $s += $cart[$ci][2] * $cart[$ci][3];
        ?>
            <tr>
                <td><a href="shoppingcart.php?index=<?php echo $ci;?>&productID=<?php echo $cart[$ci][0];?>" onclick"return confirm('Are you sure')">Delete</a></td>
                <td><?php echo $cart[$ci][0]; ?></td><!-- productID -->
                <td><?php echo $cart[$ci][1]; ?></td><!-- productName --> 
                <td><?php echo $cart[$ci][2]; ?></td><!-- retailPrice --> 
                <td><?php echo $cart[$ci][3]; ?></td><!-- quantityNonPorous --> 
                <td><?php echo $cart[$ci][2] * $cart[$ci][3]; ?></td><!-- Total for this product --> 
            </tr>
        <?php   
            }
        ?>
    </tr>
    <tr>
        <td colspan="4" align="right">Sum</td>
        <td align="left"><?php echo $s; ?></td>
    </tr>
</table>
<br>
<a href ="warehouse.php">Continue Shopping</a>
<a href ="shoppingcart.php?cartStatus=0&customerID=<?php echo $_SESSION['customerID']?>">Checkout!</a>

