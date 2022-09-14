<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="header" class="header">
		<h2>Sign in</h2>
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
		<div class="input-group">
			<button type="submit" name="login" class="btn">Sign in</button>
		</div>
		<p>
			Not yet a member? <a href = "register.php">Sign up</a>
		</p>
	</form>
</body>
</html>