<?php 

require_once('php/config.php');
session_start(); 

if (!isset($_SESSION['userId']))
{
	header('Location: '.BASE_URL.'index.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>spotube | home</title>
		<link href='<?php echo BASE_URL; ?>styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<header>
				<a href='<?php echo BASE_URL; ?>upload.php'>Upload</a> |
				<a href='<?php echo BASE_URL; ?>my-videos.php'>My Videos</a>
			<nav>
				<form name='logout' action='<?php echo BASE_URL; ?>php/logout.php' method='post'>
					<input type='submit' name='logout' value='Log Out'>
				</form>
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
		<script type='module' src='<?php echo BASE_URL; ?>js/home.js'></script>
	</body>
</html>