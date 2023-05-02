<?php  

require_once('php/config.php');
session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>spotube | upload</title>
</head>
<body>
	<h1>Upload Video</h1>
	<p>After you have downloaded the video on your computer, you can upload it to your account.</p>
	<form action="php/upload_video.php" method="post" enctype="multipart/form-data">
		Select video to upload:
		<input type="hidden" name="MAX_FILE_SIZE" value="100000000">
		 <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
		<input type="file" name="videoToUpload">
		<input type="submit" name="submit" value="Upload Video">
	</form>
</body>
</html>