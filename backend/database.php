<?php
//connection to server and database
$host = 'localhost';
$dbname = 'auth';
$username = 'root';
$password = '';
//fixed with PDO
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);


if(!$conn){
	echo 'Not connected' . '<br>';
}

try{
	$conn->query('hi');
}
catch(PDOException $ex) {
	echo 'an error occured!';
	some_logging_function($ex->getMessage());
}




?>