<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>main content</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet2.css"/>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
	
<?php
session_start();
?>
</head>
<body>
<div id="centercontent">
<div id="centerH">
<h1 id="centerM">0000000</h1>
<a href="registration.php" target="insideC" id="centerRight">Golden Member registration</a>
</div>
<div id="marquee">
<marquee>Welcome to The SITE!</marquee>
</div>
<?php
/*if(isset($_SESSION['UID']) && file_exists("php/member.txt")){
	$temp=file("php/member.txt");
	echo "<ul class='userP'>";
	foreach($temp as $val){
		$c=explode(",",$val); $f=$c[0]*100; $mF=$c[0]*10;
		echo "<li id='user1'><form class='invB' action='php/event.php' method='post'><input type='hidden' class='dd' name='info' value='$c[5], $f, $mF'/><input type='submit' value='invite to event' name='eventIN'/></form>
					<div class='profile'>
						<img src='img/USA.jpg'/>$c[1] $c[2]
						<span class='numF'>$f friends<br/>$mF mutual friends</span>
						<form action=''><input type='button' value='add friend'/></form></div>
						<a href='http://en.wikipedia.org/wiki/Barack_Obama'><img src='img/".$c[6]."'/></a>
						<p class='dialogue'><span>header</span><br/><br/>newsfeed</p>
				</li>";
	}
}*/
?>
<article>
<p>contents</p>
<p>contents</p>
<p>contents</p>
</article>
</div>
</body>
</html>