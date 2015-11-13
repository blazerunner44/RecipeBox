<?php
require('../mysql.php');
require('../general_functions.php');
session_start();

$_POST = escape($_POST);


if($query = mysqli_query($con, "SELECT username FROM users WHERE username = '$_POST[username]'")){
	$row = mysqli_fetch_array($query);
	if(password_verify($_POST['password'], $row['password'])){
		echo createJSON(200, "Login Success!");
		$_SESSION['auth'] = true;
		exit;
	}else{
		echo createJSON(401, "Bad pass");
		exit;
	}
}else{
	echo createJSON(404, "User not found!");
	exit;
}
?>