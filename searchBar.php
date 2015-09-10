<?php
    //require('../local/connect.php');
    //include('product.php');
    $output = '';
if(isset($_POST['search'])){
    //$db = connect();
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


<html lang="en-us">
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
</html>