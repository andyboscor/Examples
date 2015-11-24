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

function update_category(){
	//This function updates the report categories in the Imaging box
	$id = $_GET['selectable'];
	$db = establish_mysql_connection();

	$mysql_query = $db->prepare("SELECT * FROM `boxes_selectable_content` WHERE selectable_id='$id'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();

	for($i = 0; $i < sizeof($mysql_array); $i++){
		print '<button type="button" onclick="updateImagingReport(' . $mysql_array[$i]['id'] . ')">' . $mysql_array[$i]['name'] . '</button>';
	}
	if(sizeof($mysql_array) == 0){
		print 'n/a';
	}
}

function update_report(){
	//This function prints all the reports in different divs connected to a specific category
	//The latest gets the biggest ID 
	$id = $_GET['category'];
	$db = establish_mysql_connection();

	$mysql_query = $db->prepare("SELECT * FROM `boxes_selectable_content` WHERE id='$id'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	$table_name = $mysql_array[0]['table_link'];
	//$
	$name = $mysql_array[0]['name'];

	$pid = $_SESSION['pid'];
	$mysql_query = $db->prepare("SELECT * FROM `$table_name` WHERE MRN='$pid' ORDER BY 3 ASC");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();

	print '<div class="dashboard_box_entry_title" class="dashboard_box_entry_long_text_title">';
	print $name;
	print '</div>';
	for($i = 0; $i < sizeof($mysql_array); $i++){
		print "<div id='dashboard_box_imaging_report" . $i . "'";
		print ($i + 1 == sizeof($mysql_array)) ? "" : " style='display:none;' ";
		print "date='" . $mysql_array[$i][2] . "'>";
		print $mysql_array[$i][3];
		print "</div>";
	}
}

//Main
if(isset($_GET['selectable'])){
	update_category();
} else if (isset($_GET['category'])){
	update_report();
}