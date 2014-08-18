
<?php
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	session_start();

if (isset($_GET['id'])){
	$logger = Logger::getSingleInstace();
    $logger->write("HelloLogger!");
	
	$tableN=explode("-",$_GET['id']);
	
	if($tableN[1]=="employee"){
		$query1 = new CustomQuery("delete from staff where staff_id='".$tableN[0]."'");
		$query2 = new CustomQuery("delete from localstaff where staff_id='".$tableN[0]."'");
		$query3 = new CustomQuery("delete from admin where staff_id='".$tableN[0]."'");
		
		if (!is_null($query1) && !is_null($query2) && !is_null($query3)) 
		{
			$result1 = $query1->execute();
			$result2 = $query2->execute();
			$result3 = $query3->execute();
		}
		//echo "<meta http-equiv='Refresh' content='0;url=employeeTable.php?id=".$tableN[0]'/>";
		
	}else if($tableN[1]=="supply"){
		$query1 = new CustomQuery("delete from supplies where sku='".$tableN[0]."'");
		$query2 = new CustomQuery("delete from facilitystock where sku='".$tableN[0]."'");
		
		if (!is_null($query1) && !is_null($query2)) 
		{
			$result1 = $query1->execute();
			$result2 = $query2->execute();
		}
		//echo "<meta http-equiv='Refresh' content='0;url=Table.php?id=".$tableN[0]'/>";
	}

	
	$previousP = preg_replace("/\.php$/", ".php?=".$tableN[0]."", $_SESSION['referrer']);
	//echo $previousP;
	
	echo "<meta http-equiv='Refresh' content='0;url=".$previousP."'/>";
	
	
	// function getPageURL() {
    // $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    // if ($_SERVER["SERVER_PORT"] != "80") {
        // $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    // } else {
        // $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    // }
	// echo $pageURL;
    // return preg_replace("/\w+\.\w{2,3}.*/","",$pageURL);
	// }
	// echo getPageURL();
	
	
	//echo "<script type='text/javascript'>history.go(-1);</script>";
}
?>