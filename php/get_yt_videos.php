<?php  

require_once('helper_functions.php');

if (isset($_GET['search_query']))
{
	// convert all chars from search_query to HTML entities
	// prevent from malicious code injection
	$search_query = htmlentities($_GET['search_query'], ENT_QUOTES);

	$videos = getYtVideosByTitle($search_query);

	// send videos array to client (json encoded)
	echo json_encode($videos);

	// close db connection
    $mysqli->close();
}

?>