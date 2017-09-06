<?php 
	session_start();
	//if a session is active, displays the session variable that used
	if(isset($_SESSION['username'])){ 
		print_r($_SESSION['username']);
	} else {
	// the session variable doesn't exist -> redirects to the login.php	
		header("Location:login.php");
	}
?>

<html>
<head>
	<title>INT322 lab5 - Eunsol Lee</title>
</head>
<body>
</body>
</html>
