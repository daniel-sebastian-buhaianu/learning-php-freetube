<?php  

require_once('php/config.php');
session_start();

$isMember = 0;

if (isset($_SESSION['userId']))
{
	$isMember = 1;
}

include 'views/v_watch.php';

?>