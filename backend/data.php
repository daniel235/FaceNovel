<?php 

$host='localhost';
$username = 'root';
$password = '';
$db = 'auth2';

$con = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $username, $password);

if(!$con){
	echo 'not connected';
}

try{
	$con->query('hi');
}
catch(PDOException $ex) {
	echo 'an error occured!';
	some_logging_function($ex->getMessage());
}



?>