<?php  

include 'config.php';
include 'db.php';

if (isset($_GET['search_query']))
{
	// convert all chars from search_query to HTML entities
	// prevent from malicious code injection
	$search_query = htmlentities($_GET['search_query'], ENT_QUOTES);
	
	// get all videos from database which contain [search_query] in title name
	$param = '%' . $search_query . '%';
	$stmt = $mysqli->prepare('SELECT id, title FROM videos WHERE title LIKE ?');
	$stmt->bind_param("s", $param);
	$stmt->execute();
	$stmt->bind_result($id, $title);
	
	// store results in array
	$videos = array();
	$index = 0;
	while ($stmt->fetch()) {
		$videos[$index]['id'] = $id;
		$videos[$index]['title'] = $title;
		$index++;
	}
	$stmt->close();

	// now we need to get the thumbnails for each video
	for ($i = 0; $i < $index; $i++)
	{
		$video_id = $videos[$i]['id'];

		$stmt = $mysqli->prepare('SELECT src_default, src_high, src_medium FROM video_thumbnails WHERE id = ?');
		$stmt->bind_param("s", $video_id);
		$stmt->execute();
		$stmt->bind_result($src_default, $src_high, $src_medium);
		$stmt->fetch();

		$videos[$i]['thumbnails'] = array();
		$videos[$i]['thumbnails']['default'] = $src_default;
		$videos[$i]['thumbnails']['high'] = $src_high;
		$videos[$i]['thumbnails']['medium'] = $src_medium;

		$stmt->close();
	}

	// send videos array to client (json encoded)
	echo json_encode($videos);
}

?>