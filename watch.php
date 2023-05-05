	<?php 

require_once('php/config.php'); 
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>FreeTube</title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/layout.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/watch.css">
	</head>

	<body>
		<header>
			<h1 id="logo">FreeTube</h1>
			<nav>
				<p id="signIn">Sign In<p>
			</nav>
		</header>

		<main>
			<section id='searchWrapper'>
				<input id ='searchBar' type='text' name='searchBar' placeholder='search youtube videos...'>
				<input id='searchBtn' type='submit' value='Search'>
			</section>

			<section id="video" data-video-id="<?php echo $_GET['v']; ?>">
				<video controls autoplay>
					<source 
						src="<?php echo BASE_URL; ?>uploads/<?php echo $_GET['v']; ?>.mp4" type="video/mp4">
				</video>	
			</section>
		
			<section id="alsoLike">
				<h2>You might also like...</h2>
			</section>

			<section id="videos">
			</section>
		</main>

		<footer>
			<a href="#logo">Go Up</a>
		</footer>

		<!-- Google API -->
		<script src='https://apis.google.com/js/api.js'></script>
		<!-- JS for this page -->
		<script type='module' src='<?php echo BASE_URL; ?>js/watch.js'></script>
	</body>
</html>