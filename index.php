<?php 

require_once('php/config.php'); 
session_start(); 

if (isset($_SESSION['userId']))
{
	header('Location: '.BASE_URL.'home.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>spotube</title>
		<link href='<?php echo BASE_URL; ?>styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<header>
			<nav>
				<a href='<?php echo BASE_URL; ?>login.php'>Log In</a>
				<a href='<?php echo BASE_URL; ?>register.php'>Register</a>
			</nav>
			<h1>SpoTube</h1>
		</header>

		<main>
			<div id='search_form'>
				<input id ='search_query' type='text' name='search_query' placeholder='search...'>
				<input id='search_btn' type='submit' value='Search'>
			</div>
		
			<div id='search_results'>
			</div>
		</main>
		
		<script src='https://apis.google.com/js/api.js'></script>
		<script type='module' src='<?php echo BASE_URL; ?>js/script.js'></script>
	</body>
</html>