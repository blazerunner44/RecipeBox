<?php
require '../mysql.php';
require '../general_functions.php';
session_start();

$owner_id = (int)$_SESSION['auth']['id'];

$_DELETE = array ();
$_PUT = array ();
//$_SERVER['REQUEST_METHOD'] = "PUT";
switch ( $_SERVER['REQUEST_METHOD'] ) {
    case !strcasecmp($_SERVER['REQUEST_METHOD'],'DELETE'):
        parse_str( file_get_contents( 'php://input' ), $_DELETE );
        break;
    case !strcasecmp($_SERVER['REQUEST_METHOD'],'PUT'):
        parse_str( file_get_contents( 'php://input' ), $_PUT );
        break;
}

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
	
	if($_POST['recipe'] != 'null'){
		// $query = mysqli_query($con, "SELECT COUNT() as count FROM recipies WHERE id='$_POST[recipe]'");
		// $row = mysqli_fetch_array($query);
		// //smail('blazerunner44@gmail.com', 'de', $row['count']);
		// if($row['count'] == 0){
		if(mysqli_query($con, "UPDATE recipies SET name='$_POST[name]', description='$_POST[description]', ingredients='$neededStuff', steps='$steps' WHERE id='$_POST[recipe]'")){
			echo createJSON(200, "Recipe Updated successfully!");
		}else{
			echo createJSON(500, mysqli_error($con));
		}
	}else{
		if(mysqli_query($con, "INSERT INTO recipies (name, description, book, ingredients, steps) VALUES ('$_POST[name]', '$_POST[description]', $_POST[book], '$neededStuff', '$steps')")){
			echo createJSON(200, "Recipe created successfully!");
		}else{
			echo createJSON(500, mysqli_error($con));
		}
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'DELETE'){
	$recipe_id = (int)$_GET['recipe'];
	if(mysqli_query($con, "DELETE FROM recipies WHERE id=$recipe_id")){
		echo createJSON(200, "Delete Successful!");
	}else{
		echo createJSON(500, mysqli_error($con));
	}
}
?>