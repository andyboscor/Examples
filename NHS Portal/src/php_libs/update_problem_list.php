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

if(isset($_GET['content'])){
	session_start();
	$pid = $_SESSION['pid'];
	$db = establish_mysql_connection();
	$content = $_GET['content'];

	$mysql_queryc = $db->prepare("SELECT * FROM `problem_list` WHERE patient_id=$pid");
	$mysql_queryc->execute();
	$mysql_arrayc = $mysql_queryc->fetchAll();
	if(sizeof($mysql_arrayc) == 0){
		$mysql_query = $db->prepare("INSERT INTO problem_list (patient_id, content) VALUES (?, ?)");
		$mysql_query->execute(array($pid, $content));
	} else {
		$mysql_query = $db->prepare("UPDATE problem_list SET content=? WHERE patient_id=?");
		$mysql_query->execute(array($content, $pid));
	}
}