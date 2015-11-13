<?php
require '../mysql.php';
require '../general_functions.php';
session_start();

$owner_id = (int)$_SESSION['auth']['id'];

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	echo 'hi';

}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	$_POST = escape($con, $_POST);
	//var_dump($_POST);
	if(mysqli_query($con, "INSERT INTO books (name, description, owner_id) VALUES ('$_POST[name]', '$_POST[description]', $owner_id)")){
		echo createJSON(200, "Book created successfully!");
	}else{
		echo createJSON(500, mysqli_error($con));
	}
}
?>