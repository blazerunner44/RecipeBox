<!Doctype html>
<html>
<head>
	<title>Log In</title>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">

	<script type="text/javascript">
	$(document).ready(function(){
		$('#loginForm').submit(function(submit){
			submit.preventDefault();
			$.post('services/accounts/authenticate.php', $('#loginForm').serialize(), function(data){
				data = jQuery.parseJSON(data);
				if(data.status == 200){
					location.href = 'dashboard.php';
				}else{
					alert(data.response);
				}
			})
		});
	});
	</script>
</head>
<body>
<h1>Sign in</h1>
<form id="loginForm">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" class="form-control">
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" class="form-control">
	</div>
 
	<button type="submit" class="btn btn-primary">Log In</button>
 </form>
 <video controls>
  <source src="movie.mp4" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">

  Your browser does not support the video tag.
</video>
 <a href="sign_up.php">Don't have an account?</a>
</body>
 </html>
