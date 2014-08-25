<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 

	session_start();
?>
<html>
<head>
	<title>Orders to Vendors</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; CHARSET=ISO-8859-1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<style>label {width:30%;}	#formContainer{width:60%; float:left;} #testing{float:none; width:100%;} .locationI, .vendorN{text-align:left;}</style>
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
<!--	<label for="oID">Order ID</label>
		<input name="oID" onkeyup="" value="" placeholder="Order ID" required="true" pattern="[0-9]+" type="text" /><br />
<!--	<label for="location" class="locationI">location</label>-->
		<select class="locationI" id="location" name="location">
	<?php	
		if($_SESSION['accesslv']==1||$_SESSION['accesslv']==3)
			$query1 = new CustomQuery("select distinct location, f_id from facility;");
		else if($_SESSION['accesslv']==4 || $_SESSION['accesslv']==5)
			$query1 = new CustomQuery("select distinct location, f_id from facility where location = '".$_SESSION['location']."';");
		
		$result1 = $query1->execute();
			
		while($row1 = mysqli_fetch_row($result1)) {	echo '<option value="'.$row1[1].'" >'.$row1[0].'</option>' ;}
		?>
			</select><br />
	<label for="sku">SKU</label>
		<input name="sku" value="" placeholder="supplies SKU" required="true" pattern="[0-9]+" title="phone" required="true" type="text" /><br />
<!--<label for="date">date</label>
		<input name="date" value="<?php //echo date("Y-m-d");?>" placeholder="ex: 2014-08-25"required="true" type="text" pattern="[201][4-9]\-([8-9]|[10-12])\-[0-9]"/><br />-->
	<label for="quantity">quantity</label>
		<input name="quantity" value="" placeholder="number"required="true" type="text" pattern="[0-9]+"/><br />
<!--	<label for="vendor" class="vendorN">vendor</label>
		<select class="vendorN" id="vendorN" name="vendorN">
	<?php
		// if($_SESSION['accesslv']==1||$_SESSION['accesslv']==3)
			// $query2 = new CustomQuery("select distinct company_name, vendor.vendor_id from vendor natural join 
										// (select * from catalog natural join `order`) as cat;");
		// else if($_SESSION['accesslv']==4 || $_SESSION['accesslv']==5){
			// $fIDQ=new CustomQuery("select f_id from facility where location = '".$_SESSION['location']."';");
			// $fIDR = $fIDQ->execute();
			// $fID = mysqli_fetch_row($fIDR);
			// $query2 = new CustomQuery("select company_name, vendor_id from vendor natural join (select distinct vendor_id
										// from catalog natural join `order` natural join supplies where f_id = '".$fID[0]."'
										// order by `order`.f_id) as id;");
		// }
		// $result2 = $query2->execute();
			
		// while($row2 = mysqli_fetch_row($result2)) {	echo '<option value="'.$row2[1].'" >'.$row2[0].'</option>';}
		?>
			</select><br />-->
</fieldset>
	<input type="hidden" name="formInsert" value="form1" />
	<input type="submit">
</form>
</div>
</section>

<?php 
	if($_SESSION['accesslv']==1||$_SESSION['accesslv']==3)
		include_once("searchBOX.php"); 
?>

<p id="testing"> </p>
<section><!--<h1>Administration</h1>-->
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">id</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">location</li>
			<li class="button" onclick="sortTable(2, 'num', '1');" ondblclick="sortTable(2, 'num', '-1');">sku</li>
			<li class="button" onclick="sortTable(4, 'num', '1');" ondblclick="sortTable(4, 'num', '-1');">order_qtt</li>
			<li class="button" onclick="sortTable(5, 'num', '1');" ondblclick="sortTable(5, 'num', '-1');">days-expire</li>
            <li class="button" onclick="sortTable(6, 'str', '1');" ondblclick="sortTable(6, 'str', '-1');">EXP_date</li>
			<!--	<li class="button" onclick="sortTable(7, 'str', '1');" ondblclick="sortTable(7, 'str', '-1');">capacity</li>-->
			<li></li></ul><?php 
				$logger = Logger::getSingleInstance();
				
				$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=]+/","",$_SESSION['referrer']);
			
				if($_SESSION['accesslv']==1||$_SESSION['accesslv']==3){
					if(!isset($_GET['s']))
						$query = new CustomQuery("SELECT order_id, location, sku, order_qty, days_till_expired, "
												 . " DATE_ADD(order_date, INTERVAL days_till_expired DAY) as EXP_DATE FROM (select * "
												 . " from food natural join (select * from `order` natural join facilityStock) as stock )  as supplies "
												 . " natural join (select f_id, location from facility) as fac "
												 . " HAVING EXP_DATE < (DATE_ADD(CURRENT_DATE(), INTERVAL 10 DAY)) ORDER BY EXP_DATE;");
					else if(isset($_GET['s'])){
						$query = new CustomQuery("SELECT order_id, location, sku, order_qty, days_till_expired, "
												. "DATE_ADD(order_date, INTERVAL days_till_expired DAY) as EXP_DATE FROM (select * from food natural join "
												. "(select * from `order` natural join facilityStock where `order`.f_id ='".$_GET['s']."') as stock )  "
												. "as supplies natural join (select f_id, location from facility) as fac "
												. " HAVING EXP_DATE < (DATE_ADD(CURRENT_DATE(), INTERVAL 10 DAY)) ORDER BY EXP_DATE;");
					}
				}
				else if($_SESSION['accesslv']==4 || $_SESSION['accesslv']==5){
					$fIDQ = new CustomQuery("select f_id from facility where location = '".$_SESSION['location']."';");
					$fIDR = $fIDQ->execute();
					$fID = mysqli_fetch_row($fIDR);
					$query = new CustomQuery("SELECT order_id, location, sku, order_qty, days_till_expired, 
										DATE_ADD(order_date, INTERVAL days_till_expired DAY) as EXP_DATE
										FROM food natural join ( select * from `order` natural join 
										(select sku, f_id, location, quantity from facilityStock natural join facility WHERE facilityStock.f_id = '".$fID[0]."') 
										as fac) as o GROUP BY sku HAVING EXP_DATE < (DATE_ADD(CURRENT_DATE(), INTERVAL 10 DAY))ORDER BY EXP_DATE;");
				}
				// else if( $_SESSION['accesslv']==5)
					// $query = new CustomQuery("SELECT order_id, location, sku, order_qty, days_till_expired, 
										// DATE_ADD(order_date, INTERVAL days_till_expired DAY) as EXP_DATE
										// FROM food natural join ( select * from `order` natural join 
										// (select sku, f_id, location, quantity from facilityStock natural join facility WHERE facilityStock.f_id = '".$fID[0]."') 
										// as fac) as o GROUP BY sku HAVING EXP_DATE < (DATE_ADD(CURRENT_DATE(), INTERVAL 10 DAY))ORDER BY EXP_DATE;;");
				
				$result = $query->execute();

				
				while($row = mysqli_fetch_row($result)) 
				{
					echo "<ul>";
					foreach ($row as $field) {
						echo "<li>" . $field . "</li>" ;   
					}
					
					echo "<li><a onclick='remC()' href='remove.php?id=". $row[0] ."-employee'>remove</a></li></ul>";
				}
		
        ?></div>
</section>
<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>
