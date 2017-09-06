 <html>
 <head><title>Int322 lab3</title></head>
 <body>

<?php
	$sbjCode = $_POST['scode'];
	$sbjErr = "";
	$sbjvalid = '/^\s*[A-Z]{3}[0-9]{3}[A-Z]([A-Z]([A-Z]?))?\s*$/';
	
	$tnum = $_POST['n'];
	$tnErr = "";
	$phone1 = '/^\s*[0-9]{3}((-)|( ))?[0-9]{3}((-)|( ))?[0-9]{4}\s*$/';
	$phone2 = '/^\s*\([0-9]{3}\)( )[0-9]{3}(( )|(-))[0-9]{4}\s*$/';
	
	$postalCode = $_POST['pcode'];
	$pcodeErr = "";
	$postalv = '/^\s*[a-zA-Z][0-9][a-zA-Z]( )?[0-9][a-zA-Z][0-9]\s*$/';
	$valid1 = false;
	$valid2 = false;
	$valid3 = false;

	if($_POST){
		if($sbjCode != "" && preg_match($sbjvalid, $sbjCode)){
			$valid1 = true;	
		} else {
			$sbjErr = "  Invalid Subject Code!";				
		}
		
		if($tnum != "" &&(preg_match($phone1, $tnum) | preg_match($phone2, $tnum))){
			$valid2 = true;	
		} else {
			$tnErr = "  Invalid Telephone Number!";			
		}
		
		if($postalCode != "" && preg_match($postalv, $postalCode)){
			$valid3 = true;	
		} else{			
			$pcodeErr = "  Invalid Postal Code!";					
		}
	} // set up the error msg
	
	if($_POST && $valid1 && $valid2 && $valid3){
		  echo "Valid Data:<br/>";
          echo "$sbjCode<br/>";
		  echo "$postalCode<br/>";
		  echo "$tnum<br/>";
    } else {
	?>
	<form method="POST" action="">
        Seneca Subject Code: <input type="text" name="scode" value="<?php if(isset($_POST['scode'])) echo $_POST['scode']?>"><?php echo $sbjErr;?><br>
		<br>
		Telephone Number: <input type="text" name="n" value="<?php if(isset($_POST['n'])) echo $_POST['n']?>"><?php echo $tnErr;?><br>
		<br>		
		Postal Code: <input type="text" name="pcode" value="<?php if(isset($_POST['pcode'])) echo $_POST['pcode']?>"><?php echo $pcodeErr;?><br>
        <br/>
	<input type="submit" value="Submit">
    </form>
	
	<?php
	}
	?>

 </body>
 </html>
