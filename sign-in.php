<?php require_once('php/config.php'); session_start(); ?>

<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Sign In</title>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/sign-in-up.css">
</head>
<body>
	<header>
		<h1 id="logo">FreeTube</h1>
		<nav>
			<p id="signUp">Sign Up<p>
		</nav>
	</header>

	<main>

		<section id="form">
			<h1>Sign In</h1>
			<form name='signUp' action='<?php echo BASE_URL ?>php/check_signUp.php' method='post'>
				<label for="email">Email</label>
				<input type='email' name='email' placeholder="Email">
				
				<label for="password">Password</label>
				<input type='password' name='password' placeholder="Password">

				<input id="signBtn" type='submit' name='signIn' value='Sign In'>

				<p>Don't have an account? <a href='<?php echo BASE_URL ?>sign-up.php'>Sign Up</a></p>
			</form>
		</section>
		
	</main>

	<script type="module" src="<?php echo BASE_URL; ?>js/sign-in.js"></script>
</body>
</html>