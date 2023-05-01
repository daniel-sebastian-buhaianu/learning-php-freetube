<?php require_once('php/config.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Register</title>
</head>
<body>
	<header>
		<a href='<?php echo BASE_URL ?>index.php'>Home</a> >
		<span>Register</span>
		<hr>
		<h1>Register</h1>
	</header>

	<main>
		<p>To create a new account, please fill in the form below:</p>
		<form name='register' action='<?php echo BASE_URL ?>php/check_register.php' method='post'>
			<label for='email'>email:</label>
			<input type='email' name='email'>
			<label for='password'>password:</label>
			<input type='password' name='password'>
			<label for='confirm_password'>confirm_password:</label>
			<input type='password' name='confirm_password'>
			<input type='submit' name='submit' value='register'><hr>
		</form>
		<p>If you already have an account, <a href='<?php BASE_URL ?>login.php'>please log in.</a></p>
	</main>
	
</body>
</html>