<?php 
error_reporting(E_ALL &~E_NOTICE);
session_start();
session_destroy();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Logout Page</title>
</head>
<body>

<a href="Login.php">Click here to log back in</a>

</body>
</html>