<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    {  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    }  
?>
<!DOCTYPE html>
<html>
    <head>
        <title>portal - Log in</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/login.css" type="text/css" rel="stylesheet" />
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
        <div id="login">
            <form name="password" action="initialize.php">
                <div id="login_id"><input type="text" name="id" value="Password" id="login_id_input" onclick="clearInput('login_id_input', 'Password')" onblur="checkInput('login_id_input', 'Password')"/></div>
                <button type="submit">Enter</button>

            </form>

        </div>

    </body>

</html>