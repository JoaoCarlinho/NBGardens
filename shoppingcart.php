<?php
include('sessionStatus.php');
//find out if the customer has a cart with a statusCode of 1
    /**First need to read the user id from the session**/
    if(isset($_SESSION['customerID'])){
    /**Second step is to query shopping_cart for items where customerID = $POST['customerID'];**/
       
        $customerID = $_SESSION['customerID'];
        $query = $db->prepare("SELECT * FROM shopping_cart WHERE customerID = ".$_SESSION['customerID']." AND cartStatus = 1") or die("could not shopping carts");
        $query->execute();
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        $count = count($row);
        
        if($count > 0){
                //If user has an active cart, put into an array
                $cart = array();
                //read each returned item's info
                 foreach($row as $info){
                    $storedItemID=$info['productID'];
                    $storedItemName=$info['productName'];
                    $storedItemPrice=$info['retailPrice'];
    	            $storedItemQuantity=$info['quantityNonPorous']; //set quantity
    	        //put items into a basket for use today    
    	            $creator[0]=$storedItemID;
    	            $creator[1]=$storedItemName;
    	            $creator[2]=$storedItemPrice;
    	            $creator[3]=$storedItemQuantity;
    	            $cart[]=$creator;                  
                 }
        }
          
        //add an item to a new cart 
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
                    $addedItemID=$info['productID'];
                    $addedItemName=$info['productName'];
                    $addedItemPrice=$info['retailPrice'];
                }
	        $temp[0]=$addedItemID;
	        $temp[1]=$addedItemName;
	        $temp[2]=$addedItemPrice;
	        $temp[3]= 1;
	        $cart[]=$temp;
	        $query = $db->prepare("INSERT INTO shopping_cart (customerID, productID, retailPrice, quantityNonPorous,  cartStatus) VALUES(?, ?, ?, ?, ?)") or die("could not search");
            $query->execute(array($_SESSION['customerID'], $addedItemID, $addedItemPrice, 1, 1));   
        }
    }
    
//Add an item to an existing cart
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
                $addedItemID=$info['productID'];
                $addedItemName=$info['productName'];
                $addedItemPrice=$info['retailPrice'];
            }
            
	        $temp[0]=$addedItemID;
	        $temp[1]=$addedItemName;
	        $temp[2]=$addedItemPrice;
	        $temp[3]= 1;
	        $cart[]=$temp;
	        $query = $db->prepare("INSERT INTO shopping_cart (customerID, productID, retailPrice, quantityNonPorous,  cartStatus) VALUES(?, ?, ?, ?, ?)") or die("could not search");
            $query->execute(array($_SESSION['customerID'], $addedItemID, $addedItemPrice, 1, 1));
	    }
            //increment quantity for product already in cart
	    else{
            
	        $cart[$index][3]++;
	    
	       $query = $db->prepare("UPDATE shopping_cart SET quantityNonPorous = ".$cart[$index][3]." WHERE productID = ".$_GET['id']." AND cartStatus = 1") or die("could not search");
            $query->execute();
            echo$info['productName']." successfully added to cart!";
       }
}


//Remove items from the cart at the index from _GET request***************
if(isset($_GET['index'])){
         //If user has an active cart, put into an array
            $cart = array();
            $query = $db->prepare("SELECT * FROM shopping_cart WHERE customerID = " + $_SESSION['customerID'] + " AND cartStatus = 1") or die("could not shopping carts");
            $query->execute();
             $row = $query->fetchAll(PDO::FETCH_ASSOC);
                $count = count($row);
            //read each returned item's info
             foreach($row as $info){
                $storedItemID=$info['productID'];
                $storedItemName=$info['productName'];
                $storedItemPrice=$info['retailPrice'];
	            $storedItemQuantity=$info['NonPorousQuantity']; //set quantity
	        //put items into a basket for use today    
	            $creator[0]=$addedItemID;
	            $creator[1]=$addedItemName;
	            $creator[2]=$addedItemPrice;
	            $creator[3]=$addedItemQuantity;
	            $cart[]=$creator;
             }
	       //remove product from array
         unset($cart[$_GET['index']]);
         $cart = array_values($cart);
        
         
     }
     
//send cart to checkout page if link for checkout is clicked
    if(isset($_GET['cartStatus']))
            $query = $db->prepare("UPDATE shopping_cart SET cartStatus = 0 WHERE customerID = ".$_SESSION['customerID']) or die("could not search");
            //order should be sent to customer_order_line
            $query->execute();
            $_SESSION['cart'] = $cart;
            $s = 0;
            
            for($ci=0; $ci<count($cart); $ci++){
                $s += $cart[$ci][2] * $cart[$ci][3];
            }
                $_SESSION['orderTotal'] = $s;
            
             header("Location:checkout.php");

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
                <td><a href="shoppingcart.php?index=<?php echo $index;?>" onclick"return confirm('Are you sure')">Deleted</a></td>
                <td><?php echo $cart[$ci][0]; ?></td> 
                <td><?php echo $cart[$ci][1]; ?></td> 
                <td><?php echo $cart[$ci][2]; ?></td> 
                <td><?php echo $cart[$ci][3]; ?></td> 
                <td><?php echo $cart[$ci][2] * $cart[$ci][3]; ?></td> 
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
<a href ="warehouse.php?$cartStatus = 0&$customerID=$_SESSION['customerID']">Checkout!</a>

