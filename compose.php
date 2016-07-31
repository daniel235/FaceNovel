<?php 
session_start();
require 'backend/database.php';
require 'backend/data.php';
require 'class.php';

$userId = $_SESSION['id'];
if(empty($userId)){
	header("Location: index.php");
}

$stmt1 = $conn->query("SELECT * FROM friends WHERE user_id = '$userId'");
while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
	$friendId = $row['friend_id'];
	$stmt = $conn->query("SELECT * FROM user WHERE id = '$friendId'");
	while($rowo = $stmt->fetch(PDO::FETCH_ASSOC)){
		$friendUser = $rowo['username'];
		$id2[] = $friendUser;
	}
}
$stmt5 = $conn->query("SELECT * FROM friends WHERE friend_id = '$userId'");
while($rowi = $stmt5->fetch(PDO::FETCH_ASSOC)){
	$friendId = $rowi['user_id'];
	$stmt2 = $conn->query("SELECT * FROM user WHERE id = '$friendId'");
	while($rowa = $stmt2->fetch(PDO::FETCH_ASSOC)){
		$friendUser2 = $rowa['username'];
		$id[] = $friendUser2;
	}
}
if(!empty($_POST)){
	$user = $_POST['user_id'];
	echo $user;
	$friend = $_POST['friend_id'];
	echo $friend;
	header("Location: compose2.php?m=" . $friend);
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
	<?php if(!empty($id)): ?>
		<?php foreach($id as $x): ?>
			<?php echo $x . "<br>" . "<br>"; ?>
			<form method="POST">
				<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
				<input type="hidden" name="friend_id" value="<?php echo $x; ?>">
				<input type="submit" value="Send Message">
			</form>
		<?php endforeach; ?>
		<?php if(!empty($id2)): ?>
		<?php foreach($id2 as $y): ?>
			<?php echo $y . "<br>" . "<br>"; ?>
			<form method="POST">
				<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
				<input type="hidden" name="friend_id" value="<?php echo $x; ?>">
				<input type="submit" value="Send Message">
			</form>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php else: ?>
		<?php if(!empty($id2)): ?>
		<?php foreach($id2 as $y): ?>
			<?php echo $y . "<br>" . "<br>"; ?>
			<form method="POST">
				<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
				<input type="hidden" name="friend_id" value="<?php echo $y; ?>">
				<input type="submit" value="Send Message">
			</form>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php endif; ?>
	</div>
</body>
</html>