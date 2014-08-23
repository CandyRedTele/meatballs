<?php
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
include_once("IncludeAllQueries.php");

session_start();

	$logger = Logger::getSingleInstace();

	
	if(preg_match("/employeeTable/", $_SESSION['referrer'])){
		$query1 = new CustomQuery("update staff set name='".$_POST['namem']."', address ='".$_POST['addressm']."', phone='".$_POST['phonem']."', title='".$_POST['titlem']."' where staff_id='".$_POST['sidm']."'");
	}
	else if(preg_match("/RECIPE/", $_SESSION['referrer'])){
		$menuID_sku=explode(".",$_POST['sidm']);
		$query1 = new CustomQuery("update ingredients set amount='".$_POST['amountm']."' where mitem_id='".$menuID_sku[0]."' AND sku='".$menuID_sku[1]."';");
	}
	else if(preg_match("/golden/", $_SESSION['referrer'])){
		$query1 = new CustomQuery("update golden set firstname='".$_POST['namem']."', email ='".$_POST['emailm']."', phone='".$_POST['phonem']."' where g_id='".$_POST['sidm']."'");
	}
	
	$result = $query1->execute();

		
	// $previousP = preg_replace("/\.php$/", ".php\?[m]\=[0-9]+", $_SESSION['referrer']);
    // echo $_SESSION['referrer'];
	
	echo "<meta http-equiv='Refresh' content='0;url=".$_SESSION['referrer']."'/>";




?>