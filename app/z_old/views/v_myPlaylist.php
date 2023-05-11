<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>FreeTube | My Playlist</title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/layout.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/myplaylist.css">
	</head>

	<body>
		<header>
			<h1 id="logo">FreeTube</h1>
			<nav>
				<a href="<?php echo BASE_URL; ?>signout.php">Sign Out</a>
			</nav>
		</header>

		<main>

			<section id="title">
				<h1>My Playlist</h1>
			</section>

			<section id='searchWrapper'>
				<input id ='searchBar' type='text' name='searchBar' placeholder='search playlist videos...'>
				<input id='searchBtn' type='submit' value='Search'>
			</section>

			<section id="playlist"></section>			
		</main>

		<footer>
			<a href="#logo">Go Up</a>
		</footer>

		<!-- JS for this page -->
		<script type='module' src='<?php echo BASE_URL; ?>js/my-playlist.js'></script>
	</body>
</html>