<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    {  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    }
    require("update_filename.php"); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>portal - Log in</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/filename.css" type="text/css" rel="stylesheet" />
        <script src="src/script/login.js" type="text/javascript"></script>
    </head>
    <body>
    <body>
        <div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
        <div id="filename">
            <form name="filename" action="save_as.php">
                <div id="filename_id"><input type="text" name="Filename" value="Filename" id="login_id_input" onfocus="clearInput(this, 'Filename')" onblur="checkInput(this, 'Filename')"/> </div>
                <button type="submit" style="margin-left:-110px;" name="account" value="account">Save to account</button>
                <button type="submit" name="patient" value="patient">Save for patient </button>
            </form>

        </div>

    </body>

</html>