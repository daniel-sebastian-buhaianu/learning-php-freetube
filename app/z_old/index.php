<?php  

require_once('php/config.php'); 
session_start(); 

if (isset($_SESSION['userId']))
{
	header('Location: '.BASE_URL.'home.php');
}
else
{
	include 'views/v_index.php';
}

?>