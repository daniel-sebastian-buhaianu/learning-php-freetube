<?php  

require_once('helper_functions.php');

if (isset($_POST['submit']) && isset($_POST['VIDEO_ID']))
{
	if (strlen($_POST['VIDEO_ID'] > 0))
	{

		$filename = $_FILES['videoToUpload']['name'];
		$videoName = substr($filename, 0, strlen($filename) - 4);

		$check = $mysqli->prepare('SELECT id, title FROM videos WHERE yt_id=?');
		$check->bind_param('s', $_POST['VIDEO_ID']);
		$check->execute();
		$check->bind_result($videoId, $dbVideoName);
		$check->fetch();
		$check->close();
		$dbVideoName = html_entity_decode($dbVideoName, ENT_QUOTES);

		$equalityFactor = calcStringEquality($videoName, $dbVideoName);

		if ($equalityFactor < 98)
		{
			echo "<p>Error: The file you are trying to upload doesn't match the one you've downloaded.</p>";
			exit();
		}

		$targetDir = getcwd() .'/../uploads/';
		$targetFile = $targetDir . $videoId . '.mp4';

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
		$stmt->bind_param('is', $_SESSION['userId'], $videoId);	
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
	else
	{
		$filename = $_FILES['videoToUpload']['name'];
		$videoName = substr($filename, 0, strlen($filename) - 4);
		$videoNameCoded = htmlentities($videoName, ENT_QUOTES);

		// Check if video already uploaded
		$param = '%' . getWordsFromString($videoNameCoded)[0] . '%';
		$check = $mysqli->prepare('SELECT id, title, uploaded_by FROM videos WHERE title LIKE ?');
		$check->bind_param('s', $param);
		$check->execute();
		$check->store_result();
		$check->bind_result($dbVideoId, $dbVideoTitle, $dbVideoUploadedBy);

		$videoId = 0;
		if ($check->num_rows > 0)
		{
			while ($check->fetch())
			{
				$equalityFactor = calcStringEquality($videoNameCoded, $dbVideoTitle);

				if ($equalityFactor > 98)
				{
					if ($dbVideoUploadedBy != NULL)
					{
						echo 'video already uploaded by someone';
						exit();
					}
					else
					{
						$videoId = $dbVideoId;
						break;
					}

				}
			}
		}
		else
		{
			echo 'no match';
		}
		$check->close();

		// If it's not uploaded yet, try to upload

		// If video is not in db, insert in db
		if ($videoId == 0)
		{
			$stmt = $mysqli->prepare('INSERT videos (title, uploaded_by) VALUES (?,?)');
			$stmt->bind_param('si', $videoNameCoded, $_SESSION['userId']);
			if ($stmt->execute())
			{
				$videoId = $mysqli->insert_id;
				$stmt->close();
			}
			else
			{
				echo 'could not insert in videos table';
				exit();
			}

			$stmt = $mysqli->prepare('INSERT video_thumbnails (id) VALUES(?)');
			$stmt->bind_param('i', $videoId);
			if($stmt->execute())
			{
				$stmt->close();
			}
			else
			{
				echo 'could not insert in video thumbnails';
				exit();
			}
		}
		// If video is in db, update db
		else
		{
			$stmt = $mysqli->prepare('UPDATE videos SET uploaded_by=? WHERE id=?');
			$stmt->bind_param("ii", $_SESSION['userId'], $videoId);
			if ($stmt->execute())
			{
				$stmt->close();
			}
			else
			{
				echo 'could not update db';
				exit();
			}
		}

		// Try to upload video
		$targetDir = getcwd() .'/../uploads/';
		$targetFile = $targetDir . $videoId . '.mp4';

		if (file_exists($targetFile))
		{
			echo '<p>Error: file already exists on filesystem</p>';
			exit();
		}

		if ($_FILES['videoToUpload']['size'] > $_POST['MAX_FILE_SIZE'])
		{
			echo '<p>Error: file is too big</p>';
			exit();
		}

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

			deleteFromTableById('videos', $videoId);
			deleteFromTableById('video_thumbnails', $videoId);

			exit();
		}
	
	}
	$mysqli->close();
}

?>