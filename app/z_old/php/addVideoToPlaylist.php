<?php  

require_once('db.php');

session_start();

if (!isset($_SESSION['userId']))
{
	echo json_encode('could not retrieve user id');
}
else
{
	if (isset($_POST))
	{
		// Get data from JSON file and store it
	   $data = file_get_contents('php://input');
	   $videoId = json_decode($data, true);

	   $defaultPlaylistName = 'My Playlist';
	   $limit = 1;
	   $stmt = $mysqli->prepare('SELECT id FROM playlists WHERE user_id=? AND name=? LIMIT ?');
	   $stmt->bind_param('isi', $_SESSION['userId'], $defaultPlaylistName, $limit);
	   $stmt->execute();
	   $stmt->store_result();
	   $stmt->bind_result($playlistId);
	   if ($stmt->num_rows > 0)
	   {
	   		$stmt->fetch();
	   		$stmt->close();

	   		$check = $mysqli->prepare('SELECT id FROM playlist_videos WHERE playlist_id=? AND video_id=?');
	   		$check->bind_param('is', $playlistId, $videoId);
	   		$check->execute();
	   		$check->store_result();
	   		if ($check->num_rows > 0)
	   		{
	   			$check->close();
	   			echo json_encode('video already in playlist');
	   			exit();
	   		}
	   		else
	   		{
	   			$check->close();

		   		$stmt = $mysqli->prepare('INSERT INTO playlist_videos (playlist_id, video_id) VALUES (?,?)');
		   		$stmt->bind_param('is', $playlistId, $videoId);
		   		if ($stmt->execute())
		   		{
		   			$stmt->close();
		   			echo json_encode('successfully added video to playlist');
		   			exit();
		   		}
		   		else
		   		{
		   			$stmt->close();
		   			echo json_encode('could not insert into playlist_videos');
		   			exit();
		   		}
	  		}
	  	}
	   	else
	   	{
	   		$stmt->close();

	   		$stmt = $mysqli->prepare('INSERT INTO playlists (user_id) VALUES (?)');
	   		$stmt->bind_param('i', $_SESSION['userId']);
	   		if($stmt->execute())
	   		{
	   			$playlistId = $stmt->insert_id;
	   			$stmt->close();

	   			$stmt = $mysqli->prepare('INSERT INTO playlist_videos (playlist_id, video_id) VALUES (?,?)');
		   		$stmt->bind_param('is', $playlistId, $videoId);
		   		if ($stmt->execute())
		   		{
		   			$stmt->close();
		   			echo json_encode('successfully added video to playlist');
		   			exit();
		   		}
		   		else
		   		{
		   			$stmt->close();
		   			echo json_encode('could not insert into playlist_videos');
		   			exit();
		   		}
	   		}
	   		else
	   		{
	   			$stmt->close();
	   			echo json_encode('could not insert into playslists');
	   			exit();
	   		}
	   	}
	}
	else
	{
		echo json_encode('post is not set');
		exit();
	}
}

?>