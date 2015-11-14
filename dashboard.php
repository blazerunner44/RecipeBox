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

	<script type="text/javascript">
	function button(){
		$.post('services/books/', $("#createBookForm").serialize(), function(data){
			data = jQuery.parseJSON(data);
			console.log(data.status);
			if(data.status == 200){
				location.reload();
			}else{
				alert(data.response);
			}
		});
	}
	</script>
</head>
<body>
	<aside>
		<img src="<?php echo $_SESSION['auth']['profile_pic']; ?>" id="profilePic" />
		<h3><?php echo $_SESSION['auth']['firstName'] . ' ' . $_SESSION['auth']['lastName']; ?></h3>
		<a href="settings.php"> Change Profile Picture</a>
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
			<div class="book" id="lastBook" onclick="$(this).css('background-image', 'none').attr('onclick', null).html('<form id=\'createBookForm\' onsubmit=\'formSubmit()\'><div class=\'form-group\'><label>Name</label><input type=\'text\' class=\'form-control\' name=\'name\'></div><div class=\'form-group\'><label>Description</label><textarea rows=\'4\' class=\'form-control\' name=\'description\'></textarea><button type=\'button\' id=\'createBookButton\' onclick=\'button();\' class=\'btn btn-primary\' style=\'float:right;margin-top:15px;margin-right:5px\'>Create</button></form>');">
				Add Book
			</div>
		</div>
	</main>

</body>
</html>
