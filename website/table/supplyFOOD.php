<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	
	session_start();
?>
<html>
<head>
	<title>FOOD SUPPLY</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; charset=utf-8">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<link rel="stylesheet" href="../css/stylesheet6.css" type="text/css" />
</head>

<body>
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->
<?php 		include_once("supplyMENU.php");		?>
<div class="haupttext" id="foodINFO">
<!--                                   MENU LIST                                          -->

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
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">price</li>
            <li></li></ul><?php 
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");
		
		//if($_SESSION['accesslv']==1)
		//if($_SESSION['accesslv']==2||$_SESSION['accesslv']==4)
			$query = new CustomQuery("SELECT sku, name, price from supplies where type='food'");
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
			echo "<li><a href='#'>REMOVE</a></li></ul>";
            //echo $row['customerName'];
            //var_dump($row);
        }
		
        ?></div>
</section>
</div>
	  </td>
        <td width="10px">&nbsp;</td>
   </tr>
</table>

<!--									END OF INFORMATION TABLE								-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>