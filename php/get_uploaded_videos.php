<?php  

require_once('helper_functions.php');

if (isset($_SESSION['userId']))
{
	$videos = getVideosUploadedByUser($_SESSION['userId']);

	// send videos array to client (json encoded)
	echo json_encode($videos);

	// close db connection
    $mysqli->close();
}
else
{
	echo json_encode('session userId is not set');
}

?>