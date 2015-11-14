<?php 
if($_GET['book'] == ''){
	exit;
}
session_start();
require 'services/mysql.php';
$query = mysqli_query($con, "SELECT id FROM books WHERE share_key = $_GET[book]");
$row = mysqli_fetch_array($query);
$_GET['book'] = $row['id'];
?>
<!Doctype html>
<html>
<head>
	<title>Recipes</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/book.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$('aside ul li').first().trigger('click');
	});
		function loadRecipe(id){
		$.getJSON('services/recipies/', {recipe: id}, function(data){
			var recipe = data.response;
			var appendMe = "<div class='row'><div id='title'><h1>" + recipe.name + "</h1>" +
				"<p>" + recipe.description + "</p></div>" +
				"<div id='image'><img src='" + recipe.image + "'><span class= data-toggle='modal' data-target='#uploadImage' onclick='$(&quot;#recipeHidden&quot;).attr(&quot;value&quot;, &quot;" + recipe.id + "&quot;);'></span></div></div>" +
				"<div id='ingredients' class='row'>" + 
				"<h3>Ingredients</h3>";
			$.each(jQuery.parseJSON(recipe.ingredients), function(ingredient, measurement){
				appendMe += "<div class='ingredient2'><h4>" + ingredient + "</h4>";
				appendMe += "<h4 class='measurement2'>" + measurement + "</h4></div>";
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
		</ul>
	</aside>

	<main>
		<h1>Select a Recipe</h1>

		
	</main>
</body>
</html>