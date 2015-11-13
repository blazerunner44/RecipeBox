<?php 
if($_GET['book'] == ''){
	header('Location: dashboard.php');
}
session_start();
require 'services/mysql.php';
?>
<!Doctype html>
<html>
<head>
	<title>Time To eat</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/book.css">
</head>
<body>
	<aside>
		<ul>
			<?php
			$book_id = (int)$_GET['book'];
			$query = mysqli_query($con, "SELECT name FROM recipies WHERE book = $book_id");
			while($row = mysqli_fetch_array($query)){
				echo "<li>{$row[name]}</li>";
			}
			?>
		</ul>
	</aside>

	<main>
		<h1>Select a Recipe</h1>

		
	</main>

</body>
</html>