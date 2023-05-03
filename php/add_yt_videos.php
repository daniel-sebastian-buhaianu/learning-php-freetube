<?php 
   
require_once('helper_functions.php');

if(isset($_POST))
{
   // Get data from JSON file and store it
   $data = file_get_contents('php://input');
   $videos = json_decode($data, true);
   addVideosToDatabase($videos); 

   // close db connection
   $mysqli->close();
}

?>