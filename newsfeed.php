<?php 
session_start();
$userId = $_SESSION['id'];
if(empty($userId)){
	header("Location: index.php");
}
require 'backend/database.php';
require 'class.php';

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
		<?php  
		$stmt1 = $conn->query("SELECT * FROM friends WHERE user_id = '$userId'");
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
			$friendId = $row['friend_id'];
			echo $friendId . "<br>";
			$m = new News($conn, $friendId);
			$m->news_feed($conn, $friendId);
		}
		$stmt2 = $conn->query("SELECT * FROM friends WHERE friend_id = '$userId'");
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$friendId2 = $row['user_id'];
			$s = new News($conn, $friendId2);
			$s->news_feed($conn, $friendId2);
		}
		$n = new News($conn, $userId); 
		$n->news_feed($conn, $userId); 
		?>
	</div>

</body>
</html>