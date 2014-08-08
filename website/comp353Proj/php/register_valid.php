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
if(empty($_POST['firstN'])&& empty($_POST['lastN'])&& empty($_POST['pswd'])&& empty($_POST['repswd'])&& empty($_POST['email'])){
	echo "<div id='msg'><h5>Some required informations is not filled!<br/>Please try again!!!<br/>redirecting to the registration page in 5 seconds</h5></div>
	<meta http-equiv='Refresh' content='55;
	url=../registration.php'/>"; $val=false;}
else if(!preg_match("/^[A-z0-9]{8,}$/",$_POST['pswd'])  && ($_POST['pswd'] == $_POST['repswd'])){
	echo "<div id='msg'><h5>The passwords are different!<br/>Please enter again!!!</h5></div><br/>redirecting to the registration page in 5 seconds</h5></div>
	<meta http-equiv='Refresh' content='55;
	url=../registration.php'/>"; $val=false;}
else echo "testing";

?>
</head>
<body>
<?php
if($val){
	$info=array($_POST['firstN'], $_POST['lastN'], $_POST['pswd'], $_POST['repswd'], $_POST['email']);
	$txt="member.txt";
	$temp=fopen($txt,"a");
	$count = count(file($txt))+1;
	fwrite($temp,"$count,");
	foreach($info as $x => $y)
		fwrite($temp,"$info[$x],");
		
	if(is_uploaded_file($_FILES['file']['tmp_name'])){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp1 = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp1);
		if ((($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 100000)&& in_array($extension, $allowedExts)){
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				else{ $fName;
					if (file_exists("../img/" . $_FILES["file"]["name"])){
						move_uploaded_file($_FILES["file"]["tmp_name"],"../img/" .$count.$_FILES["file"]["name"]);
						$fName=$count.$_FILES['file']['name'];
						fwrite($temp,"$fName,");
					}
					else{
						move_uploaded_file($_FILES["file"]["tmp_name"],"../img/" . $_FILES["file"]["name"]);
						$fName=$_FILES['file']['name'];
						fwrite($temp,"$fName,");
					}
					echo "You have also upload your profile picture: <img src='../img/".$fName."' width='50' height='50'/>";
				}
			}
		else { echo "Invalid file"; }
	}else fwrite($temp,"default_profile.jpg,");
	
	fwrite($temp,"0\n");
	fclose($temp);
	echo "<div id='msg'><h5>You have been successfully registered!<br/>!!!<br/>redirecting to the home page in 5 seconds</h5></div>
	<meta http-equiv='Refresh' content='5; url=../welcome.php'/>";
}

?>

</body>
</html>