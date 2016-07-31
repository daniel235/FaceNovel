<?php 
session_start();
require 'backend/database.php';
require 'class.php';

$userId = $_SESSION['id'];

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="header">
	<?php require 'backend/header.php' ?>
</div>
<div class=""
<?php 
	$n = new Friends($conn, $userId);
	$n->friend_list($conn, $userId);
	$m = new Friends($conn, $userId);
	$m->friend_list2($conn, $userId);
?>
<br><br><br>
<button onclick="">click</button>
<a href="user.php">go back to home</a>
</body>
</html>