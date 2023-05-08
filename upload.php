<?php  

require_once('php/config.php');
require_once('php/db.php');

session_start();

$error['upload'] = '';
$MAX_FILE_SIZE = 100000000;

if (isset($_SESSION['userId']))
{
	if (isset($_GET['v']) && !isset($_POST['uploadBtn']))
	{
		$videoId = $_GET['v'];

		if (strlen($videoId) != 11)
		{
			header('Location: home.php');
		}
		else
		{
			$check = $mysqli->prepare('SELECT id FROM videos WHERE id = ?');
			$check->bind_param('s', $videoId);
			$check->execute();
			$check->store_result();
			if (!$check->num_rows > 0)
			{
				$check->close();
				header('Location: home.php');
			}
			else
			{
				$check->close();
				include 'views/v_upload.php';
			}
		}
	}
	else if (!isset($_POST['uploadBtn']))
	{
		header('Location: index.php');
	}

	if (isset($_POST['uploadBtn']))
	{
		$videoId = $_POST['VIDEO_ID'];

		if (strlen($videoId) != 11)
		{
			$error['upload'] = 'Invalid video id';
			include 'views/v_upload.php';
		}
		else
		{
			$check = $mysqli->prepare('SELECT uploaded_by FROM videos WHERE id = ?');
			$check->bind_param('s', $videoId);
			$check->execute();
			$check->store_result();
			$check->bind_result($uploadedBy);
			if (!$check->num_rows > 0)
			{
				$check->close();
				$error['upload'] = 'Video id not in db';
				include 'views/v_upload.php';
			}
			else
			{
				$check->fetch();
				$check->close();

				if ($uploadedBy != null)
				{
					$error['upload'] = 'Video already uploaded';
					include 'views/v_upload.php';
				}
				else
				{
					$fileName = $_FILES['videoToUpload']['name'];
					$targetFileName = $videoId . '.mp4';
					if ($fileName != $targetFileName)
					{
						$error['upload'] = 'Wrong file name';
						include 'views/v_upload.php';
					}
					else
					{
						if($_FILES['videoToUpload']['size'] > $MAX_FILE_SIZE)
						{
							$error['upload'] = 'Max. file size exceeded';
							include 'views/v_upload.php';
						}
						else
						{
							$targetDir = getcwd() . '/uploads/';
							$targetFile = $targetDir . $fileName;

							if (file_exists($targetFile))
							{
								$error['upload'] = 'File already exists';
								include 'views/v_upload.php';
							}
							else
							{
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
										$error['upload'] = 'Success!';
										include 'views/v_upload.php';
										header('refresh:3;url=home.php');
									}
									else
									{
										$stmt = $mysqli->prepare('UPDATE videos SET uploaded_by=? WHERE id=?');
										$stmt->bind_param('is', NULL, $videoId);
										$stmt->execute();

										$error['upload'] = 'Error uploading file';
										include 'views/v_upload.php';
									}
								}
								else
								{
									$error['upload'] = 'Could not update db';
									include 'views/v_upload.php';
								}
							}
						}
					}
				}

			}
		}
	}
}
else
{
	header('Location: index.php');
}




?>