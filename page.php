<?php 

session_start();
$userId = $_SESSION['id'];
echo $userId;

require 'backend/database.php';
require 'class.php';
require 'backend/data.php';
$username = $_GET['u'];
if( isset($_GET['u'])) {
	$username = $_GET['u'];
	if(ctype_alnum($username)){
		$stmt = $conn->query("SELECT username FROM user WHERE username = '$username'");
		$row_count = $stmt->rowCount();
		if ($row_count===1){
			$get = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!empty($get)){
				$username = $get['username'];
			}
		}
		else{
			echo 'fail on the ctype';
			header("Location: user.php");
		}
	}
}
$stmts = $conn->query("SELECT id, username FROM user WHERE username = '$username'");
while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
	$id = $row['id'];
	$dbuser = $row['username'];
}

$stmtss = $conn->query("SELECT id, username FROM user WHERE id = '$userId'");
while($row = $stmtss->fetch(PDO::FETCH_ASSOC)){
	$userId = $row['id'];
	$usernamer = $row['username'];
}

$sel = new Query($conn, $username);
$sel->get_user($conn, $username);


$sells = new Friend($conn, $id, $userId);
$sells->friend_check($conn, $id, $userId);

if (!empty( $_POST )){
	if($_POST['type'] == "add"){
		$new = new AddFriend($userId, $usernamer, $id, $dbuser);
		$new->add_friend($userId, $usernamer, $id, $dbuser);
	}
	if($_POST['type'] == "remove"){
		$stmts = $conn->query("SELECT id, username FROM user WHERE username = '$username'");
		while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
			$id = $row['id'];
			$dbuser = $row['username'];
			$a = new Remove($conn, $userId, $id);
			$a->remove_friend($conn, $userId, $id);
		}
	}
}





?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to your Web App</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<?php require 'backend/header.php'; ?>
	</div>
	<div class="button">
	<?php $check = new RequestCheck($conn, $userId, $id); 
	$check2 = $check->req_check($conn, $userId, $id);
	if($check2): ?>
		<h3>Request Sent</h3>
	<?php else: ?>
		<?php $fr = new Friend($conn, $id, $userId);
		$fr2 = $fr->friend_check($conn, $id, $userId);
		if($fr2): ?>
			<form method="POST">
				<input type="hidden" name="friend_id" value="<?php echo $id; ?>">
				<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
				<input type="hidden" name="type" value="remove">
				<input type="submit" value="Remove Friend">
			</form>
		<?php else: ?>
			<form method="POST">
				<input type="hidden" name="friend_id" value="<?php echo $id; ?>">
				<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
				<input type="hidden" name="type" value="add">
				<input type="submit" value="Add Friend">
			</form>

		<?php endif; ?>
	<?php endif; ?>
	</div>
	<div class="profile">
	<h2>Profile page for: <?php $username = $_GET['u'];
	 echo $username; ?></h2>
	<img src="https://akimg2.ask.fm/assets/245/349/012/normal/facebook_default_no_profile_pic.jpg">
	<a href="members.php">Back to members!</a>
	</div>
	<div class="News">
		<h2><?php 
		$status = new Status($conn, $username);
		$status->get_status($conn, $username);
		?></h2>
	</div>


</body>
</html>