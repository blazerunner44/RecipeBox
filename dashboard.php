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
		$id = $_SESSION['auth']['id']
		$query = mysqli_query($con, "SELECT name, image FROM books WHERE owner_id = $")
	</main>

</body>
</html>