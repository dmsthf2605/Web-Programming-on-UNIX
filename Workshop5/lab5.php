<?php
	// When the user presses Submit, store the name/value in a cookie for that browser
	if($_POST['cname'] && $_POST['cvalue']){
		$name  = $_POST['cname'];
		$value =  $_POST['cvalue'];
		setcookie($name, $value);
	}
	
	// Store the number of visits in the cookie
	if(isset($_COOKIE['count'])){
		setcookie('count', ++$_COOKIE['count']);
		echo "welcome back - you visted this page " .$_COOKIE['count']. " times";
	} else { // the first time 
		setcookie('count', 1);
		echo "Welcome back - you visited this page " .$_COOKIE['count']. " times";
	}

	
?>
<html>
<head>
	<title>INT322 lab5 - Eunsol Lee</title>
</head>
<body>
	<form method="post" action=""> 
		<br/><br/>
		<b>Cookie name </b><input type="text" name="cname" value=""/>
		<br><br>
		<b>Cookie value </b><input type="text" name="cvalue" value=""/>
		<br><br><br>
		<input type="submit" value="Submit"/>
	</form>

	<h3>Stored cookies</h3>
	<?php
		// displays all cookies stored in the list
		foreach($_COOKIE as $name=>$value){
			echo "<li> Name: " . $name . " Value: " . $value . "</li>";
		}
	?>
</body>
</html>
