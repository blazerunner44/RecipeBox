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
	function createRecipe(){
		$.post('services/recipies/', $("#createRecipeForm").serialize(), function(data){
			console.log(data);
			data = jQuery.parseJSON(data);
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
		<?php
		$book_id = (int)$_GET['book'];
		$query = mysqli_query($con, "SELECT name FROM books WHERE id=$book_id");
		$row = mysqli_fetch_array($query);
		echo "<h2>{$row[name]}</h2>";
		?>
		<ul>
			<?php
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
        	<div class="form-group" id="ingredientCont">
        		<label>Ingredients</label><br>
        		<div id="ingredientTemplate">
        			<input class="form-control ingredient" name="ingredient[]" placeholder="Ingredient">
        			<input class="form-control measurement" name="measurement[]" placeholder="Measurement">
        		</div>
        	</div>
        	<a onclick="$('#ingredientTemplate').clone().appendTo('#ingredientCont').find('input').val('');" href="#">Add Ingredient</a>
        	<div class="form-group" id="stepCont">
        		<label>Steps</label><br>
        		<input class="form-control step" id="stepTemplate" name="steps[]" placeholder="Recipe Step">
        	</div>
        	<a onclick="$('#stepTemplate').clone().appendTo('#stepCont').val('');" href="#">Add Step</a>
        	<input type="hidden" name="book" value="<?php echo $book_id; ?>" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="createRecipe();">Add Recipe</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>