<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FreeTube | Page Not Found</title>
	<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/common.css'>
	<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/page-not-found.css'>
</head>
<body data-controller-name='<?php echo $controller_name ?>'>
	<header>
		<div id='logo'>
			<a href='<?php echo ROOT; ?>'>FreeTube</a>
		</div>

		<nav>
			<a href='<?php echo ROOT; ?>/sign-in'>Sign In</a>
		</nav>
	</header>
	<main>
		<h1>Page Not Found</h1>
		<h3>Ooops, nothing here.</h3>
		<p>It looks like the page you've tried to access does not exist.</p>
		<br>
		<a href='<?php echo ROOT; ?>'>Click here to go back to the home page.</a>
	</main>

</body>
</html>