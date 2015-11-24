<?php 
    //sees if the session is still active and user is still logged in

    require("common.php"); 
    if(empty($_SESSION['user'])) 
    {  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    }
    //calls the PHP function to save to the database
    require("update_filename.php"); 
    add_file();
?>
