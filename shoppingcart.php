<?php
session_start();
require('../local/connect.php');
include('product.php');
require('item.php');
$db = connect();

if(isset($_GET['id'])){
    $query = $db->prepare("SELECT * FROM inventory WHERE productID = ".$_GET['id']) or die("could not search");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $product =  $query->fetchObject('item');
     $item = new Item();
     $item->id = $product->id;
     $item->name = $product->name;
     $item->price = $product->price;
     $item->quantity = 1;
     //Check if product is already in cart
     $index = -1;
     $cart = unserialize(serialize($_SESSION['cart']));
     for($i=0; $i<count($cart); $i++){
         if($cart[$i]->id==$_GET['id']){
             $index = $i;
             break;
         }
        if($index==-1){
            $_SESSION['cart'][] = $item;
        }else{
            $cart[$index]->quantity++;
            $_SESSION['cart'] = $cart;
        }
     }
     if(isset($_GET['action'])){
         $cart = unserialize(serialize($_SESSION['cart']));
         unset($cart[$_GET['index']]);
         $cart = array_values($cart);
         $_SESSION['cart'] = $cart;
         
     }
}
?>
<table cellpadding="2" cellspacing="2" border="1">
    <tr>
        <th>option</th><th>Id</th><th>Name</th><th>Price</th><th>Quantity</th><th>Sub Total</th>
    </tr>
    
    <tr>
        <?php $cart = unserialize(serialize($_SESSION['cart']));
            $s = 0;
            $index = 0;
            for($i=0; $i<count($cart); $i++){
                $s += $cart[$i]->price * $cart[$i]->quantity;
        ?>
            <tr>
                <td><a href="shoppingcart.php?index=<?php echo $index;?>" onclick"return confirm('Are you sure')">Deleted</a></td>
                <td><?php echo $cart[$i]->id; ?></td> 
                <td><?php echo $cart[$i]->name; ?></td> 
                <td><?php echo $cart[$i]->price; ?></td> 
                <td><?php echo $cart[$i]->quantity; ?></td> 
                <td><?php echo $cart[$i]->price * $cart[$i]->quantity; ?></td> 
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