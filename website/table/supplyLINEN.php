<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	
	session_start();
?>
<html>
<head>
	<title>My Website from www.website-templates.info</title>
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
<!-- everything below is just content to fill the page -->

<table align="center" border="0" cellpadding="0" cellspacing="0" width="790" id="innerTABLE">
   <tr>
     <td width="20px">&nbsp;</td>
      <td colspan="2"><div class="ueberschrift">Put a little heading here</div></td>
      <td width="20px">&nbsp;</td>
   </tr>
   <tr>
   <td width="20px">&nbsp;</td>
      <td class="obenlinks">Text/Logo</td>
      <td class="oben" valign="top"><div id="textobengross">My beautiful new website</div><div id="textobenklein">Here you find everything you need</div></td>
      <td width="15px">&nbsp;</td>
   </tr>
   <tr> <td width="20px">&nbsp;</td>
     <td valign="top" class="links">
        <ul class="menue">
		<?php if($_SESSION['accesslv']==4)
				echo '<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>';
			else if($_SESSION['accesslv']==1 || $_SESSION['accesslv']==2)
				echo'<li><a title="Overall" href="supplyHOME">&raquo; OVERALL</a></li>
					<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>
					<li><a title="Service Item" href="supplySERVICE.php">&raquo; Service Item</a></li>
					<li><a title="Linen" href="supplyLINEN.php">&raquo; Linen</a></li>
					<li><a title="Kitchen Equipment" href="supplyKITCHEN.php">&raquo; Kitchen Equipment</a></li>';
		?>
        </ul>
      </td>
      <td class="hauptfenster" valign="top"><div class="haupttext">
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
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">type</li>
            <li></li></ul><?php 
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");
		
		//if($_SESSION['accesslv']==1)
		//if($_SESSION['accesslv']==2||$_SESSION['accesslv']==4)
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
		
	  </td>
        <td width="10px">&nbsp;</td>
   </tr>
   <!--<tr>
      <td colspan="4"><div class="ueberschrift"><a href="mailto:ihreadresse@ihremprovider.de">Mail</a> | <a href="#">Imprint</a> | <a href="#">Terms of Use</a></div></td>
   </tr>-->
</table>

<!--									END OF INFORMATION TABLE								-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>