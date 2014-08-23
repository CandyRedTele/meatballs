<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	
	session_start();
?>
<html>
<head>
	<title>My Website from www.website-templates.info</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; CHARSET=ISO-8859-1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
</head>

<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="865">
    <!--<tr>
      <td id="oben" valign="top" height="156"><div class="headertextoben"><a href="#">Mail</a> | <a href="#">Imprint</a></div><div class="headertextgross">My beautiful new website</div>
      <div class="headertextklein">Here you find everything you need to know</div></td>
    </tr>-->
    <tr>
      <td id="navi" width="865"><div class="headernavi">
		<?php if(isset($_SESSION['SID'])){
				$personalINFO = '<a href="tableHOME.html">MY INFO</a>';
				//$foodSUPPLY = '<a href="#">food supply</a>';
				$localResto = '<a href="#">local restaurant</a>';
				$employees = '<a href="table1.php">employees</a>';
				$salesHist = '<a href="#.html">sales history</a>';
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
		?></td>
    </tr>
    <tr>
      <td id="mainbg" valign="top"><div id="haupttext">
<!--                                   INFORMATION TABLES                                          -->

        <div class="errorMessage"><?php /*echo $outputMessage*/?></div>
	
<section>	<h1>ADD SOMETHING</h1>
<div id="formContainer">
	<div class="suggestion" id="suggestions"></div>

<form action="<?php /*echo $_SERVER['PHP_SELF']; */?>" method="post" name="form1" id="form1">
<fieldset>
	<label for="itemName">Item Name</label>
		<input name="itemName" onkeyup="" value="<?php /*echo saveFormValue('itemName');*/?>" required="true" pattern="[^|]+" type="text" /><br />
	<label for="itemCode">Code</label>
		<input name="itemCode" value="<?php /*echo saveFormValue('itemCode'); */?>" required="true" pattern="[^|]+" type="text" /><br />
	<label for="itemPrice">Price</label>
		<input name="itemPrice" value="<?php /*echo saveFormValue('itemPrice'); */?>" pattern="[1-9][0-9]*\.\d{2,}" title="Price should be a number and have two float digits" required="true" type="text" /><br />
	<label for="itemQty">Quantity</label>
		<input name="itemQty" value="<?php /*echo saveFormValue('itemQty'); */?>" required="true" type="number" /><br />
	<label for="itemAmount">Amount</label>
		<input name="itemAmount" value="<?php /*echo saveFormValue('itemAmount'); */?>" required="true" type="text" /><br />
</fieldset>
	<input type="hidden" name="formInsert" value="form1" />
	<input type="submit">
</form>

</div>
</section>

<p id="testing"> </p>
<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">SKU</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">type</li>
            <li></li></ul><?php 
        $logger = Logger::getSingleInstance();
        $logger->write("HelloLogger!");
		
			$query = new CustomQuery("SELECT * from customers");
			//$query = new SelectAllQuery("customers");
			if (!is_null($query)) 
			{
				//var_dump( $query);
				$result = $query->execute();
			}
			
        while($row = mysqli_fetch_row($result)) 
        {
			echo "<ul>";
            foreach ($row as $field) {
                echo "<li>" . $field . "</li>" ;   
            }
			echo "</ul>";
            //echo $row['customerName'];
            //var_dump($row);
        }
        ?></div>
</section>
</div></td>
    </tr>
    <tr>
      <td id="unten" height="74">Your Website URL</td>
    </tr>
</table>
<!--Start: This code may not be removed or altered in the free of charge version!--> <div class="copyright" align="center"><a style="color:#8F8F8F;font-weight:normal;background-color:#DCDCDC" href="http://www.website-templates.info" target="_blank">Free Templates</a></div><!--End: This code may not be removed or altered in the free of charge version!-->

</body>
</html>