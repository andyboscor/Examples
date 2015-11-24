<?php
session_start();
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

//Update dashboard boxes
if(isset($_GET['boxes'])){
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes`");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();

	$selected_boxes = $_GET['boxes'];
	$_SESSION['fullbox'] = $selected_boxes;
	$selected_boxes = explode('_', $selected_boxes);
	array_pop($selected_boxes);

	for($i = 0; $i < sizeof($selected_boxes); $i++){
		$j = 0;
		$found = 0;

		for($j = 0; $j < sizeof($mysql_array); $j++){
			if($mysql_array[$j]['id'] == $selected_boxes[$i]){
				$found = 1;
				break;
			}
		}

		if($found == 0){
			array_splice($selected_boxes, $i, 1);
			$i--;
		}
	}

	$_SESSION['boxes'] = $selected_boxes;
	header("Location: dashboard.php");
	die();
}