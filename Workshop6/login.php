<?php 
	include "myClasses.php";
	$valid = true;
	$salt = "$2a$%13$";
	
	if($_POST){ 
		$user  = $_POST['id'];
        $password = $_POST['pwd'];	
		// generate hashed passwords using crypt() function
        $hashed_pwd = crypt($password, $salt);
		
		$db = new DBLink("int322_163c04");
		$result = $db->query ("SELECT * FROM users WHERE username = '$user'");
		
		if(!$db -> emptyResult()){ // matched data
			$row = mysqli_fetch_assoc($result);
			// Use the salt and the unhashed password the user enters 
			// to generate a string to compare with the one in the DB
			if($hashed_pwd == $row['password']){
				echo "You are logged in!<br/><br/>";
?>
				<a class="a" href="login.php"> Go Back to main </a>
<?php
			} else { // invalid password
			// redisplay the login page with a error message
				$valid = false;
			}
		} else { // invalid username
			$valid = false;
		}	
	} // 	if(isset($_POST['login']))		
?>

	<html>
	<head>
		<title>INT322 lab6 - Eunsol Lee</title>
	<style>
		body {
                font-family: courier;
                padding: 30px;
        }
        div{
                width: 700px;
                border: 2px solid;
                border-radius: 8px;
                padding: 20px;
                margin: auto;
        }
		input[type=text], input[type=password]{
                box-sizing: border-box;
                border: 2px solid #ccc;
                border-radius: 4px;
                padding: 5px;
        }
		input[type=submit]{
                border: none;
                color: white;
                padding: 8px;
                cursor: pointer;
                background-color: #4CAF50;
                font-size: 90%;
                font-weight: bold;
        }
		.a {
                color:black;
                font-size: 110%;
        }
		span{
			color: red;
			font-weight: bold;
			font-size: 110%;
		}
		p{
                border-bottom:3px solid #4CAF50;
        }
	</style>
	</head>
	<body>
<?php 
	if(!$_POST || !$valid){
?>
	<form method="post" action="">
		<br/>
		<div>
			<h2><p>INT322 Lab 6: Hashing and Object-Oriented PHP </p></h2><br/>
			<b class="a">Username :</b> <input type="text" name="id"><br/>
			<br/>
			<b class="a">Password :</b> <input type="password" name="pwd"><br/>
			<br/><br/>
			<input type="submit" name="login" value="Login"/>
			<?php if(!$valid) echo "<span>Try again!</span>";?>
		</div>
	</form>
<?php 
	}
?>
</body>
</html>