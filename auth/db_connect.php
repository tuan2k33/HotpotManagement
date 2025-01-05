<?php
// Change this to your connection info.
$DATABASE_HOST = '127.0.0.1:3306';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'info';

// Try and connect using the info above.
$con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?> 