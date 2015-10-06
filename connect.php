<?php


function connect(){
	try{
		$db = new PDO('mysql:host=localhost;dbname=nbgardens_warehouse_database;charset=utf8', 'root', 'netbuilder');
		// set the PDO error mode to exception
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		return $db;
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}
}
	
	
	
?>