<?php
$priceErr = "";
$productErr = "";
$qDate = "";
$valid = true;

if($_POST){ 
	// Validation
	// When the client did not select the model
	if($_POST['model'] == "default"){
		$productErr = "Please Choose the model\n";
		$valid = false;
	}
	
	// regular expression for the matching
	$pattern = "/^\d+\.\d{1,2}$/";
	
	// When the price fields are empty
	if(empty($_POST['min']) || empty($_POST['max'])){
		$priceErr = "Please Enter the number\n";
		$valid = false;
	} else if(!preg_match($pattern, $_POST['min']) || !preg_match($pattern, $_POST['max'])){
		// when the price fields are not decimal numbers
		$priceErr = "Price must be decimal numbers\n";
		$valid = false;
	} else if($_POST['min'] >= $_POST['max']){
		// when the minimum price is bigger than maximum price
		$priceErr = "Maximum price must be bigger than Minimum price\n";
		$valid = false;
	}
}
?>

<!-- if the user put invalid data, display the form with the error and repopulate the value -->
<html>
<head>
	<title> INT322 Assignment1 - Eunsol Lee </title>
<style>
	.a {
		color:black;
		font-size: 120%;
	}
	b {
		color:red;
	}
	body {
		font-family: courier;
		padding: 30px;
	}
	div{
		width: 600px;
		border: 2px solid;
		border-radius: 8px;
		padding: 20px;
		margin: auto;
	}
	p{
		border-bottom:3px solid #4CAF50;
	}
	select {
		padding: 5px;
		border: none;
		border-radius: 4px;
		background-color: #f1f1f1;
	}
	input[type=text]{
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
	<form method="post" action="">
		<div>
		<h1><p>CellPhones Comparision Tool</p></h1><br/>
			<b class="a">Model</b>
			<select name="model">
				<option value="default">--Please Choose--</option>
				<option value="Samsung" <?php if($_POST['model'] == "Samsung") echo "SELECTED" ?>>Samsung</option>
				<option value="Apple" <?php if($_POST['model'] == "Apple") echo "SELECTED" ?>>Apple</option>
				<option value="LG" <?php if($_POST['model'] == "LG") echo "SELECTED" ?>>LG</option>
			</select>
			<b><?php echo $productErr; ?></b><br/><br/>
		<b class="a">Price</b>
		<input type="text" name="min" size ="5" value="<?php if($_POST['min']) echo $_POST['min'] ?>"/> ~ 
		<input type="text" name="max" size ="5" value="<?php if($_POST['max']) echo $_POST['max'] ?>"/>
		<b><?php echo $priceErr;?></b>
		<br/><br/><br/>		
		<input type="submit" name="submit" value="Search"/>
		</div>
	</form>

<?php	
// Connect to the database only when the data is valid
if($valid){
	// get DB server name, username, password and DB name
	$lines = file('/home/int322_163c04/secret/topsecret');
	$dbserver = trim($lines[0]);
	$id       = trim($lines[1]);
	$pwd      = trim($lines[2]);
	$dbname   = trim($lines[3]);
		
	// connect to the mysql server
	$cxn = mysqli_connect($dbserver, $id, $pwd, $dbname)
	       or die('Could not connect:' . mysqli_error($cxn));
			   
	if(!$_POST){ // When the page is loaded
		// check whether the table is exist or not
		$sql = "SHOW TABLES LIKE 'cellPhones'";
		$table = mysqli_query($cxn, $sql) or die ("Query Failed" .mysqli_error($cxn));

		// if the table is not exist, create the table called 'cellPhones'
		// otherwise ignore it
		if($table->num_rows == 1){
			
		} else {	
			$sql = "CREATE TABLE cellPhones (
					id int zerofill not null auto_increment,
					itemName varchar(40) not null, 
					model varchar(20) not null, 
					os varchar(10) not null,
					price decimal(10,2) not null,
					primary key (id)
					)";
			$result = mysqli_query($cxn, $sql) or die ("Query Failed" .mysqli_error($cxn));		
		} 
		
		// check whether the table is empty or not
		$sql = "SELECT * FROM cellPhones";
		$result = mysqli_query($cxn, $sql) or die ("Query Failed" .mysqli_error($cxn));		
		
		// If table is empty, insert the data from files
		if(mysqli_num_rows($result) == 0){ 		
			// Extract whole datas from files
			$cellphone = file('cellphone.txt');
			$model     = file('model.txt');
			$os        = file('os.txt');
			$price     = file('price.txt');
			
			// Extract 6 items line by line, using trim()
			for($i = 0; $i < 6; $i++){
				$cellphone[$i] = trim($cellphone[$i]);
				$model[$i]     = trim($model[$i]);
				$os[$i]        = trim($os[$i]);
				$price[$i]     = trim($price[$i]);				
				
				// Insert the data into database
				$sql = "INSERT INTO cellPhones (itemName, model, os, price) 
						VALUES ('$cellphone[$i]', '$model[$i]', '$os[$i]', '$price[$i]')";
				$result = mysqli_query($cxn, $sql) or die ("Query Failed" .mysqli_error($cxn));
			}
		} // if(mysqli_num_rows($result) == 0)	
			
	} else { // when the client press submit button
		$min   = $_POST['min'];
		$max   = $_POST['max'];
		$model = $_POST['model'];
		
		// diplay the information of the selected model and the date the query was made
		$sql = "SELECT itemName, model, os, price, now() AS 'qDate' FROM cellPhones 
				WHERE (price BETWEEN '$min' AND '$max') AND model = '$model'		
				ORDER BY price";
		$search = mysqli_query($cxn, $sql) or die ("Query Failed" .mysqli_error($cxn));
		
		// display the data when it is exist
		if(mysqli_num_rows($search) > 0 ){ 
?>		
	<div>
		<table>
		<tr>
			<th>No.</th>
			<th>Cellphone</th>
			<th>MOdel</th>
			<th>OS</th>
			<th>Price</th>
		</tr>
<?php
			$n = 1;
			while($row = mysqli_fetch_assoc($search)){
				$qDate = $row['qDate'];
?>				
				<tr>
                    <td><?php print $n++; ?></td>
					<td><?php print $row['itemName']; ?></td>
                    <td><?php print $row['model']; ?></td>
                    <td><?php print $row['os']; ?></td>
                    <td><?php print $row['price']; ?></td>
                </tr>
<?php
			} // while()	
		} else { // when there are no datas 
			echo "<div><b>NO RESULTS FOUNDED</b></div>";	
		}
?>
		</table><br/>
		<!-- display the date the query was made-->
		<?php echo $qDate ?>
	</div>
<?php
	}
	mysqli_close($cxn);
} // if($valid)
?>

</body>
</html>

