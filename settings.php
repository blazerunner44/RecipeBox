<?php 
session_start(); 
require 'services/mysql.php';
?>
<!Doctype html>
<html>
<head>
<title>File Upload Form</title>
</head>
<body>
This form allows you to upload a file to the server.<br>
<form action="getfile.php" method="post"><br>
Type (or select) Filename: <input type="file" name="uploadFile">
<input type="submit" value="Upload File">
</form>
</body>
</html>