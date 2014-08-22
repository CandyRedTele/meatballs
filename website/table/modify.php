<?php
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
include_once("IncludeAllQueries.php");

session_start();

if (empty($_POST['addressm']) && empty($_POST['phonem']) && empty($_POST['titlem']) && empty($_POST['locationm'])) {
    echo "<div id='msg'><h5>Some required informations is not filled!<br/>Please try again!!!<br/>
			redirecting to the registration page in 5 seconds</h5></div>
			<meta http-equiv='Refresh' content='5; url=registration.php?" . $parameter . "'/>";
}
else{
	$logger = Logger::getSingleInstace();
    $logger->write("HelloLogger!");

	if(preg_match("/employeeTable/", $_SESSION['referrer'])){
		$query1 = new CustomQuery("update staff set name='".$_POST['namem']."', address ='".$_POST['addressm']."', phone='".$_POST['phonem']."', title='".$_POST['titlem']."' where staff_id='".$_POST['sidm']."'");
	}
	
		if (!is_null($query1)) {
			$result = $query1->execute();
		}
		
	// $previousP = preg_replace("/\.php$/", ".php\?[m]\=[0-9]+", $_SESSION['referrer']);
    // echo $_SESSION['referrer'];
	
	echo "<meta http-equiv='Refresh' content='55;url=".$_SESSION['referrer']."'/>";


}

?>