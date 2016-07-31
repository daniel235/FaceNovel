<?php 
require 'backend/database.php';
require 'backend/data.php';

class Query {
	var $username;
	var $conn;

	public function __construct($conn, $username){
		$this->conn = $conn;
		$this->username = $username;
	}
	public function get_user($conn, $username){
		$stmts = $conn->query("SELECT id, username FROM user WHERE username = '$username'");
		while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
			$id = $row['id'];
			$dbuser = $row['username'];
			return $id;
		}
	}
}

//selecting from the friend database
class Friend {
	var $id;
	var $conn;
	var $userId;

	public function __construct($conn, $id, $userId) {
		$this->conn = $conn;
		$this->id = $id;
		$this->userId = $userId;
	}
	public function friend_check($conn, $id, $userId){
		$stmto = $conn->query("SELECT user_id, friend_id FROM friends WHERE user_id = '$userId' AND friend_id = '$id'");
		while ($row = $stmto->fetch(PDO::FETCH_ASSOC)){
			$uid = $row['user_id']; 
			$fid = $row['friend_id'];
			return $uid;
			return $fid;
		}
		$stmti = $conn->query("SELECT user_id, friend_id FROM friends WHERE friend_id = '$userId' AND user_id = '$id'");
		while ($rowo = $stmti->fetch(PDO::FETCH_ASSOC)){
			$uid2 = $rowo['user_id'];
			$fid2 = $rowo['friend_id'];
		}
	}
}

//echo out the status
class Status {
	var $conn;
	var $username;

	public function __construct($conn, $username){
		$this->conn = $conn;
		$this->username = $username;
	}
	public function get_status($conn, $username){
		$stmt = $conn->query("SELECT * FROM profile WHERE username = '$username'");
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$usernames = $row['username'];
			$status = $row['status'];
			echo strip_tags($usernames . "<br>", "<br>");
			echo strip_tags($status . "<br>" . "<br>", "<br>");
		}
	}
}
//add friend
class AddFriend {
	var $userId;
	var $username;
	var $friendId;
	var $friend;

	public function __construct($userId, $username, $friendId, $friend){
		$this->userId = $userId;
		$this->username = $username;
		$this->friendId = $friendId;
		$this->friend = $friend;
	}
	public function add_friend($userId, $username, $friendId, $friend){
		$host = 'localhost';
		$user = 'root';
		$password = '';
		$db = 'auth';
		$con = mysqli_connect($host, $user, $password, $db);
		if(!$con){
			return 'not connected to database';
		}
		$sql = "INSERT INTO request (userId, user, friendId, friend) VALUES ('$userId','$username', '$friendId', '$friend')";
		if ($con->query($sql) === TRUE){
			echo "New record created successfully";
		}
		else{
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}
}
//check if there are request
class RequestCheck {
	var $user_id;
	var $friend_id;
	var $conn;

	public function __construct($conn, $user_id, $friend_id){
		$this->conn = $conn;
		$this->user_id = $user_id;
		$this->friend_id = $friend_id;
	}

	public function req_check($conn, $user_id, $friend_id){
		$stmt = $conn->query("SELECT * FROM request WHERE userId = '$user_id' AND friendId = '$friend_id'");
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$ruser = $row['user'];
			$rfriend = $row['friend'];
			return $ruser;
			return $rfriend;
		}
	}
}

class Username {
	var $conn;
	var $email;
	var $username;

	public function __construct($conn, $email, $username){
		$this->conn = $conn;
		$this->email = $email;
		$this->username = $username;
	}
	public function user_check($conn, $email, $username){
		$stmt = $conn->query("SELECT * FROM user WHERE email = '$email' or username = '$username'");
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$emails = $row['email'];
			$usernames = $row['username'];
			return $emails;
			return $usernames;
		}
	}
}
//add user
class Add {
	var $conn;
	var $username;
	var $email;
	var $password;

	public function __construct($conn, $username, $email, $password){
		$this->conn = $conn;
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}
	public function add_user($conn, $email, $username, $password){
		try {
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO user(username, email, password) VALUES('$username','$email','$password')";
			$conn->exec($sql);
			echo "New record created";
		}
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}
//display all my requests
class ShowRequest{
	var $conn;
	var $userId;
	var $usernamer;

	public function __construct($conn, $userId, $usernamer){
		$this->conn = $conn;
		$this->userId = $userId;
		$this->usernamer = $usernamer;
	}

	public function show_req($conn, $userId, $usernamer){
		$stmt = $conn->query("SELECT user, friend FROM request WHERE friendId = '$userId' and friend = '$usernamer'");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$users = $row['user'];
			$friend = $row['friend'];
			echo 'Friend Request from ' . "<a href='request.php'>". $users . "</a>" . "<br>" . "<br>";
		}
	}
}
//for the request.php file
class ShowRequest2 extends ShowRequest {

	public function __construct($conn, $userId, $usernamer){
		parent:: __construct($conn, $userId, $usernamer);
	}

	public function show_req2($conn, $userId, $usernamer){
		$stmt = $conn->query("SELECT user, friend FROM request WHERE friendId = '$userId' and friend = '$usernamer'");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$users = $row['user'];
			$friend = $row['friend'];
			echo 'Friend Request from ' . "<a href='#'>". $users . "</a>" . "<br>" . "<br>";
		}
	}
}

class Accept {
	var $conn;
	var $userId;
	var $friendId;

	public function __construct($conn, $userId, $friendId){
		$this->conn = $conn;
		$this->userId = $userId;
		$this->friendId = $friendId;
	}
	public function accept_req($conn, $userId, $friendId){
		try {
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO friends (user_id, friend_id) VALUES ('$userId', '$friendId')";
			$conn->exec($sql);
			$sql2 = "DELETE FROM request WHERE userId = '$friendId' AND friendId = '$userId'";
			$conn->exec($sql2);
			echo 'Accepted friend request';
		}
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}
//delete request
class Delete{
	var $conn;
	var $userId;
	var $friendId;

	public function __construct($conn, $userId, $friendId){
		$this->conn = $conn;
		$this->userId = $userId;
		$this->friendId = $friendId;
	}
	public function delete_req($conn, $userId, $friendId){
		try {
			$sql = "DELETE FROM request WHERE userId = '$friendId' AND friendId = '$userId'";
			//user exec() because no results are returned
			$conn->exec($sql);
			echo "Record deleted successfully" . "<br>";
		}
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}
//displaying the friends list
class Friends {
	var $conn;
	var $userId;

	public function __construct($conn, $userId){
		$this->conn = $conn;
		$this->userId = $userId;
	}
	public function friend_list($conn, $userId){
		$stmt1 = $conn->query("SELECT * FROM friends WHERE user_id = '$userId'");
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
			$friendId = $row['friend_id'];
			$stmt = $conn->query("SELECT * FROM user WHERE id = '$friendId'");
			while($rowo = $stmt->fetch(PDO::FETCH_ASSOC)){
				$friendUser = $rowo['username'];
				echo "<a style='text-decoration: none;' href='#'>" . $friendUser . "</a>" . "<br>" . "<br>";
			}
		}
	}
	public function friend_list2($conn, $userId){
		$stmt1 = $conn->query("SELECT * FROM friends WHERE friend_id = '$userId'");
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
			$friendId = $row['user_id'];
			$stmt = $conn->query("SELECT * FROM user WHERE id = '$friendId'");
			while($rowo = $stmt->fetch(PDO::FETCH_ASSOC)){
				$friendUser = $rowo['username'];
				echo "<a style='text-decoration: none;' href='#'>" . $friendUser . "</a>" . "<br>" . "<br>";
			}
		}
	}
}
class Friends2 {
	var $conn;
	var $userId;

	public function __construct($conn, $userId){
		$this->conn = $conn;
		$this->userId = $userId;
	}
	public function friend_list($conn, $userId){
		$stmt1 = $conn->query("SELECT * FROM friends WHERE friend_id = '$userId'");
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
			$friendId = $row['user_id'];
			$stmt = $conn->query("SELECT * FROM user WHERE id = '$friendId'");
			while($rowo = $stmt->fetch(PDO::FETCH_ASSOC)){
				$friendUser = $rowo['username'];
				echo "<a href='#'>" . $friendUser . "</a>" . "<br>" . "<br>";
			}
		}
	}
}
//display all the news feed
class News {
	var $conn;
	var $Id;

	public function __construct($conn, $Id){
		$this->conn = $conn;
		$this->Id = $Id;
	}

	public function news_feed($conn, $Id){
		$stmt = $conn->query("SELECT * FROM profile WHERE user_id = '$Id' ORDER BY dates DESC");
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fstatus = $row['status'];
		$fuser = $row['username'];
		$fdate = $row['dates'];
		if(!empty($fstatus) && !empty($fuser)){
			echo strip_tags($fuser .  ' ' . $fdate . "<br>" . $fstatus . "<br>". "<br>", "<br>");
		}
	}
}

//creating the message
class Message {
	var $con;
	var $username;
	var $subject;
	var $frienduser;
	var $message;

	public function __construct($con, $username, $subject, $frienduser, $message){
		$this->con = $con;
		$this->username = $username;
		$this->subject = $subject;
		$this->frienduser = $frienduser;
		$this->message = $message;
	}
	public function send_message($con, $username, $subject, $frienduser, $message){
		try{
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$date = date("Y-m-d H:i:s");
			$sql = "INSERT INTO messages(subject, sender, receiver, dates, message) VALUES ('$subject', '$username', '$frienduser', '$date', '$message')";
			$con->exec($sql);
			echo 'message sent';
			header("Refresh:3");
		}
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}

//load the messages
class ShowMessage {
	var $conn;
	var $con;
	var $userId;

	public function __construct($conn, $con, $userId){
		$this->conn = $conn;
		$this->con = $con;
		$this->userId = $userId;
	}
	public function show_message($conn, $con, $userId){
		$stmts = $conn->query("SELECT * FROM user WHERE id = '$userId'");
		while($row = $stmts->fetch(PDO::FETCH_ASSOC)){
			$username = $row['username'];
			if(!empty($row)){
				$stmt = $con->query("SELECT * FROM messages WHERE receiver = '$username' OR sender = 'username' ORDER BY dates ASC");
				while($rowo = $stmt->fetch(PDO::FETCH_ASSOC)){
					$usernamer = strip_tags($rowo['sender']);
					$friend = strip_tags($rowo['receiver']);
					$time = strip_tags($rowo['dates']);
					$messager = strip_tags($rowo['message']);
					$subject = strip_tags($rowo['subject']);
					if($username = $usernamer){
						echo "<br>" . "<a style='text-decoration: none; color: #31c6d6;' href='read.php?r=$usernamer'>" . strip_tags($usernamer) . "</a>" . ' ' . strip_tags($time) . "<br>" . strip_tags($subject) . "<br>";
					}
				}
			}
			else{
				echo 'No messages';
			}
		}
	}
}
class Ids {
	var $conn;
	var $userId;

	public function __construct($conn, $userId){
		$this->conn = $conn;
		$this->userId = $userId;
	}
	public function get_id($conn, $userId){
		$stmt5 = $conn->query("SELECT * FROM friends WHERE friend_id = '$userId'");
		while($rowi = $stmt5->fetch(PDO::FETCH_ASSOC)){
			$friendId = $rowi['user_id'];
			echo $friendId;
		}
	}
}



//to show messages sent to you 
class Receive {
	var $conn;
	var $con;
	var $userId;
	var $friend;

	public function __construct($conn, $con, $userId, $friend){
		$this->conn = $conn;
		$this->con = $con;
		$this->userId = $userId;
		$this->friend = $friend;
	}
	public function receive($conn, $con, $userId, $friend){
		$stmts = $conn->query("SELECT * FROM user WHERE id = '$userId'");
		while($row = $stmts->fetch(PDO::FETCH_ASSOC)){
			$username = $row['username'];
		}
		$stmtr = $con->query("SELECT * FROM messages WHERE (sender = '$username' OR sender = '$friend') AND (receiver = '$friend' OR receiver = '$username') ORDER BY id DESC LIMIT 7");
		while($rows = $stmtr->fetch(PDO::FETCH_ASSOC)){
			$sender = $rows['sender'];
			$subject = $rows['subject'];
			$messages = strip_tags($rows['message']);
			$time = $rows['dates'];
			echo $sender . ' ' . $time . "<br>" . $messages . "<br>" . "<br>";
		}
	}
}
class Remove{
	var $conn;
	var $userId;
	var $friend;

	public function __construct($conn, $userId, $friend){
		$this->conn = $conn;
		$this->userId = $userId;
		$this->friend = $friend;
	}
	public function remove_friend($conn, $userId, $friend){
		try{
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM friends WHERE user_id = '$userId' AND friend_id = '$friend'";
			$conn->exec($sql);
			echo "Record deleted";
		}
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
		try{
			$sql2 = "DELETE FROM friends WHERE user_id = '$friend' AND friend_id = '$userId'";
			$conn->exec($sql2);
			echo "record deleted";
		}
		catch(PDOException $e){
			echo $sql2 . "<br>" . $d->getMessage();
		}
	}
}

?>