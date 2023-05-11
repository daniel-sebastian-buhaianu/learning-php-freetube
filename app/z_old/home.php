<?php  

require_once('php/config.php');
session_start();

$isMember = false;

if (!isset($_SESSION['userId']))
{
	header('Location: index.php');
}
else
{
	$isMember = true;
	include 'views/v_home.php';
}

?>