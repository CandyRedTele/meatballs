<?php 
	error_reporting(E_ALL);
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
<style>label {width:30%;}	#formContainer{width:60%; float:left;} #testing{float:none; width:100%;}</style>
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

<section>	<h1>Make Order to Vendor?</h1>
<div id="formContainer">
<div class="suggestion" id="suggestions"></div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
<fieldset>
	<label for="EmployeeN">b_id</label>
		<input name="EmployeeN" onkeyup="" value="<?php /*echo saveFormValue('EmployeeN');*/?>" placeholder="firstName, lastname" required="true" pattern="[A-z]{2,70}" type="text" /><br />
	<!--<label for="address">location</label>-->
		<select class="location" id="location" name="location">
	<?php	
		$query1 = new CustomQuery("select distinct location, f_id from facility");
 
		$result1 = $query1->execute();
			
		while($row1 = mysqli_fetch_row($result1)) {	echo '<option value="'.$row1[1].'" >'.$row1[0].'</option>' ;}
		?>
			</select><br />
	<label for="phone">sku</label>
		<input name="phone" value="<?php /*echo saveFormValue('phone'); */?>" placeholder="###-###-####" required="true" pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" title="phone" required="true" type="text" /><br />
	<label for="title">date</label>
		<input name="title" value="<?php /*echo saveFormValue('title'); */?>" placeholder="ex: marketing"required="true" type="text" pattern="[A-z]{2,20}"/><br />
	<label for="ssn">quantity</label>
		<input name="ssn" value="<?php /*echo saveFormValue('ssn'); */?>" placeholder="###-###-###"required="true" type="text" pattern="[0-9]{3}\-[0-9]{3}\-[0-9]{3}"/><br />
	<label for="location">vendor</label>
		<select class="location" id="location" name="location">
	<?php	
		$query2 = new CustomQuery("select distinct company_name, vendor_id from facility");

		$result2 = $query2->execute();
			
		while($row2 = mysqli_fetch_row($result2)) {	echo '<option value="'.$row2[1].'" >'.$row2[0].'</option>' ;}
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
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">id</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">location</li>
			<li class="button" onclick="sortTable(2, 'num', '1');" ondblclick="sortTable(2, 'num', '-1');">sku</li>
			<li class="button" onclick="sortTable(3, 'str', '1');" ondblclick="sortTable(3, 'str', '-1');">date</li>
			<li class="button" onclick="sortTable(4, 'num', '1');" ondblclick="sortTable(4, 'num', '-1');">qtt</li>
			<li class="button" onclick="sortTable(5, 'str', '1');" ondblclick="sortTable(5, 'str', '-1');">vendor</li>
            <li></li><li></li></ul><?php 
				$logger = Logger::getSingleInstance();
				$logger->write("HelloLogger!");
				
				$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=]+/","",$_SESSION['referrer']);
				
				if($_SESSION['accesslv']==1||$_SESSION['accesslv']==3)
					$query = new CustomQuery("SELECT order_id, location, sku, order_date, order_qty from `order` natural join 
												(select f_id, location from facility) as fac;");
				else if($_SESSION['accesslv']==4)
					$query = new CustomQuery("SELECT order_id, location, sku, order_date, order_qty from `order` natural join 
											(select f_id, location from facility where location = '".$_SESSION['location']."') as fac;");
				else if($_SESSION['accesslv']==5)
					$query = new CustomQuery("SELECT order_id, location, sku, order_date, order_qty from 
											(select * from `order` natural join supplies where type = 'food') natural join 
											(select f_id, location from facility where location = '".$_SESSION['location']."') as fac;");
				
				if (!is_null($query)) {
					$result = $query->execute();
				}
				
				while($row = mysqli_fetch_row($result)) 
				{
					echo "<ul>";
					foreach ($row as $field) {
						echo "<li>" . $field . "</li>" ;   
					}
					echo "<li></li><li><a onclick='remC()' href='remove.php?id=". $row[0] ."-employee'>remove</a></li></ul>";
				}
		
        ?></div>
</section>
<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>
