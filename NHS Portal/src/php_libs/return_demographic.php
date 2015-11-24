<?php
function return_demographic($id, $col){
	try 
    { 
        $db = new PDO("mysql:host=localhost;dbname=NHS;charset=utf8", "portal_user", ""); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 

	$mysql_query = $db->prepare("SELECT * FROM `Patients` WHERE ID='$id'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	return $mysql_array[0][$col];
}