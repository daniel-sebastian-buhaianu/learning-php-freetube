<?php  

require_once('php/config.php');
session_start();

if (!isset($_SESSION['userId']))
{
	header('Location: index.php');
}
else
{
	include 'views/v_myaccount.php';
}

?>