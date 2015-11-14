<?php 
session_start();
if(!isset($_SESSION['auth'])){
	header('Location: index.php');
}
require 'services/mysql.php';
?>
<!Doctype html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
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

	function deleteBook(bookId){
		$.ajax({
		    url: 'services/books/?book=' + bookId,
		    type: 'DELETE',
		    success: function(data) {
		    	console.log(data);
		        data = jQuery.parseJSON(data);
		        if(data.status == 200){
		        	location.reload();
		        }else{
		        	alert(data.response);
		        }
		    }
		});
	}
	</script>
</head>
<body>
	<aside>
		<img src="<?php echo $_SESSION['auth']['profile_pic']; ?>" id="profilePic" />
		<h3><?php echo $_SESSION['auth']['firstName'] . ' ' . $_SESSION['auth']['lastName']; ?></h3>
		<a data-toggle='modal' data-target='#uploadImage'> Change Profile Picture</a>
	</aside>

	<main>
		<header>
		<a href="logout.php"> Log out</a>
		</header>
		<h1>Recipe Books:</h1>

		<div id="books">
			<?php
			$user_id = (int)$_SESSION['auth']['id'];
			$query = mysqli_query($con, "SELECT id, name,description, image FROM books WHERE owner_id = {$user_id}") or die(mysqli_error($con));
			while($row = mysqli_fetch_assoc($query)){
				echo <<<EOS
				<div class='book'>
					<h3 onclick='location.href = "book.php?book=$row[id]";'>$row[name]</h3>
					<p>$row[description]</p>
					<button class='btn btn-danger' type='button' onclick='deleteBook($row[id])'>Delete</button>
					<button class='btn btn-primary' type='button' data-toggle='modal' data-target='#shareBook' onclick='$("#bookHidden").val("$row[id]");'>Share</button>
				</div>
EOS;

			}
			?>
			<div class="book" id="lastBook" onclick="$(this).css('background-image', 'none').attr('onclick', null).html('<form id=\'createBookForm\' onsubmit=\'formSubmit()\'><div class=\'form-group\'><label>Name</label><input type=\'text\' class=\'form-control\' name=\'name\'></div><div class=\'form-group\'><label>Description</label><textarea rows=\'4\' class=\'form-control\' name=\'description\'></textarea><button type=\'button\' id=\'createBookButton\' onclick=\'button();\' class=\'btn btn-primary\' style=\'float:right;margin-top:15px;margin-right:5px\'>Create</button></form>');">
				<span id="plus">+</span>
			</div>
		</div>
	</main>
<div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
      </div>
      <div class="modal-body">
        <form id="uploadImageForm" enctype="multipart/form-data" method="post" action="after.php">
        	
        	<div class="form-group">
        		<label>Recipe Image</label>
        		<input type="file" name="uploadFile">
        	</div>
        	<input type="hidden" name="recipe" id="recipeHidden" value="null" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" form="uploadImageForm">Upload</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="shareBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Share Recipe Book</h4>
      </div>
      <div class="modal-body">
        <form id="shareForm" method="post" action="shareBook.php">
        	
        	<div class="form-group">
        		<label>Comma Seperated Email Addresses</label>
        		<input type="text" class="form-control" name="shareWithEmails">
        	</div>
        	<div class="form-group">
        		<label>Additional Message</label>
        		<textarea rows="7" name="message" class="form-control"></textarea>
        	</div>
        	<input type="hidden" name="book" id="bookHidden" value="null" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="shareForm">Share</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
