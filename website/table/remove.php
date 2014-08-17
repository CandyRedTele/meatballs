<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Transfering</title>
	<style type="text/css">
	#msg {border:thin solid grey; background-color:#D6D6FF; text-align:center; width:25%; }
	</style>
<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
		
$val=true;
if(empty($_POST['EmployeeN'])&& empty($_POST['address'])&& empty($_POST['phone']) && empty($_POST['title']) && empty($_POST['ssn'])){
	echo "<div id='msg'><h5>Some required informations is not filled!<br/>Please try again!!!<br/>
			redirecting to the registration page in 5 seconds</h5></div>
			<meta http-equiv='Refresh' content='5; url=menu/menuHOME.php'/>"; 
	//echo .$_POST['firstN'].$_POST['lastN'].$_POST['email'].$_POST['phone'].$_POST['sex'];
	$val=false;
}
else echo "testing";
?>
</head>
<body>
<?php
if (isset($_GET['id']) && preg_match('/^\d+$/', $_GET['id'])){

	$logger = Logger::getSingleInstace();
    $logger->write("HelloLogger!");
	
	$query1 = new CustomQuery("delete from staff where staff_id='".$_GET['id']."'");
	$query2 = new CustomQuery("delete from localstaff where staff_id='".$_GET['id']."'");
	$query3 = new CustomQuery("delete from admin where staff_id='".$_GET['id']."'");
	if (!is_null($query1) && !is_null($query2) && !is_null($query3)) 
	{
		//var_dump( $query);
		$result = $query1->execute();
		$result = $query2->execute();
		$result = $query3->execute();
	}
	
	echo "<script type='text/javascript'><!--
history.go(-1);
--></script>";
	//echo .$_POST['firstN'].$_POST['lastN'].$_POST['email'].$_POST['phone'].$_POST['sex'];
}

?>

</body>
</html>