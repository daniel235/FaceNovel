<?php

if (isset($_SESSION['id'])) {
	$userId = $_SESSION['id'];
	$email = $_SESSION['username'];
 
	//fixed with PDO
 	$stmt = $conn->query("SELECT * FROM user WHERE id = '$userId'");
 	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 		$usernames = $row["username"];
 	}

 	$stmt = $conn->query("SELECT * FROM profile WHERE user_id = '$userId'");
 	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 		$dbusername = $row['username'];
 		$status = $row['status'];
 	}
}
else{
	header('Location: index.php');
}

?>