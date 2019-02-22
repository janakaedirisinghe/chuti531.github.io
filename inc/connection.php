<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'userdb';

$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if (mysqli_connect_errno()) {
	die('database connection failed'.mysqli_connect_error());
	echo "error";
}else{
	//echo  "connection successful ";
}

?>


