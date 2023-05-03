<?php  

require_once('helper_functions.php');

if (isset($_POST['submit']))
{

	$filename = $_FILES['videoToUpload']['name'];
	$filename = substr($filename, 0, strlen($filename) - 4);

	$check = $mysqli->prepare('SELECT title FROM videos WHERE id=?');
	$check->bind_param('s', $_POST['VIDEO_ID']);
	$check->execute();
	$check->bind_result($videoTitle);
	$check->fetch();
	$check->close();
	$videoTitle = html_entity_decode($videoTitle, ENT_QUOTES);

	$equalityFactor = calcStringEquality($filename, $videoTitle);

	if ($equalityFactor < 98)
	{
		echo "<p>Error: The file you are trying to upload doesn't match the one you've downloaded.</p>";
		exit();
	}

	$targetDir = getcwd() .'/../uploads/';
	$targetFile = $targetDir . $_POST['VIDEO_ID'] . '.mp4';

	if (file_exists($targetFile))
	{
		echo '<p>Error: file already exists</p>';
		exit();
	}

	if ($_FILES['videoToUpload']['size'] > $_POST['MAX_FILE_SIZE'])
	{
		echo '<p>Error: file is too big</p>';
		exit();
	}

	$stmt = $mysqli->prepare('UPDATE videos SET uploaded_by=? WHERE id=?');
	$stmt->bind_param('is', $_SESSION['userId'], $_POST['VIDEO_ID']);	
	if ($stmt->execute())
	{
		$stmt->close();

		if (!is_dir($targetDir)) 
		{
			mkdir($targetDir, 0755);
		}

		if (move_uploaded_file($_FILES['videoToUpload']['tmp_name'], $targetFile))
		{
			echo '<p>File is valid and was successfully uploaded!</p>';
			exit();
		}
		else
		{
			echo '<p>Error uploading file</p>';
			exit();
		}
	}
	else
	{
		echo 'Error: could not update database';
		exit();
	}
}

?>