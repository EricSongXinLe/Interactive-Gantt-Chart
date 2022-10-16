<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class = "bg-light">
	<div class="navbar navbar-light bg-white px-3">
		<div class="container">
			<a class="navbar-brand">Sign in</a>
		</div>
	</div>
	<form method = "post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type = "text" name="username">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type = "password" name="password">
		</div>
		<div>
			<button type="submit" name="login" class="btn btn-outline-danger">Sign in</button>
		</div>
		<p>
			Not yet a member? <a href = "register.php">Sign up</a>
		</p>
	</form>
</body>
</html>