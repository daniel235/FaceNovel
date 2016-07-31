<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'class.php';
session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'backend/database.php';

$message = '';


if(!empty($_POST['email']) && !empty($_POST['password'])):
	//enter the new user
	$username = strip_tags($_POST['username']);
	$em = strip_tags($_POST['email']);
	$pass = strip_tags($_POST['password']);
	$u = new Username($conn, $em, $username);
	$u2 = $u->user_check($conn, $em, $username);
	if(!$u2){
		$f = new Add($conn, $em, $username, $pass);
		$f->add_user($conn, $em, $username, $pass);
	}
	else{
		echo 'fail dewd';
	}
endif; 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel='stylesheet' type='text/css' href='index-style.css'>
</head>
<body>
	<div class="header">
		<a href='/'>FaceNovel</a>
	</div>

	<?php 
	if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Register</h1>
	<form action="register.php" method="POST">
		<input type="text" placeholder="Username" name="username">
		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="Password" name="password">
		<input type="password" placeholder="Confirm password" name="confirm_password">
		<br>
		<input type="submit" value="Submit">
	</form>
	<span>or <a href="login.php">login here</a></span>

	<div class="footer" style="position: absolute;">
		<a href="#">Contact us</a>
		<a href="#">Careers</a>
		<a href="#">About us</a>
	</div>
</body>
</html>
