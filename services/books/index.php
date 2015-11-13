<?php
require '../mysql.php';
require '../general_functions.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	

}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	$_POST = escape($con, $_POST);
	var_dump($_POST);
}
?>