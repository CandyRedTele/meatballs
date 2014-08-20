<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Log Out</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet5.css" />
	<?php
		session_start();
		echo "<div id='yesF'><h3>Goodbye " .$_SESSION['name'] . "! </br> Views= ". $_SESSION['views']. "</h3></div>";
		//session_destroy();
		//session_unset();
		// session_start();
		// $_SESSION["views"]=0;
				// $_SESSION['SID']=2;
				// $_SESSION['name']=3;
				// $_SESSION['time']=time();
				// $_SESSION['phone']=4;
				// $_SESSION['title']=5;
		unset($_SESSION['view']);
		unset($_SESSION['SID']);
		unset($_SESSION['phone']);
		unset($_SESSION['name']);
		unset($_SESSION['time']);
		unset($_SESSION['title']);
		unset($_SESSION['accesslv']);
		echo "<meta http-equiv='Refresh' content='3;url=index.php'/>";
	?>
</head>
<body>

</body>
</html>