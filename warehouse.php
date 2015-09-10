<?php
require('../local/connect.php');
include('product.php');

$db = connect();

$query = $db->prepare("SELECT * FROM inventory") or die("could not search");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$count = count($result);
    if($count == 0){
        $countount = 'No results found';
    }else{
        echo($count.'results found');
        echo('<table cellpadding="2" cellspacing="2" border="0">
                 <tr>
                      <th>Id</th><th>Name</th><th>Price</th><th>buy</th>
                </tr>');
                foreach($result as $info){ 
                     $productID = $info['productID'];
                     $productName = $info['productName'];
                     $retailPrice = $info['retailPrice'];
?>
                <tr>
                    <td><?php echo $productID;?></td>
                    <td><?php echo $productName;?></td>
                    <td><?php echo $retailPrice;?></td>
                    <td><a href="shoppingcart.php?id=<?php echo $info['productID'];?>">Add to Cart</a></td>
                </tr> 
          <?php } ?>         
    </table>
<?php 
}
?>