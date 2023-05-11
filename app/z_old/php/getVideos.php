<?php  

require_once('config.php');
require_once('db.php');

$count = 100;
$excludedVideo = '';
$like = '% %';
$uploaded = null;
$playlistName = null;

$videos = array();

if (isset($_GET['count']))
{
	$count = $_GET['count'];
}

if (isset($_GET['exclude']))
{
	$excludedVideo = $_GET['exclude'];
}

if (isset($_GET['like']))
{
	$like = '%' . $_GET['like'] . '%';
}

if (isset($_GET['uploaded']))
{
	$uploaded = $_GET['uploaded'];
}

if (isset($_GET['playlistName']))
{
	$playlistName = $_GET['playlistName'];
}

if ($playlistName == null || $playlistName == 'null')
{
	$stmt = null;

	if ($uploaded == 1)
	{
		$stmt = $mysqli->prepare(
			'SELECT id, title, uploaded_by 
				FROM videos 
					WHERE id NOT IN (?)
					AND title LIKE ?
					AND uploaded_by IS NOT NULL
					ORDER BY rand() 
					LIMIT ?');
	}
	else if ($uploaded == 0)
	{
		$stmt = $mysqli->prepare(
			'SELECT id, title, uploaded_by 
				FROM videos 
					WHERE id NOT IN (?)
					AND title LIKE ?
					AND uploaded_by IS NULL
					ORDER BY rand() 
					LIMIT ?');
	}
	else
	{
		$stmt = $mysqli->prepare(
			'SELECT id, title, uploaded_by 
				FROM videos 
					WHERE id NOT IN (?)
					AND title LIKE ?
					ORDER BY rand() 
					LIMIT ?');
	}

	$stmt->bind_param("ssi", $excludedVideo, $like, $count);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $title, $uploaded_by);
	if ($stmt->num_rows > 0)
	{
		$index = 0;
		while ($stmt->fetch())
		{
			$videos[$index]['id'] = $id;
			$videos[$index]['title'] = $title;
			$videos[$index]['uploaded_by'] = $uploaded_by;
			$index++;
		}
	}
	$stmt->close();
	$mysqli->close();

	echo json_encode($videos);
	exit();
}
else
{
	session_start();

	if (isset($_SESSION['userId']))
	{
		$userId = $_SESSION['userId'];

		$maxResults = 1;
		$stmt = $mysqli->prepare('SELECT id FROM playlists WHERE user_id=? AND name=? LIMIT ?');
		$stmt->bind_param('isi', $userId, $playlistName, $maxResults);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($playlistId);
		if ($stmt->num_rows > 0)
		{
			$stmt->fetch();
			$stmt->close();

			$stmt = $mysqli->prepare('SELECT video_id FROM playlist_videos WHERE playlist_id=?');
			$stmt->bind_param('i', $playlistId);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($videoId);

			$size = 0;
			while ($stmt->fetch())
			{
				$videos[$size]['id'] = $videoId;
				$size++;
			}
			$stmt->close();

			for ($i = 0; $i < $size; $i++)
			{
				$stmt = $mysqli->prepare('SELECT title, uploaded_by FROM videos WHERE id=?');
				$stmt->bind_param('s', $videos[$i]['id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($title, $uploadedBy);
				$stmt->fetch();

				$videos[$i]['title'] = $title;
				$videos[$i]['uploaded_by'] = $uploadedBy;

				$stmt->close();
			}

			echo json_encode($videos);
			exit();
		}
		else
		{
			$stmt->close();
			echo json_encode('no playlist found');
			exit();
		}
	}
	else
	{
		echo json_encode('could not get videos, user is not logged in');
		exit();
	}

}

?>