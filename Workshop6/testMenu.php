 <html>
 <head>
	<title>INT322 lab6 - Eunsol Lee</title>
</head>
<style>
	h2{
		margin: 10px 0px 3px 10px;
	}
	ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: #f1f1f1;
    }         
    li a {
		display: block;
        color: #000;
        padding: 8px 0 8px 16px;
        text-decoration: none;
    }
    li a:hover {
        background-color: #555;
        color: white;
    }
	body{
		font-family: courier;
	}
</style>
<body>
<?php
	require_once "myClasses.php";

	$list = array('Login'  => 'http://zenit.senecac.on.ca:18542/cgi-bin/lab6/login.php',
				  'Test DB' => 'http://zenit.senecac.on.ca:18542/cgi-bin/lab6/testDB.php',
				  'Open Source' => 'https://open.senecacollege.ca/');

	$menu = new Menu($list);
	$menu->display();
?>
</body>
</html>