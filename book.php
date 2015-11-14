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

	function loadRecipe(id){
		$.getJSON('services/recipies/', {recipe: id}, function(data){
			var recipe = data.response;
			var appendMe = "<div class='row'><div id='title'><h1>" + recipe.name + "</h1>" +
				"<p>" + recipe.description + "</p></div>" +
				"<div id='image'><img src='" + recipe.image + "'><span class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='#uploadImage' onclick='$(&quot;#recipeHidden&quot;).attr(&quot;value&quot;, &quot;" + recipe.id + "&quot;);'></span></div></div>" +
				"<div id='ingredients' class='row'>" + 
				"<h3>Ingredients</h3>";
			$.each(jQuery.parseJSON(recipe.ingredients), function(ingredient, measurement){
				appendMe += "<div class='ingredient2'><h4>" + ingredient + "</h4>";
				appendMe += "<h4 class='measurement'>" + measurement + "</h4></div>";
			});
			appendMe += "</div>";

			appendMe += "<div id='steps' class='row'><h3>Steps</h3>";
			$.each(jQuery.parseJSON(recipe.steps), function(index, step){
				appendMe += "<div class='step'>" + parseInt(index + 1) + ". " + step + "</div>";
			});
			appendMe += "</div>";

			$("main").html(appendMe);
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
			$query = mysqli_query($con, "SELECT id, name FROM recipies WHERE book = $book_id");
			while($row = mysqli_fetch_array($query)){
				echo "<li data-id='{$row[id]}' onclick='loadRecipe({$row[id]});'>{$row[name]}</li>";
			}
			?>
			<li id="addRecipe" data-toggle="modal" data-target="#addRecipeModal">+ Add Recipe</li>
		</ul>
		<a href="dashboard.php">Back</a>
	</aside>

	<main>
		<h1>Select a Recipe</h1>

		
	</main>
<!-- Add Recipe Modal -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Recipe</h4>
      </div>
      <div class="modal-body">
        <form id="createRecipeForm" enctype="multipart/form-data">
        	<div class="form-group">
        		<label>Name</label>
        		<input type="text" class="form-control" name="name">
        	</div>
        	<div class="form-group">
        		<label>Description</label>
        		<textarea class="form-control" name="description" rows="4"></textarea>
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

<div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
      </div>
      <div class="modal-body">
        <form id="uploadImageForm" enctype="multipart/form-data" method="post" action="recipeImage.php?book=<?php echo $book_id; ?>">
        	
        	<div class="form-group">
        		<label>Recipe Image</label>
        		<input type="file" name="image">
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
</body>
</html>