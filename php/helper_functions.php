<?php  

require_once('config.php');
require_once('db.php');

function getYoutubeVideosByTitle($str)
{
	global $mysqli;

	$param = '%' . $str . '%';
	$stmt = $mysqli->prepare('SELECT yt_id, title FROM videos WHERE title LIKE ? AND yt_id IS NOT NULL');
	$stmt->bind_param('s', $param);
	$stmt->execute();
	$stmt->bind_result($yt_id, $title);
	
	// store results in array
	$videos = array();
	$index = 0;
	while ($stmt->fetch()) {
		$videos[$index]['yt_id'] = $yt_id;
		$videos[$index]['title'] = $title;
		$index++;
	}
	$stmt->close();
	
	return $videos;
}

function getVideosUploadedByUser($userId)
{
	global $mysqli;

	$stmt = $mysqli->prepare('SELECT id, yt_id, title FROM videos WHERE uploaded_by=?');
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($id, $yt_id, $title);
	
	// store results in array
	$videos = array();
	$index = 0;
	while ($stmt->fetch()) {
		$videos[$index]['id'] = $id;
		$videos[$index]['yt_id'] = $yt_id;
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

function getWordsFromString($str)
{
	$words = array();
	$specialWords = ["039", "quot"];
	$tok = strtok($str, " ,;?!-|.@*%#$^&()'\":_+/\\><~`");
	
	while ($tok !== false)
	{
		if (!in_array($tok, $specialWords))
		{
			$words[] = $tok;
		}

		$tok = strtok(" ,;?!-|.@*%#$^&()'\":_+/\\><~`");
	}
	
	return $words;
}

function calcStringEquality($string1, $string2)
{

	$str1 = getWordsFromString($string1);
	$str2 = getWordsFromString($string2);

	$i = 0; 
	$j = 0; 
	$count = 0;
	$n = count($str1); 
	$m = count($str2);

	while ($i < $n && $j < $m)
	{
		$wordI = $str1[$i];
		$wordJ = $str2[$j];
		
		if (strcmp($wordI, $wordJ) == 0)
		{
			$count++;
		}

		$i++;
		$j++;
	}

	$maxLen = max($n, $m);
	$equalityFactor = round($count / $maxLen * 100);

	return $equalityFactor;
}

function deleteFromTableById($tableName, $id)
{
	global $mysqli;

	$query = 'DELETE FROM ' . $tableName . ' WHERE id=?';

	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
}

function whereTitleLikeString($str)
{
	$words = getWordsFromString($str);
	$condition = "WHERE title LIKE '%$words[0]%' ";
	
	$len = count($words);
	for ($i = 1; $i < $len; $i++)
	{
		$condition .= "AND title LIKE '%$words[$i]% '";
	}

	return $condition;

}
?>