<?php

function selector_builder(){
	try 
	{ 
	    $db = new PDO("mysql:host=localhost;dbname=NHS;charset=utf8", "portal_user", ""); 
	} 
	catch(PDOException $ex) 
	{ 
	    die("Failed to connect to the database: " . $ex->getMessage()); 
	}

	$mysql_query = $db->prepare("SELECT * FROM `boxes`");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	$size = sizeof($mysql_array);
	// $boxes = $_SESSION['boxes'];

	for($i = 0; $i < $size; $i++){
		print "<button class=\"boxes\" id=\"" . $mysql_array[$i]['id'] . "\" type=\"button\"";
		// print (in_array(1, $boxes) ? "class=\"active\"" : "");
		print ">";
		print $mysql_array[$i]['name'];
		print "</button>\n";
	}
}