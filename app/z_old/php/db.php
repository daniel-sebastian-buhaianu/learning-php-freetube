<?php  

include 'confidential.php';

$hostname = 'localhost';
$username = 'dsb99@localhost';
$password = $db_pass;
$database = 'spotube';

$mysqli = new mysqli($hostname, $username, $password, $database);

?>