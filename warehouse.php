<?php
require('../local/connect.php');
include('product.php');

$db = connect();

$query = $db->prepare("SELECT * FROM inventory") or die("could not search");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table cellpadding="2" cellspacing="2" border="0">
    <tr>
        <th>Id</th><th>Name</th><th>Price</th><th>buy</th>
    </tr>
    <?phpforeach($result as $info){?>
            <tr>
                <td><?php echo $info['productId']?></td>
                <td><?php echo $info['productName']?></td>
                <td><?php echo $info['retailPrice']?></td>
                <td><a hreft="shoppingcart.php?id=<?php echo $info['productID']?>">Add to Cart</a></td>
            </tr>
        <?php} ?>
        
</table>