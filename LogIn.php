<?php 
require 'backend/database.php';
error_reporting(E_ALL & ~E_NOTICE);
session_start();


if (!empty($_POST['email']) && !empty($_POST['password'])) {
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);

//fixed with PDO
	foreach($conn->query("SELECT id, email, password FROM user WHERE email='$email' AND password = '$password'") as $row){
		$userId = $row['id'];
		$dbEmail = $row['email'];
		$dbPassword = $row['password'];
	}

	if($email == $dbEmail && $password == $dbPassword) {
		$_SESSION['id'] = $userId;
		$_SESSION['username'] = $email;
		header('Location: user.php');
	}
	else{
		echo "Incorrect username or password.";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel='stylesheet' type='text/css' href='style.css'>
	<link rel="stylesheet" type="text/css" href="index-style.css">

</head>
<body>

	<div class="header">
		<a href='/'>FaceNovel</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Login</h1>
	<span>or <a href="register.php">register here</a></span>
	<form action="Login.php" method="POST">
		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="Password" name="password">
		<input type="submit" value="submit">
	</form>

	<div class="footer" style="position: absolute;">
		<a href="#">Contact us</a>
		<a href="#">Careers</a>
		<a href="#">About us</a>
	</div>

</body>
</html>