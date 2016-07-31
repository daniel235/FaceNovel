<?php 
session_start();
require 'backend/database.php';
require 'backend/data.php';
require 'class.php';
$userId = $_SESSION['id'];
if(empty($userId)){
	header("Location: index.php");
}

$friend = $_GET['m'];
$stmt = $conn->query("SELECT * FROM user WHERE id = '$userId'");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$username = $row['username'];
}
if(!empty($_POST)){
	if(!empty($_POST['sender']) && !empty($_POST['message'])){
		$message = strip_tags($_POST['message']);
		$subject = strip_tags($_POST['subject']);
		$send = new Message($con, $username, $subject, $friend, $message);
		$send->send_message($con, $username, $subject, $friend, $message);
	}
}


?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div class="header">
		<?php require 'backend/header.php' ?>
	</div>
	<div class="body">
		<p>Compose Message</p>
		<p>Send to <?php echo $friend; ?></p>
		<form method="POST">
			<input type="text" name="subject" placeholder="Subject">
			<br>
			<input type="hidden" name="sender" value="<?php echo $username; ?>">
			<input type="hidden" name="receiver" value="<?php echo $friend; ?>">
			<textarea style="width: 30%; height: 80px;" name="message" placeholder="Enter in message"></textarea>
			<br>
			<input type="submit" value="Send Message">
		</form>
		<br>
		<br>
		<a style="text-decoration:none;" href="message.php">Back to messages</a>
	</div>
</body>
</html>