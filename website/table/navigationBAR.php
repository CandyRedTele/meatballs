<html>
<body>
<?php 
echo '	<!--<tr>
			<td id="oben" valign="top" height="156"><div class="headertextoben"><a href="#">Mail</a> | <a href="#">Imprint</a></div><div class="headertextgross">My beautiful new website</div>
				<div class="headertextklein">Here you find everything you need to know</div></td>
		</tr>-->
		<tr>
			<td id="navi" width="865"><div class="headernavi">';
			// session_start();
			if(isset($_SESSION['SID'])){
				$personalINFO = '<a href="tableHOME.php">MY INFO</a>';
				// $foodSUPPLY = '<a href="#">food supply</a>';
				$localResto = '<a href="localTable.php">local restaurant</a>';
				$employees = '<a href="employeeTable.php">employees</a>';
				$salesHist = '<a href="salesTable.php">sales history</a>';
				switch($_SESSION['accesslv']){
					case 1:
						echo $personalINFO . $localResto . $employees . $salesHist; break;
					case 2:
						echo $personalINFO . $localResto . $salesHist; break;
					case 3:
						echo $personalINFO . $employees; break;
					case 4:
						echo $personalINFO . $localResto; break;
					default:
						echo $personalINFO;
				}
			}
		echo '</td></tr>';
		?>
</body>
</html>