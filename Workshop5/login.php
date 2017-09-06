<?php 
	$match = true;
	// get DB server name, username, password and DB name
    $lines = file('/home/int322_163c04/secret/topsecret');
    $dbserver = trim($lines[0]);
    $id       = trim($lines[1]);
    $pwd      = trim($lines[2]);
    $dbname   = trim($lines[3]);
	
	if(isset($_POST['login'])){ // when user put id and password
        // connect to the mysql server
        $cxn = mysqli_connect($dbserver, $id, $pwd, $dbname)
               or die('Could not connect:' . mysqli_error($cxn));
			   
		$id  = $_POST['id'];
		$pwd = $_POST['pwd'];
		
		$sql = "SELECT * FROM users WHERE username = '$id' AND password = '$pwd'";
		$result = mysqli_query($cxn, $sql) or die('query failed'. mysqli_error($cxn));
		
		// if the username and password match one set, 
		// then login the user and display the 'protectedstuff.php' page
		// otherwise, reprint the login form with error message
		if(mysqli_num_rows($result) > 0){ // matched data
			// set a session variable
			session_start();
			$_SESSION['username'] = $id;
			header("Location:protectedstuff.php");
		} else {
			$match = false;
		}
		mysqli_free_result($result);
		mysqli_close($cxn);
	} // 	if(isset($_POST['login']))	

	if(isset($_POST['forgotid'])){ // when user submit email address
		$cxn = mysqli_connect($dbserver, $id, $pwd, $dbname)
               or die('Could not connect:' . mysqli_error($cxn));
		$email = $_POST['email'];
		$sql = "SELECT * FROM users WHERE username = '$email'";	   
		$result = mysqli_query($cxn, $sql) or die('query failed'. mysqli_error($cxn));

		if(mysqli_num_rows($result) > 0){ // matched data
			// sends an email to her with the username & password hint
			// then return to the login page
			while($row = mysqli_fetch_assoc($result)){
				$email = $row['username'];
				$subject = "Password Hint Requested";
				$comment = "Your Username is " .$row['username']. " and the Password hint is " .$row['passwordHint'];
				// include these so that the server won't mark it as spam
				$headers = "From: int322_163c04@zenit.seneac.on.ca" ."\r\n".
						   "Reply-To: int322_163c04@zenit.seneac.on.ca" ."\r\n";
				// send email
				mail($email, $subject, $comment, $headers);
			} // while()
		} // if(mysqli_num_rows($result) > 0)
		
		header("Location:login.php");
		mysqli_free_result($result);
		mysqli_close($cxn);		
	} // if(isset($_POST['forgotid']))
?>
	
	<html>
	<head>
		<title>INT322 lab5 - Eunsol Lee</title>
	</head>
	<body>
<?php
	if($_GET){ // when user forgot the password
?>	
		<form method="post" action="">
			<br/>
			<b>Email address :</b> <input type="text" name="email"><br/>
			<br/><br/>
			<input type="submit" name ="forgotid" value="Submit"/>
		</form>
<?php		
	} else { // display the form when no sumbit or invalid data
?>
		<form method="post" action="">
			<br/>
			<b>Username :</b> <input type="text" name="id"><br/>
			<br/>
			<b>Password :</b> <input type="password" name="pwd"><br/>
			<br/>
			<b style="color:red;"><?php if(!$match) echo "Invalid username or password<br/>";?></b>
			<br/>
			<input type="submit" name="login" value="Login"/>
			<a href="login.php?forgot"><b>   Forgot your password?</b></a>
		</form>
<?php
	}
?>	
	</body>
	</html>

