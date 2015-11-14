<?php
require '../mysql.php';
require '../general_functions.php';
session_start();

$owner_id = (int)$_SESSION['auth']['id'];

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if($_GET['book'] != ''){
		$result = array();
		$book_id = (int)$_GET['book'];
		$query = mysqli_query($con, "SELECT id, name, description, image, book, ingredients, steps FROM recipies WHERE book = $book_id");
		while($row = mysqli_fetch_array($query)){
			$result[$row['id']] = array('id' => $row['id'], 'name' => $row['name'], 'description' => $row['description'], 'image' => $row['image'], 'book' => $row['book'], 'ingredients' => $row['ingredients'], 'steps' => $row['steps']);
		}
		echo createJSON(200, $result);
	}
	if($_GET['recipe'] != ''){
		$recipe_id = (int)$_GET['recipe'];
		$query = mysqli_query($con, "SELECT id, name, description, image, book, ingredients, steps FROM recipies WHERE id = $recipe_id");
		while($row = mysqli_fetch_array($query)){
			$result = array('id' => $row['id'], 'name' => $row['name'], 'description' => $row['description'], 'image' => $row['image'], 'book' => $row['book'], 'ingredients' => $row['ingredients'], 'steps' => $row['steps']);
		}
		echo createJSON(200, $result);
	}

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