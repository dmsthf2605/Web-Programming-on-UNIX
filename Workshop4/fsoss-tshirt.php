<?php
	$fnameErr = "";
    $lnameErr = "";
	$cboxErr ="";
	$radioErr="";
	$sErr="";
	$textErr = "";
    $valid = true;
 
    if($_POST){
      if(strlen($_POST['fname']) < 1){
         $fnameErr = " Please put your First name\n";
         $valid = false;  
      }      
      if(strlen($_POST['lname']) < 1){
         $lnameErr = " Please put your Last name\n";
         $valid = false;
      }	
      if(empty($_POST['multi'])){
		$cboxErr = " Please choose one";
		$valid = false;			
	  }		
	  if(empty($_POST['sex'])){
		$radioErr = " Please choose your gender";
		$valid = false;			
	  }		
	  if($_POST['size'] == "d"){
		$sErr = " Please choose your size";
		$valid = false;			
	  }	
	  if($_POST['multi'] == "Yes" && empty($_POST['mytext'])){
		$textErr = "Please put how many tshirt you like to order";
		$valid = false;			
	  }
	  // ---------- set up the error msg ------------
	}
	
	if($valid && $_POST){ 
?>
	<html>
	<body>
    <form method="POST" action="">	   
        First name: <input type="text" name="fname">
        <br/><br/>
	    Last name: <input type="text" name="lname">
	    <br/><br/>
	    Male or Female: <br/>
	    <input type="radio" name="sex" value="M"> Male
	    <input type="radio" name="sex" value="F"> Female 
	    <br/><br/>
	    Tshirt Size:<br/>
	    <select name="size">
		  <option value="d">--Please choose--</option>
		  <option value="Small">Small</option>
		  <option value="Medium">Medium</option>
		  <option value="Large">Large</option>
		  <option value="X-Large">X-Large</option>
	    </select>
		<br/><br/>
	    <label> Multiple shirts: </label>   
				<input type="checkbox" name="multi" value="Yes"> Yes
				<input type="checkbox" name="multi" value="No"> No 
		<br/><br/>
		Number to Order: <br/>
		<br/>
		<textarea name="mytext"></textarea>
	   <br/>	    
	   <input type="submit" value="Submit">
	</form>
</body>
</html>
<?php
	} else {
?>
<html>
<body>
    <form method="POST" action="">	   
        First name: <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']?>">
		<span style="color:red;"><b><?php echo $fnameErr;?></b></span>
        <br/><br/>
	    Last name: <input type="text" name="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']?>">
		<span style="color:red;"><b><?php echo $lnameErr;?></b></span>
	    <br/><br/>
	    Male or Female: <br/>
	    <input type="radio" name="sex" value="M" <?php if ($_POST['sex'] == "M") echo "CHECKED"; ?>> Male
	    <input type="radio" name="sex" value="F" <?php if ($_POST['sex'] == "F") echo "CHECKED"; ?>> Female 
		<span style="color:red;"><b><?php echo $radioErr; ?></b></span>
	    <br/><br/>
	    Tshirt Size:<br/>
	    <select name="size">
		  <option value="d">--Please choose--</option>
		  <option value="Small" <?php if ($_POST['size'] == "Small") echo "SELECTED"; ?>>Small</option>
		  <option value="Medium" <?php if ($_POST['size'] == "Medium") echo "SELECTED"; ?>>Medium</option>
		  <option value="Large" <?php if ($_POST['size'] == "Large") echo "SELECTED"; ?>>Large</option>
		  <option value="X-Large" <?php if ($_POST['size'] == "X-Large") echo "SELECTED"; ?>>X-Large</option>
	    </select>
		<span style="color:red;"><b><?php echo $sErr; ?></b></span>
		<br/><br/>
	    <label> Multiple shirts: </label>   
				<input type="checkbox" name="multi" value="Yes" <?php if ($_POST['multi'] == "Yes") echo "CHECKED"; ?>> Yes
				<input type="checkbox" name="multi" value="No" <?php if ($_POST['multi'] == "No") echo "CHECKED"; ?>> No 
				<span style="color:red;"><b><?php echo $cboxErr;?></b></span> 
		<br/><br/>
		Number to Order: <br/>
		<br/>
		<textarea name="mytext"><?php if ($_POST['mytext']) echo $_POST['mytext']; ?></textarea>
		<span style="color:red;"><b><?php echo $textErr;?></b></span>		
	   <br/>
	    
	   <input type="submit" value="Submit">
	</form>	
</body>
</html>
<?php		
	} // else{}	
	
	    // get DB server name, username, password and DB name
		$lines = file('/home/int322_163c04/apache/cgi-bin/lab4/secret');
		$dbserver = trim($lines[0]);
		$id = trim($lines[1]);
		$pwd = trim($lines[2]);
		$dbname = trim($lines[3]);
		
		// connect to the mysql server
		$cxn = mysqli_connect($dbserver, $id, $pwd, $dbname)
			   or die('Could not connect:' . mysqli_error($cxn));
			   
		if(isset($_GET['cancel'])){
			$cancel = $_GET['cancel'];
			if($cancel){
				mysqli_query($cxn,"delete from fsossregister where lastName='$cancel'");
			}			
		}		
			   
	    // SQL Query
		$firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
		$sex = $_POST['sex'];
		$size = $_POST['size'];
		$multi = $_POST['multi'];
		if($_POST['mytext'] == ""){
			$num = 1;
		} else {
			$num = $_POST['mytext'];
		}		
		
		$sql = "INSERT INTO fsossregister (firstName, lastName, sex, tshirtSize, multipleShirts, OrderNum)
		VALUES ('$firstname', '$lastname', '$sex', '$size', '$multi', '$num')";
		// print $sql;
		
		if($_POST && $valid){
			// Run sql query
			$result = mysqli_query($cxn, $sql) or die('query failed'. mysqli_error($cxn));
		}
				  
		// Get all records now in DB
		$sql = "SELECT * FROM fsossregister";		
		//Run sql query
 		$result = mysqli_query($cxn, $sql) or die('query failed'. mysqli_error($cxn));
 
		if($_POST && $valid || $_GET && $valid){
 		//iterate through result printing each record
		print "<br><br><br><b>FSOSS Tshirt Order<b/><br>";
?>
<html>
<body>
<table border="1">
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Sex</th>
		<th>Tshirt Size</th>
		<th>Multiple Shirts</th>
		<th>Number Ordered</th>
		<th>Cancel</th>
	</tr>
<?php
 	while($row = mysqli_fetch_assoc($result))
 	{
		$sum += $row['OrderNum'];
		$total = 200 - $sum;
?>
	<tr>
		<td><?php print $row['firstName']; ?></td>
		<td><?php print $row['lastName']; ?></td>
		<td><?php print $row['sex']; ?></td>
		<td><?php print $row['tshirtSize']; ?></td>
		<td><?php print $row['multipleShirts']; ?></td>
		<td><?php print $row['OrderNum']; ?></td>
		<td><a href="fsoss-tshirt.php?cancel=<?php echo $row['lastName'];?>">cancel</a></td>
	</tr>
<?php
 	} // while()
?>
</table>
The total number of tshirts : <?php echo $sum;?><br/>
<b style="color:blue;"><?php echo $total?> shirts are availavle!</b><br/>
</body>
</html>
<?php 
		// Free resultset (optional)
		mysqli_free_result($result);  
		//Close the MySQL Link
 		mysqli_close($cxn);
	}
?>

