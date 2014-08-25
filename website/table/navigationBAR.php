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
				$localResto = '<a href="localTable.php">supplies</a>';
				$employees = '<a href="employeeTable.php">employees</a>';
				$salesHist = '<a href="salesTable.php">sales history</a>';
				$goldMemb= '<a href="goldenMTable.php">gold member</a>';
				$vendorO= '<a href="vendorO.php">order</a>';
                $billP='<a href="billTable.php">bill</a>';
                $faB='<a href="facilityTable.php">facility info</a>';
				switch($_SESSION['accesslv']){
					case 1:
						echo $personalINFO . $localResto . $employees . $salesHist. $goldMemb. $vendorO. $faB; break;
					case 2:
						echo $personalINFO . $employees. $goldMemb; break;
					case 3:
						echo $personalINFO . $localResto . $salesHist. $vendorO. $faB; break;
					case 4:
						echo $personalINFO . $localResto . $employees . $salesHist. $vendorO. $faB; break;
					case 5:
						echo $personalINFO . $localResto; break;
					case 6:
						echo $personalINFO . $billP; break;
					case 7:
						echo $personalINFO . $billP; break;
					case 10:
						echo $personalINFO; break;
					default:
						echo $personalINFO;
				}
			}
		echo '</td></tr><tr><td id="mainbg" valign="top"><div id="haupttext">';


	$outputMessage = ""; $outmsg2="";
	if ((isset($_POST["formInsert"])) && ($_POST["formInsert"] == "form1")) {

		$logger = Logger::getSingleInstance();
		$logger->write("HelloLogger!");

		if(preg_match("/employeeTable/", $_SESSION['referrer'])){
			$query = new InsertIntoStaffQuery($_POST['EmployeeN'], $_POST['address'], $_POST['phone'], $_POST['ssn'], $_POST['title'], $_POST['location']);
			//$query = new CustomQuery("insert into staff values ('".$_POST['EmployeeN']."', '".$_POST['address']."', '".$_POST['phone']."', '".$_POST['ssn']."', '".$_POST['title']."'");

			$result = $query->execute();


			$query = new CustomQuery("select staff_id from staff where ssn='".$_POST['ssn']."'");
		}
		else if(preg_match("/supply/", $_SESSION['referrer'])|| preg_match("/local/", $_SESSION['referrer'])){
			$query = new CustomQuery("select quantity from facilityStock where sku='".$_POST['sku']."' AND f_id='".$_POST['location']."'");
			
			$result = $query->execute();
			

			$currentQ = mysqli_fetch_row($result);
			$newQ = $currentQ[0] + $_POST['quantity'];
			
			//$outmsg2 = $newQ."=".$currentQ[0]."+".$_POST['quantity']." at ".$_POST['location'];
			$outmsg2 = "the new quantity of supply(sku:".$_POST['sku'].") was added from $currentQ[0] to $newQ";
			$query = new CustomQuery("update facilityStock set quantity='".$newQ."' where sku='".$_POST['sku']."' AND f_id='".$_POST['location']."'");
			if (!is_null($query)) 
				$result = $query->execute();

			$query = new CustomQuery("select location from facility where f_id='".$_POST['location']."'");
		}
		else if(preg_match("/vendorO/", $_SESSION['referrer'])){
			$query = new CustomQuery("INSERT  INTO `order` (f_id, sku, order_qty) " . " VALUES 
									(" . $_POST['location'] . ", " . $_POST['sku'] . ", " . $_POST['quantity'] . ");");
			$result = $query->execute();

			
			$query = new CustomQuery("select vendor_id from facilityStock natural join catalog where sku='".$_POST['sku']."' AND f_id='".$_POST['location']."'");
			$result = $query->execute();
			$vID = mysqli_fetch_row($result);
			
			$query = new CustomQuery("select location from facility where f_id='".$_POST['location']."'");
			$result = $query->execute();
			$facN = mysqli_fetch_row($result);
			
			$query = new CustomQuery("select company_name from vendor where vendor_id='".$vID[0]."'");
		}


		if (!is_null($query)) 
			$result = $query->execute();

		if(isset($result))
			if($row = mysqli_fetch_row($result)){
				if(preg_match("/employeeTable/", $_SESSION['referrer']))
					$outputMessage = "staff successfully saved with id:".$row[0];
				else if(preg_match("/supply/", $_SESSION['referrer']))
					$outputMessage = "supply successfully updated with id(".$_POST['sku'].") at ".$row[0]."'s restaurant";
				else if(preg_match("/vendorO/", $_SESSION['referrer']))
					$outputMessage = "order successfully requested to vendor ".$row[0]." for restaurant at ".$facN[0]."!";
			}
	}
		?>
</body>
</html>
