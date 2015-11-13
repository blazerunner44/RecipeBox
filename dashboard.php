<?php 
session_start(); 
require 'services/mysql.php';
?>
<!Doctype html>
<html>
<head>
	<title>Time To eat</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
	<aside>
		<img src="images/default_profile.jpg" id="profilePic" />
		<h3><?php echo $_SESSION['auth']['firstName'] . ' ' . $_SESSION['auth']['lastName']; ?></h3>
	</aside>

	<main>
		<h1>Recipe Books</h1>

		<div id="books">
			<?php
			$user_id = (int)$_SESSION['auth']['id'];
			$query = mysqli_query($con, "SELECT id, name, image FROM books WHERE owner_id = {$user_id}") or die(mysqli_error($con));
			while($row = mysqli_fetch_assoc($query)){
				echo <<<EOS
				<div class='book' onclick='location.href = "book.php?book=$row[id]";'>
					<h3>$row[name]</h3>
				</div>
EOS;

			}
			?>
			<div class="book" id="lastBook" onclick="$(this).css('background-image', 'none').html('<form><div class=\'form-group\'><label>Name</label><input type=\'text\' class=\'form-control\'></div></form>');">
				Add Book
			</div>
		</div>
	</main>

</body>
</html>