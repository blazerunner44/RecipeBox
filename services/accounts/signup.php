<?php
require('../mysql.php');
require('../general_functions.php');

$_POST = escape($con, $_POST);

$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

if(account_exists($con, $_POST['email'])){
	echo createJSON(409, "User already exists");
	exit;
}

if(mysqli_query($con, "INSERT INTO users (username, password, books, firstName, lastName, email) VALUES ('$_POST[username]', '$_POST[password]', '', '$_POST[firstName]', '$_POST[lastName]', '$_POST[email]')")){
	echo createJSON(200);
}else{
	echo createJSON(500, mysqli_error($con));
}
?>