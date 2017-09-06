<?php
	// get fields passed
	$lname = $_GET['lastName'];
	
	$lines = file('/home/int322_163c04/apache/cgi-bin/lab4/secret');
	$dbserver = trim($lines[0]);
	$id = trim($lines[1]);
	$pwd = trim($lines[2]);
	$dbname = trim($lines[3]);
		
	// connect to the mysql server
	$cxn = mysqli_connect($dbserver, $id, $pwd, $dbname)
			   or die('Could not connect:' . mysqli_error($cxn));
	$sql = "DELETE FROM fsossregister WHERE lastName='$lname'";
	$result = mysqli_query($cxn, $sql) or die('query failed'. mysqli_error($cxn));
	mysqli_close($cxn);
	header("Location: t2.php");
?>
