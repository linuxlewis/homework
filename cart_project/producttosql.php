<?php
    require_once 'conn.php';
	//load XML file
	$xml = simplexml_load_file('products.xml') or die ('Unable to load XML');
	
	//loop over XML elements
	foreach ($xml as $item) {
		$sql = "INSERT INTO store_product (product_name,product_description,product_price,product_image) VALUES ('" . addslashes($item->name) . "','" . addslashes($item->description) . "','" . addslashes($item->price) . "','" . base64_encode(file_get_contents($item->image)) . "');";
        mysql_query($sql,$conn) or die('query failed');
	}

?>
