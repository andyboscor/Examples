<?php
try 
{ 
    $db = new PDO("mysql:host=localhost;dbname=NHS;charset=utf8", "portal_user", ""); 
} 
catch(PDOException $ex) 
{ 
    die("Failed to connect to the database: " . $ex->getMessage()); 
}

$mysql_query = $db->prepare("SELECT * FROM `Patients`");
$mysql_query->execute();
$mysql_array = $mysql_query->fetchAll();

$input = $_GET['keywords'];
$input_array = explode(" ", $input);
$result_array = [];

$size = sizeof($mysql_array);
$size_keys = sizeof($input_array);
   
echo "<tr>";
echo "<td class=\"search_result_table_col1\" style=\"border-bottom: 2px solid white; padding-top: 15px;\">Name</td>";
echo "<td class=\"search_result_table_col2\" style=\"border-bottom: 2px solid white; padding-top: 15px;\">NHS ID</td>";
echo "<td class=\"search_result_table_col3\" style=\"border-bottom: 2px solid white; padding-top: 15px;\">Sex</td>";
echo "</tr>";

if($input != ''){
    for($i = 0; $i < $size; $i++){
        $contains = false;
        
        for($k = 0; $k < $size_keys; $k++){
            for($j = 0; $j < 2; $j++){
                if(strrpos(strtolower($mysql_array[$i][$j]), strtolower($input_array[$k])) === false){
                    $contains = false;
                } else {
                    $contains = true;
                    break;
                }
            }
            
            if($contains == false){
                break;
            }
        }
        
        if($contains == false){
            continue;
        } else {
            array_push($result_array, $mysql_array[$i]);
        }
    }
    
    $result_size = sizeof($result_array);
    if($result_size != 0){
        for($i = 0; $i < sizeof($result_array); $i++){
            echo "<tr style=\"cursor: pointer\" onclick=\"window.location.replace('initialize.php?pid=" . $result_array[$i][1] . "')\" onmouseover=\"glowTable(this)\" onmouseout=\"clearTable(this)\" id=\"search_result_table_" . $i . "\">";
            echo "<td class=\"search_result_table_col1\">" . $result_array[$i][0] . "</td>";
            echo "<td class=\"search_result_table_col2\">" . $result_array[$i][1] . "</td>";
            echo "<td class=\"search_result_table_col3\">" . $result_array[$i][4] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan=\"3\" style=\"text-align:center\">0 results found</td>";
        echo "</tr>";
    }
} else {
    echo "<tr>";
        echo "<td colspan=\"3\" style=\"text-align:center\">Start typing...</td>";
        echo "</tr>";
}