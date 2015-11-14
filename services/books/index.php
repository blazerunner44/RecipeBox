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
	echo 'hi';

}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	$_POST = escape($con, $_POST);
	//var_dump($_POST);
	if(mysqli_query($con, "INSERT INTO books (name, description, owner_id) VALUES ('$_POST[name]', '$_POST[description]', $owner_id)")){
		echo createJSON(200, "Book created successfully!");
	}else{
		echo createJSON(500, mysqli_error($con));
	}
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){
	$book_id = (int)$_GET['book'];
	if(mysqli_query($con, "DELETE FROM books WHERE id=$book_id")){
		mysqli_query($con, "DELETE FROM recipies WHERE book = $book_id");
		echo createJSON(200, "Delete successfull");
	}else{
		echo createJSON(500, mysqli_error($con));
	}
}
?>