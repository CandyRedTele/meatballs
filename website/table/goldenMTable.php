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
<style>label {width:33%;}	#formContainer{width:75%;}</style>
</head>

<body>
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                         

<div class="errorMessage"><?php //echo $outputMessage?></div>

<section>	<h1>ADD NEW EMPLOYEE</h1>
<div id="formContainer">
<div class="suggestion" id="suggestions"></div>

<form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
<fieldset>
	<label for="EmployeeN">Employee Name</label>
		<input name="EmployeeN" onkeyup="" value="<?php /*echo saveFormValue('EmployeeN');*/?>" placeholder="firstName, lastname" required="true" pattern="[A-z]{2,70}" type="text" /><br />
	<label for="address">address</label>
		<input name="address" value="<?php /*echo saveFormValue('address'); */?>" placeholder="living place" required="true" pattern="[A-z0-9]{2,50}" type="text" /><br />
	<label for="phone">phone</label>
		<input name="phone" value="<?php /*echo saveFormValue('phone'); */?>" placeholder="###-###-####" required="true" pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" title="phone" required="true" type="text" /><br />
	<label for="title">title</label>
		<input name="title" value="<?php /*echo saveFormValue('title'); */?>" placeholder="ex: marketing"required="true" type="text" pattern="[A-z]{2,20}"/><br />
	<label for="ssn">ssn</label>
		<input name="ssn" value="<?php /*echo saveFormValue('ssn'); */?>" placeholder="###-###-###"required="true" type="text" pattern="[0-9]{3}\-[0-9]{3}\-[0-9]{3}"/><br />
	<label for="location">location</label>
		<input name="location" value="<?php /*echo saveFormValue('location'); */?>" placeholder="working place" type="text" pattern="[A-z0-9]{2,50}"/><br />
</fieldset>
	<input type="hidden" name="formInsert" value="form1" />
	<input type="submit">
</form>

</div>
</section> -->

<p id="testing"> </p>
<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">id</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">first name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">last name</li>
			<li class="button" onclick="sortTable(3, 'str', '1');" ondblclick="sortTable(3, 'str', '-1');">email</li>
			<li class="button" onclick="sortTable(4, 'str', '1');" ondblclick="sortTable(4, 'str', '-1');">phone</li>
			<li class="button" onclick="sortTable(5, 'str', '1');" ondblclick="sortTable(5, 'str', '-1');">sex</li>
            <li></li><li></li></ul><?php 
				$logger = Logger::getSingleInstace();

				
				$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=]+/","",$_SESSION['referrer']);
			
			if(!isset($_GET['m']))
				$query = new CustomQuery("SELECT DISTINCT g_id, firstname, lastname, email, phone, sex FROM golden");
			else if(isset($_GET['m']))	
				$query = new CustomQuery("SELECT DISTINCT g_id, firstname, lastname, email, phone, sex FROM golden where g_id='".$_GET['m']."'");
				
			if (!is_null($query)) 
					$result = $query->execute();
					
			if(isset($result))
				while($row = mysqli_fetch_row($result)) 
				{
				echo "<ul>";
				foreach ($row as $field) {
					echo "<li>" . $field . "</li>" ;   
				}
					//if(!isset($_GET['m']))
						echo "<li><a onclick='remC()' href='remove.php?id=". $row[0] ."-golden'>remove</a></li>
						<li><a href='".$_SESSION['referrer']."?m=$row[0]'>modify</a></li></ul>";
					// else
						// echo "<li><a onclick='remC()' href='remove.php?id=". $row[0] ."-golden'>remove</a></li>
						// <li><a href='".$_SESSION['referrer']."'>modify</a></li></ul>";
				}
				
			if(isset($_GET['m'])){
				$query = new CustomQuery("SELECT * from golden where g_id='".$_GET['m']."';");

				$result = $query->execute();
					
				$row = mysqli_fetch_row($result);
				
				echo '</div></section>			
					<div><form action="modify.php" method="post" name="form1" id="form1">
						<fieldset>
							<label for="firstN">First Name</label>
								<input name="namem" value="'.$row[1].'" placeholder="firstName" required="true" pattern="[A-z]{2,25}" type="text" /><br />
							<label for="address">address</label>
								<input name="emailm" value="'.$row[3].'" placeholder="email" required="true" pattern="[A-z_0-9]+@[A-z]{2,20}.[A-z]{2,4}" type="text" /><br />
							<label for="phone">phone</label>
								<input name="phonem" value="'.$row[4].'" placeholder="###-###-####" required="true" pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" title="phone" required="true" type="text" /><br />
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