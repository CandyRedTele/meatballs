<?php
error_reporting(E_ALL);
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
include_once("IncludeAllQueries.php");
$parameter = $_SERVER['QUERY_STRING'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Transfering</title>
	<style type="text/css">
	#msg {border:thin solid grey; background-color:#D6D6FF; text-align:center; width:25%; }
	</style>
<?php
$val = true;
if (empty($_POST['userName']) && empty($_POST['guestNO'])) {
    echo "<div id='msg'><h5>Some required informations is not filled!<br/>Please try again!!!<br/>
			redirecting to the reservation page in 5 seconds</h5></div>
			<meta http-equiv='Refresh' content='5; url=reservation.php?" . $parameter . "'/>";
    $val = false;
}
?>
</head>
<body>
<?php
if ($val) {

    $logger = Logger::getSingleInstace();
    $logger->write("HelloLogger!");

    $dt = $_POST['date'] . " " . $_POST['timeHour'] . ":" . $_POST['timeMins'] . ":00";

    $dtime = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $dt);

    // TODO
    // $query = new InsertIntoGoldenQuery($_POST['firstN'], $_POST['lastN'], $_POST['sex'], $_POST['email'], $_POST['phone']);

    // if (!is_null($query))
    // {
    // 	$result = $query->execute();
    // }

    echo "<div id='msg'>
	<h5>
		name" . $_POST['userName'] . "<br>
		#_seats" . $_POST['guestNO'] . "<br>
		time" . $dtime . "<br>
		event_type" . $_POST['resTYPE'] . "<br>
		f_id" . $parameter . "
	</h5>
	<h5>You have been successfully registered!<br/>!!!<br/>redirecting to the home page in 3 seconds</h5>
	</div><meta http-equiv='Refresh' content='3; url=home.php?" . $parameter . "'/>";
}
?>
</body>
</html>