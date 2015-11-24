<?php
function establish_mysql_connection(){
	try 
    { 
        $db = new PDO("mysql:host=localhost;dbname=NHS;charset=utf8", "portal_user", ""); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to connect to the database: " . $ex->getMessage()); 
    }
    return $db;
}

function get_boxes(){
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes`");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	foreach($mysql_array as $line){
		print '<option value="' . $line[0] . '">';
		print $line[1];
		print '</option>';
	}
}

function get_selectables(){
	$box = $_GET['box'];
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes_selectable` WHERE box_id=$box");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	foreach($mysql_array as $line){
		print '<option value="' . $line[0] . '">';
		print $line[2];
		print '</option>';
	}
}

//MAIN

if(isset($_GET['box'])){
	get_selectables();
} else if(isset($_GET['new'])){
	get_boxes();
}