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
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$("#addRecipe").click(function(){
			//$("#addRecipeModal").modal();
		});
	});
	</script>
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
			<li id="addRecipe" data-toggle="modal" data-target="#addRecipeModal">+ Add Recipe</li>
		</ul>
	</aside>

	<main>
		<h1>Select a Recipe</h1>

		
	</main>
<!-- Modal -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Recipe</h4>
      </div>
      <div class="modal-body">
        <form id="createRecipeForm">
        	<div class="form-group">
        		<label>Name</label>
        		<input type="text" class="form-control" name="name">
        	</div>
        	<div class="form-group">
        		<label>Description</label>
        		<textarea class="form-control" name="description" rows="4"></textarea>
        	</div>
        	<div class="form-group">
        		<label>Image</label>
        		<input type="file" name="pic">
        	</div>
        	<div class="form-group">
        		<label>Ingredients</label><br>
        		<input class="form-control ingredient" name="ingredient[]" placeholder="Ingredient">
        		<input class="form-control measurement" name="measurement[]" placeholder="Measurement">
        	</div>
        	<a onclick="" href="#">Add Ingredient</a>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>