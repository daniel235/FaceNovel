<?php 
session_start();
require 'backend/database.php';
$userId = $_SESSION['id'];

//fixed with PDO
//grabbing the ids of friends so it doesnt display in the members list

foreach($conn->query("SELECT id, username FROM user WHERE id != '$userId'") as $row){
	$dbId = $row['id'];
	$dbuser = $row['username'];
	$id[] = $dbuser;
}

if (isset($_POST['username'])){
	$users = $_POST['username'];
	echo $users;
	header('Location: page.php?u=' . $users);
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
	<div class="list">
		<?php foreach($id as $x): ?>
			<?php echo $x . "<br>" . "<br>"; ?>
			<form action="members.php" method="POST">
				<input type="hidden" value="<?php echo $x; ?>" name ="username">
				<input type="submit" value="Add Friend">
			</form>
		<?php endforeach; ?>
	</div>

</body>
</html>