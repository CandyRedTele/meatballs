<html>
<body>
<?php 
$_SESSION['referrer']   = preg_replace("/\/[\/\-\.0-9A-Za-z]*\//","",$_SERVER['REQUEST_URI']);

echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="865">
		<!--<tr>
			<td id="oben" valign="top" height="156"><div class="headertextoben"><a href="#">Mail</a> | <a href="#">Imprint</a></div><div class="headertextgross">My beautiful new website</div>
				<div class="headertextklein">Here you find everything you need to know</div></td>
		</tr>-->
		<tr>
			<td id="navi" width="865"><div class="headernavi">';
			// session_start();
			if(isset($_SESSION['SID'])){
				$personalINFO = '<a href="tableHOME.php">MY INFO</a>';
				$localResto = '<a href="localTable.php">local supply</a>';
				$employees = '<a href="employeeTable.php">employees</a>';
				$salesHist = '<a href="salesTable.php">sales history</a>';
				$goldMemb= '<a href="goldenMTable.php">gold member</a>';
				switch($_SESSION['accesslv']){
					case 1:
						echo $personalINFO . $localResto . $employees . $salesHist. $goldMemb; break;
					case 3:
						echo $personalINFO . $localResto . $employees . $salesHist; break;
					case 0:
						echo $personalINFO . $employees; break;
					case 4:
						echo $personalINFO . $localResto; break;
					default:
						echo $personalINFO;
				}
			}
		echo '</td></tr><tr><td id="mainbg" valign="top"><div id="haupttext">';
			
			
	$outputMessage = "";
	if ((isset($_POST["formInsert"])) && ($_POST["formInsert"] == "form1")) {
		
		$logger = Logger::getSingleInstace();
		$logger->write("HelloLogger!");
		
		if(preg_match("/employeeTable/", $_SESSION['referrer'])){
			$query = new InsertIntoStaffQuery($_POST['EmployeeN'], $_POST['address'], $_POST['phone'], $_POST['ssn'], $_POST['title']);
			//$query = new CustomQuery("insert into staff values ('".$_POST['EmployeeN']."', '".$_POST['address']."', '".$_POST['phone']."', '".$_POST['ssn']."', '".$_POST['title']."'");
			if (!is_null($query)) 
				$result = $query->execute();
			
			
			$query = new CustomQuery("select staff_id from staff where ssn='".$_POST['ssn']."'");
		}
		else if(preg_match("/supply/", $_SESSION['referrer'])){
			$query = new CustomQuery("insert into supplies");
			//$query = new CustomQuery("insert into staff values ('".$_POST['EmployeeN']."', '".$_POST['address']."', '".$_POST['phone']."', '".$_POST['ssn']."', '".$_POST['title']."'");
			if (!is_null($query)) 
				$result = $query->execute();
			
			
			$query = new CustomQuery("select staff_id from staff where ssn='".$_POST['ssn']."'");
		}
		else if(preg_match("/sales/", $_SESSION['referrer'])){
			$query = new CustomQuery("insert into supplies");
			//$query = new CustomQuery("insert into staff values ('".$_POST['EmployeeN']."', '".$_POST['address']."', '".$_POST['phone']."', '".$_POST['ssn']."', '".$_POST['title']."'");
			if (!is_null($query)) 
				$result = $query->execute();
			
			
			$query = new CustomQuery("select staff_id from staff where ssn='".$_POST['ssn']."'");
		}
		
		
		if (!is_null($query)) 
			$result = $query->execute();
		
		
		if(isset($result))
			if($row = mysqli_fetch_row($result))
				$outputMessage = "Data successfully saved with id:".$row[0];
			else
				$outputMessage = "Data successfully saved with id: error";
	}
		?>
</body>
</html>