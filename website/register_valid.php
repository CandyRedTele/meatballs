<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Transfering</title>
	<style type="text/css">
	#msg {border:thin solid grey; background-color:#D6D6FF; text-align:center; width:25%; }
	</style>
<?php 
$val=true;
if(empty($_POST['firstN'])&& empty($_POST['lastN'])&& empty($_POST['email'] && empty($_POST['phone'])){
	echo "<div id='msg'><h5>Some required informations is not filled!<br/>Please try again!!!<br/>
			redirecting to the registration page in 5 seconds</h5></div>
			<meta http-equiv='Refresh' content='5; url=../registration_form.php'/>"; 
	$val=false;
}
else echo "testing";

?>
</head>
<body>
<?php
if($val){
	$info=array($_POST['firstN'], $_POST['lastN'], $_POST['email'], $_POST['phone']);
	
	
	
	
	echo "<div id='msg'><h5>You have been successfully registered!<br/>!!!<br/>redirecting to the home page in 5 seconds</h5></div>
	<meta http-equiv='Refresh' content='1111;
	url=../main_content.php'/>";
}

?>

</body>
</html>