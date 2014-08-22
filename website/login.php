<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet5.css" />
	
	<?php 
		error_reporting(E_ALL);
         include_once("../src/SetPath.php");
        set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
		//echo get_include_path();
			include_once("IncludeAllQueries.php");
		
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");
		
		$query = new CustomQuery("select * from staff where staff_id='".$_POST['username']."'");
		//$query = new SelectAllQuery("staff");
		if (!is_null($query)) 
			$result = $query->execute();
		

		if(isset($result)) {
			$row = mysqli_fetch_row($result);
			
			if($row[0]!=null && $row[0]!=""){	
				session_start();
				$_SESSION["views"]=0;
				$_SESSION['SID']=$row[0];
				$_SESSION['name']=$row[1];
				$_SESSION['time']=time();
				$_SESSION['phone']=$row[3];
				$_SESSION['ssn']=$row[4];
				$_SESSION['title']=$row[5];
				
				$logger = Logger::getSingleInstace();
				$logger->write("HelloLogger!");

				$query = new GetAccessLevelQuery($_SESSION['SID']);
				if (!is_null($query)) 
					$result = $query->execute();
				
				$row=mysqli_fetch_row($result);
				$_SESSION['accesslv']=$row[0];#or just = MeatballUser::getAccessLevel($_SESSION['SID']) is good as well
				
				 
				$query = new GetLocationQuery($_SESSION['SID']);//CustomQuery('SELECT location from facility, localstaff where staff_id="'.$_SESSION["SID"].'" AND facility.f_id=localstaff.f_id');
				if (!is_null($query)) 
					$result = $query->execute();
				
				$row=mysqli_fetch_row($result);
				
				$_SESSION['location']=$row[0];
				echo "<div id='yesF'><h3>welcome back ". $_SESSION['name']."!</h3><br/>refreshing in 3 secs</div>
						<meta http-equiv='Refresh' content='3;url=table/tableHOME.php'/>";
			}
		}

		
		if(!isset($_SESSION['SID']))
			echo "<div id='notF'><h3>wrong ID<br/>please try again!</h3><br/>refreshing in 3 secs</div>
				<meta http-equiv='Refresh' content='3;url=index.php'/>";
		?>
</head>
<body>

</body>
</html>
