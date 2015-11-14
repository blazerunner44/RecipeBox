<html>
<head>
<title>Process Uploaded File</title>
</head>
<body>
<?php
require("services/mysql.php");
session_start();
$id = $_SESSION["auth"]["id"];
//var_dump($_FILES);
$profile_pic = 'profile/' . $_FILES["uploadFile"] ["name"];
move_uploaded_file ($_FILES['uploadFile'] ['tmp_name'], 
       "{$profile_pic}");
mysqli_query($con, "UPDATE users SET profile_pic = '$profile_pic' WHERE id = $id");
$_SESSION['auth']['profile_pic'] = $profile_pic;
header('Location: dashboard.php');
?>

</body>
</html>