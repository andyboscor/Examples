<?php
// function that saves the file to the account or the 
function add_file(){
	//connects to the database
    try 
    { 
        $db = new PDO("mysql:host=localhost;dbname=NHS;charset=utf8", "portal_user", ""); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to connect to the database: " . $ex->getMessage()); 
    }
    //gets information from session
    $user=$_SESSION['user'];
	$boxes = $_SESSION['fullbox'];
	$file = $_GET["Filename"];
    $pid = $_SESSION['pid'];
    //once user presses to save to account the first if statement is executed and the database is updated
    if(isset($_GET["account"]))
    {
	$mysql_query = $db->prepare("INSERT INTO `saved_dashboards` (user, id, boxes, name) VALUES ('".$user["username"]."','0', '".$boxes."', '".$file."')");
	$mysql_query->execute();
    }
    //if the user presses to save for patient, the database is updated with the saved dashboard for the specific patient
    if(isset($_GET["patient"]))
    {
    $mysql_query = $db->prepare("INSERT INTO `saved_dashboards` (user, id, boxes, name) VALUES ('".$user["username"]."','".$pid."', '".$boxes."', '".$file."')");
    $mysql_query->execute();
    }
	header("Location: initialize.php");
	//die();
}