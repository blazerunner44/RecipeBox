<?php
session_start();
require('services/mysql.php');
$id = $_SESSION["auth"]["id"];
$recipe_id = (int)$_POST['recipe'];
//var_dump($recipe_id);
//var_dump($_FILES);
$recipe_img = 'profile/' . $_FILES["image"] ["name"];
move_uploaded_file ($_FILES['image'] ['tmp_name'], 
       "{$recipe_img}");
mysqli_query($con, "UPDATE recipies SET image = '$recipe_img' WHERE id = $recipe_id") or die(mysqli_error($con));

header("Location: book.php?book={$_GET[book]}");
?>