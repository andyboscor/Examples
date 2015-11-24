<?php 
 	//stops active session and redirects user to login page
    require("common.php");     
    unset($_SESSION['user']); 
    header("Location: login.php"); 
    die("Redirecting to: login.php");
?>