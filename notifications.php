<?php 
session_start();
require 'backend/database.php';
require 'class.php';

$userId = $_SESSION['id'];

$stmtss = $conn->query("SELECT id, username FROM user WHERE id = '$userId'");
while($row = $stmtss->fetch(PDO::FETCH_ASSOC)){
	$userId = $row['id'];
	$usernamer = $row['username'];
}
header("Refresh:20");

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="index-style.css">
</head>
<body>
	<div class='header'>
		<?php require 'backend/header.php' ?>
	</div>
	<div class="body">
		<p><?php $n = new ShowRequest($conn, $userId, $usernamer);
		$n->show_req($conn, $userId, $usernamer); ?></p><br>
		<h2><a style="text-decoration:none; color: #31c6d6;" href="user.php">Back to Profile page</a></h2>
		
	</div>
	<br>

</body>
</html>