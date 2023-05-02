<?php  

require_once('config.php');

if (isset($_POST['submit']))
{

	echo '<p>Max file size: ' . $_POST['MAX_FILE_SIZE'] . '</p>';

	echo '<p> File size: ' . $_FILES['videoToUpload']['size'] . '</p>';

	$uploaddir = getcwd() .'/../uploads/';
	$uploadfile = $uploaddir . basename($_FILES['videoToUpload']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['videoToUpload']['tmp_name'], $uploadfile)) {
	    echo "File is valid, and was successfully uploaded.\n";
	} else {
	    echo "Possible file upload attack!\n";
	}

	echo 'Here is some more debugging info:';
	print_r($_FILES);

	print "</pre>";
}

?>