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
        <title>portal - Search</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="src/favicon.png" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/search.css" type="text/css" rel="stylesheet" />
        <script src="src/script/search.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
        <div id="initialize">
            <form name="initialize" action="initialize.php">
                <div id="initialize_keyword"><input type="text" name="id" value="Search name, NHS ID" autocomplete="off" id="initialize_keyword_input" onclick="clearInput(this, 'Search name, NHS ID')" onblur="checkInput(this, 'Search name, NHS ID')" onkeyup="updateTable(this)"/></div>
            </form>
        </div>
        <div id="search_result">
            <table id="search_result_table">
                <tr>
                    <td class="search_result_table_col1" style="border-bottom: 2px solid white; padding-top: 15px;">Name</td>
                    <td class="search_result_table_col2" style="border-bottom: 2px solid white; padding-top: 15px;">NHS ID</td>
                    <td class="search_result_table_col3" style="border-bottom: 2px solid white; padding-top: 15px;">Sex</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center">Start typing...</td>
                </tr>
            </table>
        </div>
    </body>
</html>