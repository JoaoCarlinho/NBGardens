<?php
require('../local/connect.php');
$db = connect();
//find out if the customer has a cart with a statusCode of 1
    /**First need to read the user id from the POST method**/
    
    /**Second step is to query shopping_cart for a cart where customerID = $POST['customerID'];**/
    if(isset($POST['customerID'])){
        $customerID = $_POST['customerID'];
        $query = $db->prepare("SELECT * FROM shopping_cart WHERE customerID = ".$_POST['customerID']." AND cartStatus = 1") or die("could not shopping carts");
        $query->execute();
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        $count = count($row);
        //build a cart if a productID was sent in the POST request
        if(isset($POST['id'])){
            if($count == 0){
                echo('No active carts for user');
                //If no cart for current user initialize empty cart
                //Initialize empty cart
                $cart = array();
            }else{
                //If user has an active cart, put into an array
                $cart = array();
                //read each returned item's info
                 foreach($row as $info)
                    $storedItemID=$info['productID'];
                    $storedItemName=$info['productName'];
                    $storedItemPrice=$info['retailPrice'];
    	            $storedItemQuantity=$info['NonPorousQuantity']; //set quantity
    	            $cartCreateDate = $info['createDate'];
    	        //put items into a basket for use today    
    	            $creator[0]=$addedItemID;
    	            $creator[1]=$addedItemName;
    	            $creator[2]=$addedItemPrice;
    	            $creator[3]=$addedItemQuantity;
    	            $cart[]=$creator;
            }
        }
    }
    
//Add an item to the cart
if(isset($_GET['id'])){
    $cartIndex = count($cart) -1;
    $query = $db->prepare("SELECT * FROM inventory WHERE productID = ".$_GET['id']) or die("could not search");
    $query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
     
     foreach($result as $info)
        $addedItemID=$info['productID'];
        $addedItemName=$info['productName'];
        $addedItemPrice=$info['retailPrice'];
	    $addedItemQuantity=1; //set quantity
	    
	    $index = -1;
	    for($ci=0; $ci<count($cart); $ci++)
	        if($cart[$ci][0]==$_GET['id']){
	            $index=$ci;
	            break;
	        }
	    if($index==-1){
	        $temp[0]=$addedItemID;
	        $temp[1]=$addedItemName;
	        $temp[2]=$addedItemPrice;
	        $temp[3]=$addedItemQuantity;
	        $cart[]=$temp;
	    }
	    else{
	        $cart[$index][3]+=1;
	    }
	    $query = $db->prepare("INSERT INTO shopping_cart (NonPorousQuantity, lastUpdate) VALUES(".$addedItemQuantity.",".date('Y-m-d H:i:s').") WHERE customerID = ".$_GET['id']) or die("could not search");
        $query->execute();
        echo$info['productName']." successfully added to cart!";
}


//Remove items from the cart at the index from _GET request***************
if(isset($_GET['index'])){
         //If user has an active cart, put into an array
            $cart = array();
            $query = $db->prepare("SELECT * FROM shopping_cart WHERE customerID = " + $_POST['customerID'] + " AND cartStatus = 1") or die("could not shopping carts");
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
//if cart has been initialized
/** Function to retrieve info from storage**/
//search carts and return cart with customerID that hasn't been submitted

/**Update database with cart info upon page exit**/


?>
<table cellpadding="2" cellspacing="2" border="1">
    <tr>
        <th>option</th><th>Id</th><th>Name</th><th>Price</th><th>Quantity</th><th>Sub Total</th>
    </tr>
    
    <tr>
        <?php
            $s = 0;
            $index = 0;
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
            $index++;
        }?>
    </tr>
    <tr>
        <td colspan="4" align="right">Sum</td>
        <td align="left"><?php echo $s; ?></td>
    </tr>
</table>
<br>
<a href ="warehouse.php">Continue Shopping</a>


/**Ensure Order form updates cart status to submitted **/