<?php 
class Product {
	//property declarations
	public $productID = 1;
	public $productName = 'flipping Gnome';
	public $price = 20;
	public $productDescription = 'Gnome Flipping the Bird' ;
	//method declarations
	function __construct(array &$row = NULL){
		$this->productID = isset($row['productID']) ? $row['productID'] : NULL;
		$this->productName = isset($row['productName']) ? $row['productName'] : NULL;
		$this->price = isset($row['retailPrice']) ? $row['retailPrice'] : NULL;
		$this->productDescription = isset($row['productDescription']) ? $row['productDescription'] : NULL;
		
	}
	
}

?>