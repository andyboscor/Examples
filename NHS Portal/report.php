<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    {  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    }
    if(empty($_SESSION['pid'])){
        header("Location: search.php"); 
        die("Redirecting to search.php");
    } else {
    	$pid = $_SESSION['pid'];
    }

    require("src/php_libs/return_demographic.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>portal - <?php print return_demographic($pid, 0); ?> - Dashboard</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="src/favicon.png" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/report.css" type="text/css" rel="stylesheet" />
        <script src="src/script/letter.js" type="text/javascript"></script>
    </head>
    <body onload="addLine()">
    	<div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
        <div id="report_container">
	        <p id="report_title">Create letter</p>
	        <div id="patient_demographics">
                Name: <span class="patient_info"><?php print return_demographic($pid, 0); ?></span><br />
                Patient ID: <span class="patient_info"><?php print return_demographic($pid, 1); ?></span><br />
                GP address: <span class="patient_info"><?php print return_demographic($pid, 3); ?></span><br />
                Date of birth: <span class="patient_info"><?php print return_demographic($pid, 2); ?></span>
            </div>
            <div id="input_fields">
            	<form method="POST" action="download_letter.php">
	            	<p class="report_field_title">Values to add:</p>
	            	<div id="report_selector">
		            	<table>
		            		<tr>
		            			<td id="report_dropdowns">
		            			</td>
		            			<td style="vertical-align: bottom;">
		            				<button onclick="addLine()" type="button">Add line</button>
		            				<input type="hidden" id="counter" value="0" />
		            			</td>
		            		</tr>
		            	</table>
	            	</div>
	            	<p class="report_field_title">Free text field:</p>
            		<textarea name="free_text" id="input_free_text"></textarea>
            		<button id="submit_button" type="submit">Download letter</button>
            		<button id="discard_button" type="button" onclick="window.location.replace('dashboard.php')">Discard</button>
            	</form>
            </div>
        </div>
    </body>
</html>