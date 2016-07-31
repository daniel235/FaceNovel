<?php 
session_start();
require 'backend/database.php';
require 'backend/data.php';
require 'class.php';
$userId = $_SESSION['id'];
if(empty($userId)){
	header("Location: index.php");
}

$friend = $_GET['r'];
if(!empty($_POST)){
	$message = strip_tags($_POST['message']);
	$subject = strip_tags($_POST['subject']);
	header("Refresh: 2");
}

?>
<!DOCTYPE html>
<html>
<head>
	<script src="http://maps.googleapis.com/maps/api/js"></script>
	
	<script>
	var marker; 
	var myCenter=new google.maps.LatLng(51.508742,-0.120850);
	function initialize(){
		var mapProp = {
			center: myCenter,
			zoom: 5,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};
		var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);

		var marker = new google.maps.Marker({
			position: myCenter,
			animation: google.maps.Animation.BOUNCE
			});
		marker.setMap(map);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>
<body>
	<div class="header">
		<?php require 'backend/header.php'; ?>
	</div>
	<div id="googleMap" style="width:500px;height:380px;"></div>
	<div class="body">
		<br><br>
		<form style="text-align: center;" method="POST">
			<input style="width: 30%;" type="text" name="subject" placeholder="Enter subject in here">
			<br><br>
			<textarea style="margin-left: 60px; padding: 15px; width: 30%; height: 80px;" name="message"></textarea>
			<input style="color: black; background-color: #31c6d6;" type="submit" value="Reply">
		</form>
		<br><br>
		<p style="text-align: center;"><?php 
		$o = new Receive($conn, $con, $userId, $friend);
		$o->receive($conn, $con, $userId, $friend);
		?></p>
		<br>
		<br>
		<br>

		<p><?php $sel = $conn->query("SELECT * FROM user WHERE id = '$userId'");
			while($row = $sel->fetch(PDO::FETCH_ASSOC)){
				$username = $row['username'];
				if(!empty($_POST)){
					$i = new Message($con, $username, $subject, $friend, $message); 
					$i->send_message($con, $username, $subject, $friend, $message);
				}
			}
		?></p>
		<br><br>
	</div>
	<div class="footer">
	<br>
		<?php require 'backend/footer.php'; ?>
	</div>

</body>
</html>