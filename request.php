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
//showing the request one by one 
foreach($conn->query("SELECT * FROM request WHERE friendId = '$userId' and friend = '$usernamer'") as $row){
	$user = $row['user'];
	$friendId = $row['userId'];
	$friend = $row['friend'];
	$userName[] = $user;
}
//make sure if there is a request to display if not dont show it.
if(!empty($row)){
	echo $friendId;
}
if (!empty( $_POST )){
	if(isset($_POST['type'])){
		if(!empty($row)){
			if($_POST['type'] == "add"){
				$d = new Accept($conn, $userId, $friendId);
				$d->accept_req($conn, $userId, $friendId);
				header("Refresh:2");
			}
			if($_POST['type'] == "delete"){
				$k = new Delete($conn, $userId, $friendId);
				$k->delete_req($conn, $userId, $friendId);
			}
		}
	}
}

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
<?php if(!empty($row)): ?>
<?php foreach($userName as $x): ?>
	<p><?php echo "Friend Request from " . $x . "<br>"?></p>
	<form method="POST">
		<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
		<input type="hidden" name="friend_id" value="<?php echo $friendId; ?>">
		<input type="hidden" name="type" value="add">
		<input type="submit" value="Accept Request">
	</form>
	<form method="POST">
		<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
		<input type="hidden" name="friend_id" value="<?php echo $friendId; ?>">
		<input type="hidden" name="type" value="delete">
		<input type="submit" value="Delete Request">
	</form>
<?php endforeach; ?>
<?php else: ?>
	<h2>No Friend Requests (Your lonely!) <br><br><a href="user.php">Back to profile</a></h2>
<?php endif; ?>
</div>
</body>
</html>
