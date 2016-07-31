<?php 
session_start();
require 'backend/data.php';
require 'class.php';
require 'backend/database.php';
$userId = $_SESSION['id'];

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div class="header">
		<?php require 'backend/header.php'; ?>
	</div>
	<div class="body">
		<a style="text-decoration: none; color: #31c6d6; font-size: 22px;"href="compose.php">Compose Message<br></a>
		<?php $y = new ShowMessage($conn, $con, $userId);
		$y->show_message($conn, $con, $userId); ?>
	</div>

</body>
</html>
