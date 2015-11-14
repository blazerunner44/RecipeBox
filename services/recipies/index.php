<?php
require '../mysql.php';
require '../general_functions.php';
session_start();

$owner_id = (int)$_SESSION['auth']['id'];

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	echo 'hi';

}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	//$_POST = escape($con, $_POST);
	$neededStuff = array();
	foreach ($_POST['ingredient'] as $key => $ingredient) {
		$neededStuff[$ingredient] = $_POST['measurement'][$key];
	}
	$neededStuff = json_encode($neededStuff);
	$steps = json_encode($_POST['steps']);
	//var_dump($neededStuff);
	//var_dump($_POST);
	$_POST['book'] = (int)$_POST['book'];
	
	if(mysqli_query($con, "INSERT INTO recipies (name, description, book, ingredients, steps) VALUES ('$_POST[name]', '$_POST[description]', $_POST[book], '$neededStuff', '$steps')")){
		echo createJSON(200, "Recipe created successfully!");
	}else{
		echo createJSON(500, mysqli_error($con));
	}
}
?>