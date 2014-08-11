<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet5.css" />
	
	<?php 
		error_reporting(E_ALL);
		set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("CustomQuery.php"); 
        include_once("Logger.php"); 
        include_once("SelectAllQuery.php"); 
		include_once("MeatballsUser.php"); 
		
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");

		//$query = new CustomQuery("SELECT * from staff");
		$query = new SelectAllQuery("staff");
		
		if (!is_null($query)) 
		{
			//var_dump( $query);
			$result = $query->execute();
		}
		
        while($row = mysqli_fetch_row($result)) 
        {
			if($row[0] == $_POST['username'])
			{
				session_start();
				$_SESSION["views"]=0;
				$_SESSION['SID']=$row[0];
				$_SESSION['name']=$row[1];
				$_SESSION['time']=time();
				$_SESSION['phone']=$row[4];
				$_SESSION['title']=$row[5];
				$_SESSION['accesslv']=$row[6];#or just = MeatballUser::getAccessLevel($_SESSION['SID']) is good as well
				echo "<div id='yesF'><h3>welcome back ". $_SESSION['name']."!</h3><br/>refreshing in 3 secs</div>
						<meta http-equiv='Refresh' content='3;url=index.php'/>";
			}
            //echo $_SESSION['SID'];
            //var_dump($row);
        }
		
		if(!isset($_SESSION['SID']))
			echo "<div id='notF'><h3>wrong e-mail or password<br/>please try again!</h3><br/>refreshing in 3 secs</div>
				<meta http-equiv='Refresh' content='3;url=index.php'/>";
		?>
</head>
<body>

</body>
</html>