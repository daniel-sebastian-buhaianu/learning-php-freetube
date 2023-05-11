<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>FreeTube | Upload Video</title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/layout.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/upload.css">
	</head>
<body>
	<header>
		<h1 id="logo">FreeTube</h1>
		<nav>
			<a href="<?php echo BASE_URL; ?>myaccount.php">My Account</a>
		</nav>
	</header>

	<main>
		<section id="title">
			<h1>Upload Video</h1>
		</section>

		<section id="main">
			<div id="instructions">
				<h3>Instructions:</h3>
				<ol>
					<li>A new tab has opened. Click on it, then click on the green "Download" button to download the video on your computer.</li>
					<li>Once the video has been downloaded, rename it to <strong>"<?php echo $_GET['v'];?>.mp4"</strong></li>
					<li>Click on the "Browse" button below, and select <strong>"<?php echo $_GET['v'];?>.mp4"</strong> from the folder where you have downloaded the video. (Usually, it's in the "Downloads" folder)</li>
					<li>If you have followed all the previous steps correctly, now you should be able to click on the "Upload" button to upload the video to the server.</li>
					<li>When the video has been successfully uploaded, you will be redirected to your playlist.</li>
					<li>Enjoy watching :) !</li>
				</ol>	
			</div>		
			<form id="uploadVideoForm" action="" name="uploadVideo" method="post" enctype="multipart/form-data">

				<label for="videoToUpload">Select <strong>"<?php echo $_GET['v'];?>.mp4"</strong> from your computer:</label>
				<input id="fileInput" type="file" name="videoToUpload" accept="video/mp4">
				<input id="uploadBtn" type="submit" name="uploadBtn" value="Upload" disabled>

				<?php 

					if ($error['upload'] != '')
					{
						echo "<p class='error'>" . $error['upload'] . "</p>";
					}

				?>

				<input id="maxFileSize" type="hidden" name="MAX_FILE_SIZE" value="100000000">
				<input id="videoId" type="hidden" name="VIDEO_ID" value="<?php echo $_GET['v']; ?>">
				<input id="userId" type="hidden" name="USER_ID" value="<?php echo $_SESSION['userId']; ?>">
			</form>
		</section>
	</main>
	<!-- JS for this page -->
	<script type='module' src='<?php echo BASE_URL; ?>js/upload.js'></script>
</body>
</html>