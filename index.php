<?php
error_reporting(E_ALL & ~E_NOTICE);
require 'backend/database.php';

session_start();
session_write_close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>FaceNovel</title>
	<link rel="stylesheet" type="text/css" href="index-style.css">
	<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href='/' style="font-size: 30px;">FaceNovel<br></a>
		<a href="login.php">Login</a>
		<a href="register.php">Register</a>
	</div>
	<div class="jumbotron">
		<img src="http://piermonkey.com/wp-content/uploads/2016/03/Dollarphotoclub_99956429-600x300.jpg">
	</div>
	

	<div class="footer" style="position: absolute;">
		<a href="#">Contact us</a>
		<a href="#">Careers</a>
		<a href="#">About us</a>
	</div>
	

</body>
</html>