<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php session_start(); 
		if(isset($_SESSION['views']))
			$_SESSION['views']=$_SESSION['views']+1;
		else
			$_SESSION['views']=1;
	?>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<title> Mamma Meatballs </title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet1.css" />
	
</head>
	
<body>
<header>
<div id="topleft">
	<div id="login_section">
	<div id="templatemo_login_left">STAFF LOGIN</div>
	<?php 
	if(isset($_SESSION['SID']))
	{
		echo '<div id="templatemo_login_right">
				hello ' . $_SESSION['name'] . '! </br> Views: '. $_SESSION['views'] .' </br> acess level: '. $_SESSION['accesslv'] .'
				<form id="form1" name="form1" method="post" action="logout.php">			
					<label><input type="submit" name="logout" id="logout" value="LOG OUT" /></label>
				</form>
			</div>';
	}
	else echo '<div id="templatemo_login_right">
				<form id="form1" name="form1" method="post" action="login.php">
					Staff ID: 
					<label><input type="text" name="username" id="username" placeholder="please enter s_id" required/></label>
				
					<!--<br />Password: <label><input type="password" name="password" id="password" /></label><br />-->
				
					<label><input type="submit" name="login" id="login" value="LOGIN" /></label>
				</form>
				</div>';
	?>
	</div>
	</div>
<nav class="menu2">
  <menu>
    <li><a href="welcome.php" target="insideC">Home</a></li>
	<li><a href="#" target="insideC">Menu</a></li>
	<li><a href="#" target="insideC">Local Delivery</a></li>
	<li><a href="#" target="insideC">Find Us</a></li>
    <li><a href="#" target="insideC">About Us</a></li>
    <li><a href="#" class="selected" target="insideC">Contact Us</a></li>
  </menu>
</nav>
</div>
<div id="topright">
	<img width="90%" height="90%" src="img/welcomeALT1.jpg"/>
</div>
</header>

<iframe id="insideC" src="welcome.php">

<div id="bottom">
<footer id="footer">
<p>Copyright © xxx 2013</p>
</footer>
</div>

</body>
</html>