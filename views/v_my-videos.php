<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>spotube | my videos</title>
</head>
<body>
	<header>
		<a href='<?php echo BASE_URL ?>home.php'>Home</a> >
		<span>My Videos</span>
		<hr>
		<h1>My Videos</h1>
	</header>
	<main>
		<ol id="my_videos">
		</ol>
	</main>
	<script type='module' src='<?php echo BASE_URL; ?>js/my-videos.js'></script>
</body>
</html>