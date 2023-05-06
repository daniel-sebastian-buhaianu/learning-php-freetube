<?php  

require_once('config.php');
require_once('db.php');

$count = 10;
$excludedVideo = '';
$like = '% %';
$isMember = 0;
$uploaded = null;

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

if (isset($_GET['isMember']))
{
	$isMember = $_GET['isMember'];
}
if (isset($_GET['uploaded']))
{
	$uploaded = $_GET['uploaded'];
}

$stmt = null;
if (!$isMember)
{
	$stmt = $mysqli->prepare(
		'SELECT id, title, uploaded_by 
			FROM videos 
				WHERE id NOT IN (?)
				AND title LIKE ?
				ORDER BY rand() 
				LIMIT ?');
}
else
{
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

?>