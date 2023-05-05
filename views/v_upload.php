<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>spotube | upload</title>
</head>
<body>
	<header>
		<a href='<?php echo BASE_URL ?>home.php'>Home</a> >
		<span>Upload</span>
		<hr>
		<h1>Upload Video</h1>
	</header>
	<p>After you have downloaded the video on your computer, you can upload it to your account.</p>
	<form action="php/upload_video.php" method="post" enctype="multipart/form-data">
		Select video to upload:
		<input type="hidden" name="MAX_FILE_SIZE" value="100000000">
		<input type="hidden" name="VIDEO_ID" value="<?php echo $_GET['videoId']; ?>">
		<input type="hidden" name="USER_ID" value="<?php echo $_SESSION['userId']; ?>">
		<input type="file" name="videoToUpload" accept="video/mp4">
		<input type="submit" name="submit" value="Upload Video">
	</form>
</body>
</html>