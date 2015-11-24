<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    {  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    }
    if(isset($_GET['pid']) and $_GET['pid'] != ''){
        $_SESSION['pid'] = $_GET['pid'];
    }

    if(empty($_SESSION['pid'])){
        header("Location: search.php"); 
        die("Redirecting to search.php");
    } else {
    	$pid = $_SESSION['pid'];
    }
    $_SESSION['boxes'] = [1, 2, 3, 4];

    require("src/php_libs/saved_dashboard_builder.php");
    require("src/php_libs/patient_dashboard_builder.php");
    require("src/php_libs/return_demographic.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <title>portal - <?php print return_demographic($pid, 0); ?> - Initialize</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="src/favicon.png" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/initialize.css" type="text/css" rel="stylesheet" />
        <script src="src/script/initialize.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
        <div id="initialize_patient">
        	<div id="selected_patient_demographics">
                Name: <span class="selected_patient_info"><?php print return_demographic($pid, 0); ?></span><br />
                Patient ID: <span class="selected_patient_info"><?php print return_demographic($pid, 1); ?></span><br />
                GP address: <span class="selected_patient_info"><?php print return_demographic($pid, 3); ?></span><br />
                Date of birth: <span class="selected_patient_info"><?php print return_demographic($pid, 2); ?></span>
            </div>
            <form name="initialize">
                <button type="button" onclick="window.location.replace('search.php')">Change patient</button>
            </form>
        </div>
        <div id="initialize_dashboards">
            <table >
                <tr id="initialize_dashboards_first_line">
                    <th>Default dashboards</th>
                    <th>Saved dashboards</th>
                    <th>Patient associated dashboards</th>
                </tr>
                <tr>
                    <td>
                    <form method="link">
                        <button type="button" onclick="window.location.replace('update_session.php?boxes=1_2_3_4_')">Display all</button><br /> </form>
                        <button type="button" onclick="window.location.replace('update_session.php?boxes=1_')">Only Imaging</button><br />
                        <button type="button" onclick="window.location.replace('update_session.php?boxes=2_')">Only Viral Seology</button><br />
                        <button type="button" onclick="window.location.replace('update_session.php?boxes=3_')">Only Blood Results</button><br />
                        <button type="button" onclick="window.location.replace('update_session.php?boxes=4_')">Only Non Invasive Staging</button><br />
                    </td>
                    <td>
                        <?php saved_dashboard_builder(); ?> <br />
                        <!-- <button type="button" onclick="window.location.replace('dashboard.php')">Stuff</button><br />
                        <button type="button" onclick="window.location.replace('dashboard.php')">Stuff 2</button><br /> -->
                    </td>
                    <td>
                        <?php patient_dashboard_builder(); ?> <br />
                        <!-- <button type="button" onclick="window.location.replace('dashboard.php')">Stuff</button><br />
                        <button type="button" onclick="window.location.replace('dashboard.php')">Stuff 2</button><br /> -->
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>