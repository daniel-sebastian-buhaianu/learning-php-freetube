<?php  

require_once('config.php');
require_once('db.php');

if (isset($_GET['fromId']) && isset($_GET['count']))
{
	$fromId = $_GET['fromId'];
	$count = $_GET['count'];
	$excludedVideo = 0;

	if (isset($_GET['exclude']))
	{
		$excludedVideo = $_GET['exclude'];
	}

	$videos = array();

	$stmt = $mysqli->prepare('SELECT id, yt_id, title FROM videos WHERE id >= ? AND id <> ? AND uploaded_by IS NOT NULL LIMIT ?');
	$stmt->bind_param("iii", $fromId, $excludedVideo, $count);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $yt_id, $title);
	if ($stmt->num_rows > 0)
	{
		$index = 0;
		while ($stmt->fetch())
		{
			$videos[$index]['id'] = $id;
			$videos[$index]['yt_id'] = $yt_id;
			$videos[$index]['title'] = $title;
			$index++;
		}
	}
	$stmt->close();
	$mysqli->close();

	echo json_encode($videos);
}


?>