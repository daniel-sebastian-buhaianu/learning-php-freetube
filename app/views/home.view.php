<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>FreeTube</title>
		<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/common.css'>
		<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/index.css'>
	</head>

	<body data-is-user-signed-in='<?php echo $is_user_signed_in ?>'>
		<header>
			<div id='logo'>
				<a href='<?php echo ROOT; ?>'>FreeTube</a>
			</div>

			<nav>
			<?php

			if ( true === $is_user_signed_in ) {

				echo "<a href='" . ROOT . "/sign-out'>Sign Out</a>";

			} else {

				echo "<a href='" . ROOT . "/sign-in'>Sign In</a>";
			}

			?>
			</nav>
		</header>

		<main>
			<section class='search-video'>
				<input class='search-video-input' type='text' name='search-video-input' placeholder='search youtube videos...'>
				<input class='search-video-btn' type='submit' value='Search'>
			</section>

			<?php  

			if ( ! empty( $data ) ) {

				echo print_r($data);
			} else {
				echo 'asadas';
			}

			?>
		</main>

		<script src='https://apis.google.com/js/api.js'></script>
		<script type='module' src='<?php echo ROOT; ?>/assets/js/Home.js'></script>
	</body>
</html>