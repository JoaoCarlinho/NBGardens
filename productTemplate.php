<?php
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $name=$_POST['name'];
        $comment=$_POST['comment'];         
            if($name &&$comment)
            {
                $sql="INSERT INTO comment (name, comment) VALUES ('$name','$comment')";
                $db->exec($sql);
                echo"Post Successful!";
            }else
            {
            echo "Please insert a name and comment";
            }
        
    }
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
<meta charset="utf-8">
<title><?php echo $pageProduct->productName; ?></title>
<link rel="stylesheet" href="productInfo.css" type="text/css" />
</head>

<body>
    <?php include('header.php'); ?>
    
    <?php include('searchBar.php'); ?>
    <div class ="productSection" id="mainContent">
        <div class="productImage"><?php echo $pageProduct->productName; ?><br>
             <img src="images/<?php echo $productID; ?>.jpg" alt="<?php echo $pageProduct->productDescription; ?>" height="400" width="400">
            <?php echo $pageProduct->productDescription; ?><br>
            $<?php echo $pageProduct->price; ?><br>
            <a href="shoppingcart.php?id=<?php echo $productID ?>"><div style="height:100px; width:300px background-color:orange;">Add to Cart</div></a>
            
        </div>
        
        <div class="addCartBox">Mini-Cart  displayed here
            
        </div>
        
        
    </div>
    <div class="footer">
        
        <div class="leftFoot">
        	<form action="index.php" method="POST">
				<table>
						<tr>
							<td>Name:</td><td><input type="text" name="name"/></td>
						</tr>
						<tr>	
							<td colspan="2">Comment:</td>
						</tr>
						<tr>	
							<td colspan="2"><textarea name="comment"></textarea></td>
						</tr>
						<tr>	
							<td colspan="2"><input type="submit" name="submit" value="comment"/></td>
						</tr>			
				</table>	    
            </form>
            
                <?php
                    echo "<table style='border: solid 1px black;'>";
                    echo "<tr>
                            <th>date</th>
                            <th>name</th>
                            <th>comment</th>
                          </tr>";

                 class TableRows extends RecursiveIteratorIterator { 
                    function __construct($it) { 
                        parent::__construct($it, self::LEAVES_ONLY); 
                    }

                    function current() {
                        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
                    }

                    function beginChildren() { 
                        echo "<tr>"; 
                    } 

                    function endChildren() { 
                        echo "</tr>" . "\n";
                    } 
                } 
                $getquery = $db->prepare("SELECT * FROM comment ORDER BY commentDate DESC"); 
                $getquery->execute();
                //set the resulting array to associative
                $result = $getquery->setFetchMode(PDO::FETCH_ASSOC);
                foreach(new TableRows(new RecursiveArrayIterator($getquery->fetchAll())) as $k=>$v)
                {
                    echo $v;
                }
                echo "</table>";
            ?>
            
            
        </div>
        <div class="rightFoot">
            <div class="companyInfo">Place company info in this box along with link to home page
            
            </div>
        </div>
    
       
        
    </div>
    <?php
        $db = null;
    ?>
        
</body>
</html>