<html>
<head><title>Fsoss-Register</title></head>
 <body>
    <h1>Fsoss-Register</h1>
    <?php
      $nameErr = "";
      $pwdErr = "";
      $dataValid = true;

      // when the form is submitted
      if($_POST){
	if( strlen($_POST['name']) < 1 ){
	  $nameErr = "  Error - YOU MUST FILL IN A  NAME";
          $dataValid = false;
	}
	if( strlen($_POST['pwd']) < 1 ){
               $pwdErr = "  Error - YOU MUST FILL IN A PASSWORD";
              $dataValid = false;
        }
      } // if($POST)
      // both fields were entered

      if($_POST && $dataValid){
      ?>

	<form method="post" action="">
	Name : <input type="text" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"><br/>
	<br/>
	Password : <input type="password" name="pwd" value="<?php if (isset($_POST['pwd'])) echo $_POST['pwd'];?>"><br/>
	<br/>
	<input type="submit">
	</form>

     <?php
        $Name = $_POST['name'];
	$Password = $_POST['pwd'];
	echo "NAME : $Name";
	echo "\n";
	echo "PASSWORD : $Password";

     // No submit or data invalid 
      } else {
    ?> 
	<form method="post" action="">
	Name : <input type="text" name="name"><?php echo $nameErr;?><br/>
	<br/>
	Password : <input type="password" name="pwd"><?php echo $pwdErr;?><br />
	<br/>
	<input type="submit">
	</form>
     
     <?php 
     }
     ?>

 </body>
 </html>
