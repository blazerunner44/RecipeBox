<!Doctype html>
<html>
<head>
	<title>Sign up</title>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" type="text/css" href="css/sign_up.css">

  <script type="text/javascript">
  $(document).ready(function(){
    $('#signupForm').submit(function(submit){
      submit.preventDefault();
      $.post('services/accounts/signup.php', $('#signupForm').serialize(), function(data){
        data = jQuery.parseJSON(data);
        if(data.status == 200){
          location.href = "dashboard.php";
        }else{
          alert(data.response);
        }
      })
    });
  });
  </script>

</head>
<body>
<h1>Sign up</h1>
<div id = "errors">
  there was an error
</div>
<form id="signupForm">
  <div class="form-group">
    <label>Username</label>
    <input required type="text" name="username" class="form-control">
  </div>

  <div class="form-group">
    <label>Password</label>
    <input required type="password" name="password" class="form-control">
  </div>

  <div class="form-group">
    <label>First Name</label>
    <input required type="text" name="firstName" class="form-control">
  </div>

  <div class="form-group">
    <label>Last Name</label>
    <input required type="text" name="lastName" class="form-control">
  </div>

  <div class="form-group">
    <label>Email</label>
    <input required type="email" name="email" class="form-control">
  </div>
  
  <button type="submit" class="btn btn-primary">Sign Up</button>
  <a href="index.php">Didn't mean to go here?</a>
 </form>
</body>
 </html>
