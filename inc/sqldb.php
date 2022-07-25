<?php

$server = "localhost";
$dbUser = "root";
$dbPW = "";
$dbName = "flightbuddy";
$connection = mysqli_connect($server, $dbUser, $dbPW, $dbName);
if (!$connection) {
	die("Connection to server failed:" . mysqli_connect_error());
}
?>