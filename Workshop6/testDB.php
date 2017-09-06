<?php
	include "myClasses.php";
	$Err  = "";
	$uErr = "";
	$salt 	  = "$2a$%13$";
	$valid = true;
	
	$db = new DBLink("int322_163c04");
	$pv = new InputValidator($_POST);	
	
	if($pv -> exists('submit')) { // is the value 'submit' set in the $_POST array?
		$pv -> hasValue('id', 'You must enter an username');
		$pv -> hasValue('pwd', 'You must enter a password');
		$pv -> hasValue('pwdHint', 'You must enter a password hint');
		$pv -> hasValue('roll', 'You must enter a roll');
				
		if($pv -> render()) {
			$user     = $_POST['id'];
			$password = crypt($_POST['pwd'], $salt);
			$pwdHint  = $_POST['pwdHint'];
			$role     = $_POST['roll'];
			
			$result = $db -> query("SELECT * FROM users WHERE username = '$user'");
			if ($db->emptyResult()){ // INSERT
				$result = $db->query("INSERT INTO users (username, password, role, passwordHint) 
									  VALUES('$user', '$password', '$role', '$pwdHint')");	
			} else if(!$db->emptyResult()) { //UPDATE
					$result = $db->query("UPDATE users 
										  SET password = '$password', role = '$role', passwordHint = '$pwdHint'
										  WHERE username = '$user'");
			} 
			
			// display the table
			$result = $db -> query("SELECT * FROM users");
			if(!$db -> emptyResult()){
?>

<div>
	<h2><p> Users </p></h2><br/>
	<table>
	<tr>
		<th>Username</th>
		<th>Password</th>
		<th>Role</th>
		<th>Password Hint</th>
	</tr>
<?php
				while($row = mysqli_fetch_assoc($result)){
?>
					<tr>
						<td><?php print $row['username']; ?></td>
						<td><?php print $row['password']; ?></td>
						<td><?php print $row['role']; ?></td>
						<td><?php print $row['passwordHint']; ?></td>
					</tr>
<?php
				} //while()
			} //if()
?>
		</table><br/>
		<br/><br/><a href="testDB.php">Go back</a>
</div>
<?php			
		} else {	
				$valid = false;
				$uErr = $pv -> getErr();					
		}
	} // if($pv)	
	
	if($_POST['select']){
		$id = $_POST['sid'];
		$result = $db -> query("SELECT * FROM users WHERE username = '$id'");
		if(!$db -> emptyResult()){
			while($row = mysqli_fetch_assoc($result)){
				echo "<div>";
				echo "<h2><p>User Information</p></h2>";
				echo "<b class='a'>Username: </b>" .$row['username']. "<br/><br/>"; 
				echo "<b class='a'>Role: </b>" .$row['role']. "<br/><br/>"; 
				echo "<b class='a'>Password Hint: </b>" .$row['passwordHint']. "<br/><br/>"; 
?>
				<br/><br/><a href="testDB.php">Go back</a>
				</div>
<?php
			}
		} else {
			$valid = false;
			$Err = "NO DATA FOUNDED!";				
		}
	} // if(select)
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
	table{
		border-collapse: collapse;
		width: 100%;
	}	
	tr:nth-child(even){
		background-color: #f2f2f2
	}
	th{
		background-color: #4CAF50;
		color: white;
		height: 50px;
		padding: 5px;
	}	
	td{
		padding: 5px;
	}
	</style>
</head>
<body>
<?php
	if(!$_POST || !$valid){
?>
	<!-- SELECT -->
	<form method="post" action="">
		<br/>
		<div>
			<h2><p> SELECT </p></h2><br/>
			<b class="a">Username :</b> <input type="text" name="sid"><br/>
			<br/><br/>
			<input type="submit" name="select" value="Select"/>
			<span><?php if(!$valid) echo $Err;?></span>
		</div>
	</form>
	<!-- INSERT / UPDATE -->
	<form method="post" action="">
		<br/>
		<div>
			<h2><p> INSERT / UPDATE </p></h2><br/>
			<b class="a">Username :</b> <input type="text" name="id" value="<?php if($_POST['id']) echo $_POST['id'];?>"><br/>
			<br/>
			<b class="a">Password :</b> <input type="password" name="pwd" value="<?php if($_POST['pwd']) echo $_POST['pwd'];?>"><br/>
			<br/>
			<b class="a">Password Hint :</b> <input type="text" name="pwdHint" value="<?php if($_POST['pwdHint']) echo $_POST['pwdHint'];?>"><br/>
			<br/>
			<b class="a">Role :</b> <input type="text" name="roll" value="<?php if($_POST['roll']) echo $_POST['roll'];?>"><br/>
			<br/><br/>
			<input type="submit" name="submit" value="Insert"/>
			<span><?php if(!$valid) echo $uErr;?></span>
		</div>
	</form>
<?php
	}
?>
</body>
</html>






