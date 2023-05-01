<?php  

require_once('config.php');
require_once('db.php');

session_start();

function isAnyStringEmpty(...$strings)
{
	foreach ($strings as $str)
	{
		if ($str == '')
		{
			echo 'empty string';
			return true;
		}
	}

	return false;
}

function isEmailValid($email)
{
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		echo 'invalid email';
		return false;
	}

	return true;
}

function isPasswordStrong($password)
{
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) 
	{
	    echo 'password not strong enough';
	    return false;
	}

	return true;
}

function isPasswordCorrect($input)
{
	global $mysqli;

	$stmt = $mysqli->prepare('SELECT password_hash FROM users WHERE email = ?');
	$stmt->bind_param('s', $input['email']);
	$stmt->execute();
	$stmt->bind_result($hash);
	$stmt->fetch();
	$stmt->close();

	if (password_verify($input['password'], $hash))
	{
		return true;
	}

	echo 'incorrect password';

	return false;
}


function isInputValidForLogin($input)
{
	if (isAnyStringEmpty($input['email'], $input['password'])
		|| !isEmailValid($input['email']) 
		|| !isPasswordStrong($input['password']))
	{
		return false;
	}

	return true;
}

function isInputValidForRegister($input)
{
	if (isAnyStringEmpty($input['email'], $input['password'], $input['confirm_password'])
		|| !isEmailValid($input['email'])
		|| $input['password'] != $input['confirm_password'] 
		|| !isPasswordStrong($input['password']))
	{
		return false;
	}

	return true;
}

function isEmailTaken($email)
{
	global $mysqli;

	$check = $mysqli->prepare('SELECT email FROM users WHERE email = ?');
	$check->bind_param('s', $email);
	$check->execute();
	$check->store_result();
	if ($check->num_rows == 0)
	{
		$check->close();
		return false;
	}

	echo 'Email already exists';
	return true;
}

function getUserIdByEmail($email)
{
	global $mysqli;

	$stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->bind_result($userId);
	$stmt->fetch();
	$stmt->close();

	return $userId;
}

function loginUser($email)
{
	$userId = getUserIdByEmail($email);

	$_SESSION['userId'] = $userId;
	$_SESSION['last_active'] = time();

	header('Location: '.BASE_URL.'home.php');
}

function getVideosByTitle($str)
{
	$param = '%' . $str . '%';
	$stmt = $mysqli->prepare('SELECT id, title FROM videos WHERE title LIKE ?');
	$stmt->bind_param('s', $param);
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
		$stmt->bind_param('s', $video_id);
		$stmt->execute();
		$stmt->bind_result($src_default, $src_high, $src_medium);
		$stmt->fetch();

		$videos[$i]['thumbnails'] = array();
		$videos[$i]['thumbnails']['default'] = $src_default;
		$videos[$i]['thumbnails']['high'] = $src_high;
		$videos[$i]['thumbnails']['medium'] = $src_medium;

		$stmt->close();
	}

	return $videos;
}

function addVideosToDatabase($videos)
{
  // Iterate array of videos 
  // and add to database if it doesn't already exist
  for ($i = 0, $n = count($videos); $i < $n ; $i++)
  {
  	 $video = $videos[$i];
     $id = $video['id'];
     $title = $video['title'];
     $img_src_default = $video['thumbnails']['default']['url'];
     $img_src_high = $video['thumbnails']['high']['url'];
     $img_src_medium = $video['thumbnails']['medium']['url'];

     // check if video is in db
     $stmt = $mysqli->prepare('SELECT id FROM videos WHERE id = ?');
     $stmt->bind_param('s', $id);
     $stmt->execute();
     $stmt->store_result();
     if($stmt->num_rows != 0)
     {
        // video is already in db
        echo "video already in db \r\n";
     }
     // if it's not in db, then add it
     else
     {
        // add video id, title to videos table
        $stmt = $mysqli->prepare('INSERT videos (id, title) VALUES (?,?)');
        $stmt->bind_param('ss', $id, $title);
        $stmt->execute();
        $stmt->close();

        // add thumbnail images' src to video_thumbnails table
        $stmt = $mysqli->prepare('INSERT video_thumbnails (id, src_default, src_high, src_medium) VALUES (?,?,?,?)');
        $stmt->bind_param('ssss', $id, $img_src_default, $img_src_high, $img_src_medium);
        $stmt->execute();
        $stmt->close();

        // provide feedback
        echo "video added successfully \r\n";
     }
  }
}



?>