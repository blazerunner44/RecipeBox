<?php session_start(); ?>
<!Doctype html>
<html>
<head>
	<title>Time To eat</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>
	<aside>
		<img src="images/default_profile.jpg" id="profilePic" />
		<h3><?php echo $_SESSION['auth']['firstName'] . ' ' . $_SESSION['auth']['lastName']; ?></h3>
	</aside>

	<main>
		<h1>Recipe Books</h1>
		<?php
		$user_id = (int)$_SESSION['auth']['id'];
		var_dump($user_id);
		$query = mysqli_query($con, "SELECT name, image FROM books WHERE owner_id = $user_id");
		while($row = mysqli_fetch_array($query)){
			echo "bralehey";
		}
		?>
	</main>

</body>
</html>