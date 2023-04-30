<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
</head>
<body>
	<header>
		<a href="../index.html">Home</a> >
		<span>Register</span>
		<hr>
		<h1>Register</h1>
	</header>

	<main>
		<p>To create a new account, please fill in the form below:</p>
		<form method="post">
			email:
			<input type="email" name="email"><br><br>
			password:
			<input type="password" name="password"><br><br>
			confirm password:
			<input type="confirm_password" name="confirm_password"><br><br>
			<input type="submit" value="register"><hr>
		</form>
		<p>If you already have an account, <a href="../php/login.php">please log in.</a></p>
	</main>
	
</body>
</html>