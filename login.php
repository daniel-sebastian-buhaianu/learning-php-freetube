<?php require_once('php/config.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Log In</title>
</head>
<body>
	<header>
		<a href='<?php echo BASE_URL ?>index.php'>Home</a> >
		<span>Log In</span>
		<hr>
		<h1>Log In</h1>
	</header>

	<main>
		<p>To log in, please fill in the form below:</p>
		<form name='login' action='<?php echo BASE_URL ?>php/check_login.php' method='post'>
			<label for='email'>email:</label>
			<input type='email' name='email'>
			<label for='password'>password:</label>
			<input type='password' name='password'>
			<input type='submit' name='submit' value='log in'><hr>
		</form>
		<p>If you don't have an account, <a href='<?php echo BASE_URL ?>register.php'>please register.</a></p>
	</main>
	
</body>
</html>