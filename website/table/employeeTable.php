<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 

	session_start();
?>
<html>
<head>
	<title>employess information</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; CHARSET=ISO-8859-1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<style>label {width:30%;}	#formContainer{width:60%; float:left;} 
#testing{float:none; width:100%;} .locationI{text-align:left;}
#thelist{width:104%;} 
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
function remC() {
    //document.getElementById("errorMessage").innerHTML = id;
    if (confirm("Are you sure to remove?!") == true) {
        // document.write("<meta http-equiv='Refresh' content='5;url=employeeTable.php?id="+id+"-employee'/>");
    } else {
			event.preventDefault();
    }
}
</script>
</head>

<body>
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->

<div id="errorMessage" class="errorMessage"><?php echo $outputMessage?></div>

<section id="addSTUFF">	<h1>ADD NEW EMPLOYEE</h1>
<div id="formContainer">
<div class="suggestion" id="suggestions"></div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
<fieldset>
	<label for="EmployeeN">Employee Name</label>
		<input name="EmployeeN" onkeyup="" placeholder="lastname, firstName" required="true" pattern="[A-z]{2,70}" type="text" /><br />
	<label for="address">address</label>
		<input name="address" placeholder="living place" required="true" pattern="[A-z0-9]{2,50}" type="text" /><br />
	<label for="phone">phone</label>
		<input name="phone" placeholder="###-###-####" required="true" pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" title="phone" required="true" type="text" /><br />
	<label for="title">title</label>
		<input name="title" placeholder="ex: marketing"required="true" type="text" pattern="[A-z]{2,20}"/><br />
	<label for="ssn">ssn</label>
		<input name="ssn" placeholder="###-###-###"required="true" type="text" pattern="[0-9]{3}\-[0-9]{3}\-[0-9]{3}"/><br />
<!--	<label for="location" class="locationI">location</label>-->
		<select class="locationI" id="location" name="location">
	<?php	
		if($_SESSION['accesslv']==1||$_SESSION['accesslv']==2)
			$query = new CustomQuery("select distinct location, f_id from facility");
		else if($_SESSION['accesslv']==4)
			$query = new CustomQuery("select distinct location, f_id from facility where location = '".$_SESSION['location']."';");
			
		if (!is_null($query)) 
			$result = $query->execute();
			
		while($row = mysqli_fetch_row($result)) {	echo '<option value="'.$row[1].'" >'.$row[0].'</option>' ;}
		?>
			</select><br />
</fieldset>
	<input type="hidden" name="formInsert" value="form1" />
	<input type="submit">
</form>
</div>
</section>

<?php include_once("searchBOX.php"); ?>

<p id="testing"> </p>
<section><!--<h1>Administration</h1>-->
    <div id="thelist"><ul id="control">
            <li id="idC" class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">id</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">address</li>
			<li class="button" onclick="sortTable(3, 'str', '1');" ondblclick="sortTable(3, 'str', '-1');">phone</li>
			<li class="button" onclick="sortTable(4, 'str', '1');" ondblclick="sortTable(4, 'str', '-1');">SSN</li>
			<li class="button" onclick="sortTable(5, 'str', '1');" ondblclick="sortTable(5, 'str', '-1');">title</li>
			<li class="button" onclick="sortTable(6, 'str', '1');" ondblclick="sortTable(6, 'str', '-1');">salary</li>
            <li></li><li></li></ul><?php 
				$logger = Logger::getSingleInstance();
				
				$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=]+/","",$_SESSION['referrer']);
				
				
				
			if(!isset($_GET['s']) && !isset($_GET['m'])){
				if($_SESSION['accesslv']==1||$_SESSION['accesslv']==2)
					$query = new CustomQuery("SELECT * from staff");
				else if($_SESSION['accesslv']==4)
					$query = new CustomQuery("SELECT staff.staff_id, name, address, phone, ssn, title from staff natural join (select staff_id from localstaff natural join facility where location='".$_SESSION['location']."') as localstaff;");
					// echo $_SESSION['location'];
			}
			else if(isset($_GET['s'])){
				$query = new CustomQuery("SELECT * from staff where staff_id='".$_GET['s']."';");
			}else if(isset($_GET['m'])){
				$query = new CustomQuery("SELECT * from staff where staff_id='".$_GET['m']."';");
			}
					
			$result = $query->execute();
				
			while($row = mysqli_fetch_row($result)) 
			{
				echo "<ul>";
				foreach ($row as $field) {
					echo "<li>" . $field . "</li>" ;   
				}
				$salQ= new getSalaryQuery($row[0]);
				$aclvQ = new CustomQuery("select access_level from access_level where title='".$row[5]."';");
				$salR=$salQ->execute();
				$aclvR=$aclvQ->execute();
				$sal = mysqli_fetch_row($salR);
				$aclv = mysqli_fetch_row($aclvR);
				
				if($aclv[0]>0 && $aclv[0]<6)
					echo "<li>$" . $sal[2] . "/yr</li>" ; 
				else if($aclv[0]>5 && $aclv[0]<11)
					echo "<li>$" . $sal[2] . "/hr</li>" ; 
					
				// if(!isset($_GET['m']))
					echo "<li><a onclick='remC()' href='remove.php?id=". $row[0] ."-employee'>remove</a></li>
					<li><a href='".$_SESSION['referrer']."?m=$row[0]'>modify</a></li></ul>";
				// else
					// echo "<li><a onclick='remC()' href='remove.php?id=". $row[0] ."-employee'>remove</a></li>
					// <li><a href='".$_SESSION['referrer']."'>MODIFY</a></li></ul>";
			}
			
		
		if(isset($_GET['m'])){
			$query = new CustomQuery("SELECT * from staff where staff_id='".$_GET['m']."';");

			$result = $query->execute();
				
			$row = mysqli_fetch_row($result);
			
			echo '</div></section>			
				<div><form action="modify.php" method="post" name="form1" id="form1">
					<fieldset>
						<label for="EmployeeN">Employee Name</label>
							<input name="namem" value="'.$row[1].'" placeholder="firstName, lastname" required="true" pattern="[A-z]{2,22}\,\s[A-z]{2,22}" type="text" /><br />
						<label for="address">address</label>
							<input name="addressm" value="'.$row[2].'" placeholder="living place" required="true" pattern="[A-z0-9\,\-\s\.]{2,50}" type="text" /><br />
						<label for="phone">phone</label>
							<input name="phonem" value="'.$row[3].'" placeholder="###-###-####" required="true" pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" title="phone" required="true" type="text" /><br />
						<label for="title">title</label>
							<input name="titlem" value="'.$row[5].'" placeholder="ex: marketing"required="true" type="text" pattern="[A-z\s]{2,20}"/><br />
					<!--<label for="location">location</label>
							<input name="locationm" value="" placeholder="working place" type="text" pattern="[A-z0-9]{2,50}"/><br />-->
					</fieldset>
						<input type="hidden" name="sidm" value="'.$row[0].'" />
						<input type="submit">
				</form></div>';
			//echo "<div>".$_SESSION['referrer']."</div>";
			}
        ?></div>
</section>
<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>