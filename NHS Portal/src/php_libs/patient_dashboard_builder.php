<?php


function patient_dashboard_builder(){
	try 
	{ 
	    $db = new PDO("mysql:host=localhost;dbname=NHS;charset=utf8", "portal_user", ""); 
	} 
	catch(PDOException $ex) 
	{ 
	    die("Failed to connect to the database: " . $ex->getMessage()); 
	}
	$user=$_SESSION['user'];
	$id = $_SESSION['pid'];
	$mysql_query = $db->prepare("SELECT * FROM `saved_dashboards` where `user` = '".$user["username"]."' and `id` = '".$id."'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	foreach($mysql_array as $val)
		{ 
		print "<button type=\"button\" onclick=\"window.location.replace('update_session.php?boxes=".$val["boxes"]."_')\"";
		print ">";
		print $val["name"];
		print "</button> <br />\n";
	}
}