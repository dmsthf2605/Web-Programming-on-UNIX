<?php
	session_start();
	if(isset($_GET['logout'])){
		// if session exist, delete the session
		session_unset();
		session_destroy();			
		// render the cookie inactive -> set the expiry time
		setcookie("PHPSESSID", "", time() - 61200, "/");		
		// after the setup time return the user to the login page
		header("Location:login.php");			
	}
	
	/* prompts for a login the first time a user goes to this page.
	   the next time the user goes to this page, it should not prompt for a login,
	   but should only display the page*/
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	} else {
		echo "<br/><b>You are logged in!</b><br/><br/>";	
?>

<html>
<head>
	<title>INT322 lab5 - Eunsol Lee</title>
</head>
<body>
	<form method="post" action="">
		<a href="protectedstuff.php?logout=true">Logout</a>
	</form>
</body>
</html>
<?php
	}
?>
