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

function return_field_name($name){
	$array = explode("_", $name);
	return array_pop($array);
}

function return_structure_longtext($name, $table){
		print '<div class="dashboard_box_entry_title" class="dashboard_box_entry_long_text_title">';
		print $name . ' - ' . $table[0][2]; 
		print '</div>';
		print '<div class="dashboard_box_structure_long_text" onmouseover="expandTextBox(this)" onmouseout="collapseTextBox(this)">';
		print $table[0][3];
		print '</div>';
}

function return_structure_shorttext($name, $table){
		print '<p><span class="dashboard_box_entry_small_title">';
		print $table[0][2] . ':';
		print '</span>';
		print '<span class="dashboard_box_entry_small_data">';
		print $table[0][3];
		print '</span></p>';
}

function return_structure_table($box_id){
	$tables = table_structure_table_collector($box_id);
	$dates = table_structure_date_collector($tables);
	$pid = $_SESSION['pid'];
	$values = array();

	table_structure_prepare_array($values, $tables);

	print '<div class="dashboard_box_content">';
	print '<table class="structure_table">';

	$tcol = 1;

	print '<tr>';
	print '<td id="dashboard_box' . $box_id . '_table_11" class="dashboard_entry_table_empty" style="">&nbsp;</td>';

	for($i = 0; $i < 3 && isset($dates[$i]); $i++){
		print '<td id="dashboard_box' . $box_id . '_table_1' . ++$tcol . '" class="dashboard_entry_table_row1">' . str_replace('-', '.', $dates[$i]) . '</td>';
	}
	print '</tr>';
	table_structure_print_table($values, $dates, $box_id);
	print '</table>';
	print '</div>';
}

function table_structure_print_table(&$values, $dates, $box_id){
	$trow = 2;
	$tcol = 1;
	foreach($values as $row){
		foreach($row as $key=>$data){
			$tcol = 1;
			print '<tr>';
			print '<td id="dashboard_box' . $box_id . '_table_' . $trow . $tcol . '" class="dashboard_entry_table_col1">' . $key . '</td>';
			foreach($dates as $itdates){
				$tcol++;
				print '<td id="dashboard_box' . $box_id . '_table_' . $trow . $tcol . '" onmouseover="glowTable(this)" onmouseout="clearTable(this)">';
				if(isset($data[$itdates])){
					print $data[$itdates];
				} else {
					print '-';
				}
				print '</td>';
			}
			print '</tr>';
			$trow++;
		}
	}
}

function table_structure_prepare_array(&$values, &$tables){
	$pid = $_SESSION['pid'];
	foreach($tables as $row){
		array_push($values, table_structure_return_lines($row));
	}
		
	for($k = 0; $k < sizeof($values); $k++){
		$values[$k] = array_flip($values[$k]);
		foreach($values[$k] as &$line){
			$line = array();
		}
	}

	$i = 0;
	foreach($tables as $row){
		$db = establish_mysql_connection();
		$mysql_query = $db->prepare("SELECT * FROM `$row` WHERE MRN='$pid'");
		$mysql_query->execute();
		$mysql_array = $mysql_query->fetchAll();
		$j = 0;
		foreach($mysql_array as $key=>$row_sel){
			foreach($values[$i] as $vkey=>&$vrow){
				$vrow[$row_sel[2]] = $row_sel[$vkey];
			}
			$j++;
		}
		$i++;
	}
}

function table_structure_return_lines($table){
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes_selectable_content` WHERE table_link='$table'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();

	$array = explode(',', $mysql_array[0]['table_lines']);
	return $array;
}

function table_structure_date_collector($tables){
	$pid = $_SESSION['pid'];
	$db = establish_mysql_connection();
	$dates = array();

	foreach($tables as $row){
		$mysql_query = $db->prepare("SELECT * FROM `$row` WHERE MRN='$pid'");
		$mysql_query->execute();
		$mysql_array = $mysql_query->fetchAll();
		foreach($mysql_array as $row_date){
			array_push($dates, $row_date[2]);
		}
	}
	rsort($dates);
	return $dates;
}

function table_structure_table_collector($box_id){
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT `ID` FROM `boxes_selectable` WHERE box_id='$box_id'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	$selectables_cont = array();
	
	foreach($mysql_array as $row){
		$id = $row['ID'];
		$mysql_query_sel = $db->prepare("SELECT `table_link` FROM `boxes_selectable_content` WHERE selectable_id='$id'");
		$mysql_query_sel->execute();
		$mysql_array_sel = $mysql_query_sel->fetchAll();
		foreach($mysql_array_sel as $row_sel){
			array_push($selectables_cont, $row_sel[0]);
		}
	}
	return $selectables_cont;
}

function return_box_id($name){
	//Returns the ID of an entry in 'boxes' table with the name $name
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes` WHERE name='$name'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	return $mysql_array[0]['id'];
}

function return_selectable_box($id){
	//Returns an array with the the entries from 'boxes_selectable' table that corresponds to the same box with the ID $id
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes_selectable` WHERE box_id='$id'");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	return $mysql_array;
}

function return_structure_imaging(){
	print '<table id="dashboard_structure_imaging_table">';
	print '<tr>';
	print '<td>';

	$id = return_box_id("Imaging");
	$mysql_array = return_selectable_box($id);

	for ($i = 0; $i < sizeof($mysql_array); $i++) { 
		print '<button type="button" onclick="updateImagingCategory(' . $mysql_array[$i]['id'] . ')">';
		print $mysql_array[$i]['name'];
		print '</button>';
	}

	//Printing out the rest of the sctructure
	print '</td>';
	print '</tr>';
	print '<tr>';
    print '<td id="dashboard_structure_imaging_categories">';
	print '<span>Select category</span>';
	print '</td>';
	print '</tr>';
	print '<tr>';
	print '<td>';
	print '<button type="button" onclick="updateImagingDate(-1)" id="dashboard_structure_imaging_date_back">Previous</button>';
	print '<span id="dashboard_structure_imaging_date"></span>';
	print '<button type="button" onclick="updateImagingDate(1)" id="dashboard_structure_imaging_date_next">Next</button>';
	print '</td>';
	print '</tr>';
	print '<tr>';
	print '<td>';
	print '<div id="dashboard_structure_imaging_report">';
	print 'Select report...';
	print '</div>';
	print '</td>';
	print '</tr>';
	print '</table>';
}

function return_structure($table, $id, $type, $counter){
	$db = establish_mysql_connection();

	$mysql_query = $db->prepare("SELECT * FROM `$table` WHERE MRN='$id' ORDER BY 3 DESC");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	if($type == "long_text"){
		return_structure_longtext(return_field_name($table), $mysql_array);
	} else if($type == "short_text"){
		return_structure_shorttext(return_field_name($table), $mysql_array);
	} else if($type == "imaging"){
		return_structure_imaging();
	} else if($type == "table"){
		return_structure_table();
	}
}

function table_builder(){
	$db = establish_mysql_connection();
	$pid = $_SESSION['pid'];

    $mysql_query = $db->prepare("SELECT * FROM `boxes`");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();

	$boxes = $_SESSION['boxes'];
	$i = 0;

	print_problem_list();

	for($i = 0; $i < sizeof($boxes); $i++){
		$j = 0;
		for($j = 0; $j < sizeof($mysql_array); $j++){
			if($mysql_array[$j][0] == $boxes[$i]){
				break;
			}
		}
		if($i % 2 == 1){
			print '<td>';
		}

		print '<div class="dashboard_box" id="dashboard_box' . $mysql_array[$j]['id'] . '">';
        print '<div class="dashboard_box_title">' . $mysql_array[$j]['name'] . '</div>';
        print '<div class="dashboard_box_content">';
        $box_id = $mysql_array[$j]['id'];
        if($box_id == return_box_id("Imaging")){
        	return_structure("boxes", $pid, "imaging", 0);
        } else if($box_id == return_box_id("Blood Results")){
        	return_structure_table($box_id);
        } else {
        	$mysql_query_fill = $db->prepare("SELECT * FROM `boxes_selectable` WHERE box_id='$box_id'");
			$mysql_query_fill->execute();
			$mysql_array_fill = $mysql_query_fill->fetchAll();
			for($k = 0; $k < sizeof($mysql_array_fill); $k++){
				$selectable_name = $mysql_array_fill[$k]['name'];
				$selectable_id = $mysql_array_fill[$k]['id'];
				print '<div class="dashboard_box_entry_title">' . $selectable_name . '</div>';

				$mysql_query_fill_selectable = $db->prepare("SELECT * FROM `boxes_selectable_content` WHERE selectable_id='$selectable_id'");
				$mysql_query_fill_selectable->execute();
				$mysql_array_fill_selectable = $mysql_query_fill_selectable->fetchAll();
				for($l = 0; $l < sizeof($mysql_array_fill_selectable); $l++){
					return_structure($mysql_array_fill_selectable[$l]['table_link'], $pid, $mysql_array_fill_selectable[$l]['type'], 67);
				}
			}
			if(sizeof($mysql_array_fill) == 0){
				print '<div class="dashboard_box_entry_title">No data to show...</div>';
			}
        }
        print '</div>';
        print '</div>';

		if($i % 2 == 0){
			print '<td>';
		}
	}
}

function print_problem_list(){
	$pid = $_SESSION['pid'];
	print '<td>';
	print '<div class="dashboard_box" id="dashboard_box0">';
    print '<div class="dashboard_box_title">Problem list</div>';
    print '<div class="dashboard_box_content">';
    print '<textarea id="dashboard_problem_list_textarea">';

	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `problem_list` WHERE patient_id=$pid");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	print (isset($mysql_array[0]['content']))? $mysql_array[0]['content'] : "";

    print '</textarea>';
    print '<input type="button" value="Save" onclick="saveProblemList()" id="dashboard_problem_list_save" />';
    print '<span id="dashboard_problem_list_status"></span>';
    print '</div>';
    print '</div>';
    print '</div>';
}

function return_boxids(){
	print '[0, ';

	$selected_boxes = $_SESSION['boxes'];
	for($i = 0; $i < sizeof($selected_boxes); $i++){
		print($selected_boxes[$i]);
		if(isset($selected_boxes[$i+1])){
			print ',';
		}
	}
	print ']';
}