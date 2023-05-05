<?php 
   
require_once('config.php');
require_once('db.php');

if(isset($_POST))
{
   // Get data from JSON file and store it
   $data = file_get_contents('php://input');
   $videos = json_decode($data, true);

   $len = count($videos);
   for ($i = 0; $i < $len; $i++)
   {
      $video = $videos[$i];

      $check = $mysqli->prepare('SELECT uploaded_by FROM videos WHERE id = ?');
      $check->bind_param('s', $video['id']);
      $check->execute();
      $check->store_result();
      $check->bind_result($uploaded_by);
      if ($check->num_rows > 0)
      {
         $check->fetch();

         $video['uploaded_by'] = $uploaded_by;

         $check->close();
      }
      else
      {
         $check->close();
         
         $stmt = $mysqli->prepare('INSERT videos (id, title) VALUES (?,?)');
         $stmt->bind_param('ss', $video['id'], $video['title']);
         $stmt->execute();
         $stmt->close();

         $video['uploaded_by'] = null;
      }

      $videos[$i] = $video;
   }

   echo json_encode($videos);

   // close db connection
   $mysqli->close();
}

?>