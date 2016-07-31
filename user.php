<?php
session_start();
require 'backend/database.php';
require 'backend/user-load.php';
require 'backend/header.php';
if(!empty($_SESSION["number"])){
	echo $_SESSION["number"];
}

error_reporting(E_ALL & ~E_NOTICE);
$_SESSION["color"] = "green";
$stmt = $conn->query("SELECT username FROM profile WHERE user_id = '$userId'");
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$usernames = $row["username"];
	}

if(!empty($_POST['status'])){
	$newstatus = strip_tags($_POST['status']);
	$dates = date("Y-m-d H:i:s");
	$insert = $conn->exec("INSERT INTO profile (user_id, username, status, dates) VALUES ('$userId', '$usernames', '$newstatus', '$dates')");
	echo $insert . ' were affected ';
	
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Secret User page</title>
	<link rel="stylesheet" type="text/css" href="index-style.css">
	<link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
<div id="container">
	<div class="greeting">
		Welcome, <?php echo $usernames; ?> You are logged in. Your user ID  is <?php echo $userId; ?>. <br /><br />
	</div>
	<div class="addpost">
		<img src="https://akimg2.ask.fm/assets/245/349/012/normal/facebook_default_no_profile_pic.jpg">
		<form action="user.php" method="post">
			<input type="text" name="status">
			<input type="submit" name="submit">
		</form>
	</div>
	<div class="News">
		<img src="https://akimg2.ask.fm/assets/245/349/012/normal/facebook_default_no_profile_pic.jpg">
		<h3>
		<?php
		$stmt = $conn->query("SELECT * FROM profile WHERE user_id = '$userId' ORDER BY id DESC LIMIT 8");

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$username = $row["username"];
			$status = $row["status"];
			echo $usernames . "<br>";
			echo $status . "<br>" . "<br>";
		}
		?></h3>
	</div>
	<form action="logout.php">
		<input type="submit" value="Log Me Out">
	</form>

	<?php require 'backend/footer.php'; ?>
</div>


</body>
</html>