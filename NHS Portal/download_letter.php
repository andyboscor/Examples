<?php
session_start();
require_once 'phpword/src/PhpWord/Autoloader.php';
require_once 'src/php_libs/return_demographic.php';
\PhpOffice\PhpWord\Autoloader::register();

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

// New Word Document
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->addFontStyle('rStyle', array('bold' => true, 'italic' => true, 'size' => 16, 'allCaps' => true, 'doubleStrikethrough' => true));
$phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 100));
$phpWord->addTitleStyle(1, array('bold' => true), array('align' => 'center'));

// New portrait section
$section = $phpWord->addSection();

// Simple text
$section->addTitle(htmlspecialchars(date('d F Y H:i:s')), 1);
$section->addTitle(htmlspecialchars(return_demographic($_SESSION['pid'], 0)), 1);
$section->addTitle(htmlspecialchars(return_demographic($_SESSION['pid'], 1)), 1);
$section->addTitle(htmlspecialchars(return_demographic($_SESSION['pid'], 3)), 1);
$section->addTitle(htmlspecialchars(return_demographic($_SESSION['pid'], 2)), 1);

// Two text break
$section->addTextBreak(2);

$data = array();

for($i = 1; isset($_POST['select'. $i]); $i++){
	if(!isset($data[$_POST['box' . $i]])){
		$data[$_POST['box' . $i]] = array();
	}
	array_push($data[$_POST['box' . $i]], $_POST['select' . $i]);	
}

foreach($data as $box => $array){
	$section->addTextBreak();
	$section->addText(htmlspecialchars(return_box_name($box)), array("bold" => true, "size" => 14));
	foreach($array as $line){
		return_content($line, $section);
	}
}

$section->addTextBreak(2);

function return_box_name($id){
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes` WHERE id=$id");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	return $mysql_array[0]['name'];
}

function return_content($id, &$section){
	$pid = $_SESSION['pid'];
	$db = establish_mysql_connection();
	$mysql_query = $db->prepare("SELECT * FROM `boxes_selectable_content` WHERE selectable_id=$id");
	$mysql_query->execute();
	$mysql_array = $mysql_query->fetchAll();
	foreach($mysql_array as $array){
		$section->addTextBreak();
		$table_link = $array['table_link'];
		$section->addText(htmlspecialchars($array['name']), array("bold" => true));
		$mysql_queryc = $db->prepare("SELECT * FROM $table_link WHERE MRN=$pid ORDER BY 3 DESC");
		$mysql_queryc->execute();
		$mysql_arrayc = $mysql_queryc->fetchAll();
		$section->addText(htmlspecialchars($mysql_arrayc[0][2]), array("italic" => true));
		$section->addText(htmlspecialchars($mysql_arrayc[0][3]), array("spaceBefore" => 5));
	}

}
$section->addText(htmlspecialchars($_POST['free_text']), array("size" => 12));

echo write($phpWord, basename(__FILE__, '.php'), array('Word2007' => 'docx'));

function write($phpWord, $filename, $writers)
{
    $name = date('zYHis') . $_SESSION['pid'];
    $targetFile = __DIR__ . "/letters/" . $name . ".docx";
    $phpWord->save($targetFile, "Word2007");
    header("Location: letters/" . $name . ".docx");
	die();
}