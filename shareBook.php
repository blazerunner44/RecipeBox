<?php
require('services/mysql.php');
$query = mysqli_query($con, "SELECT share_key FROM books WHERE id=$_POST[book]");
$row = mysqli_fetch_array($query);
$emails = explode(',', $_POST['shareWithEmails']);

$message = <<<EOS
$_POST[message]
A family member shared a recipe book with you. You can view the book at http://recipe.blazerunner44.me/share.php?book=$row[share_key]
EOS;
//var_dump($emails);
foreach ($emails as $key => $email) {
	mail(trim($email), 'Shared Recipe Book', $message);
}

header('Location: dashboard.php');
?>