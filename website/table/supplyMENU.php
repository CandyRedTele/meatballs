<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
?>

<html>
<head>
<style>
label {width:33%;
		display: inline-block;
		float: left;
		clear: left;
		text-align: right;}	
				
#formContainer{width:75%;}

input, select {	float:left;}
</style>
</head>
<body>
<?php 

echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="790" id="innerTABLE">
   <tr>
     <td width="20px">&nbsp;</td>
      <td colspan="2"><div class="ueberschrift">supplies</div></td>
      <td width="20px">&nbsp;</td>
   </tr>
   <tr>
   <td width="20px">&nbsp;</td>
      <td class="obenlinks"><img width="100%" height="100%"src="../img/supply_logo.jpg"/></td>
      <td class="oben" valign="top"><div id="textobengross">'.$_SESSION['location'].'</div><div id="textobenklein">Here you find everything you need</div></td>
      <td width="15px">&nbsp;</td>
   </tr>
   <tr> <td width="20px">&nbsp;</td>
     <td valign="top" class="links">
        <ul class="menue">';
			if($_SESSION['accesslv']==5)
				echo '<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>
					<li><a title="recipes" href="supplyRECIPE.php">&raquo; Recipee</a></li>';
			else if($_SESSION['accesslv']==1 ||$_SESSION['accesslv']==4)
				echo'<li><a title="Overall" href="localTable.php">&raquo; OVERALL</a></li>
					<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>
					<li><a title="Service Item" href="supplySERVICE.php">&raquo; Service Item</a></li>
					<li><a title="Linen" href="supplyLINEN.php">&raquo; Linen</a></li>
					<li><a title="Kitchen Equipment" href="supplyKITCHEN.php">&raquo; Kitchen Equipment</a></li>
					<li><a title="recipes" href="supplyRECIPE.php">&raquo; Recipee</a></li>';
					
		if($_SESSION['accesslv']==1||$_SESSION['accesslv']==3)
			$query1 = new CustomQuery("select distinct location, f_id from facility;");
		else if($_SESSION['accesslv']==4 || $_SESSION['accesslv']==5)
			$query1 = new CustomQuery("select distinct location, f_id from facility where location = '".$_SESSION['location']."';");
			
		$result1 = $query1->execute();
			
		while($row1 = mysqli_fetch_row($result1)) 
		{	
			echo '<option value="'.$row1[0].'" >'.$row1[0].'</option>' ;
		}
	?>
	</ul>
		</td>
		<td class="hauptfenster" valign="top">
		<!--                                   supply LIST                                          -->
			<div class="errorMessage"><?php echo $outputMessage; ?><!--$outmsg2--></div>
		
			<section id="addSTOCK">	<h1>ADD STOCK</h1>
			<div id="formContainer">
				<div class="suggestion" id="suggestions"></div>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
			<fieldset>
				<label for="sku">SKU</label>
					<input name="sku" value="" required="true" pattern="[0-9]+" type="text" /><br />
			<!--<label for="name">Item Name</label>
					<input name="name" onkeyup="" value="" required="true" pattern="[a-Z]+" type="text" /><br />
				<label for="price">Price</label>
					<input name="price" value="" pattern="[1-9][0-9]*\.\d{2,}" required="true" type="text" /><br />-->
				<label for="type">type</label>
					<select name="type" required="true"> 
						<option value="food" >food</option>
						<option value="service items" >service items</option>
						<option value="linens" >linens</option>
						<option value="kitchen equipment" >kitchen equipment</option>
					</select>	<br />
				<label for="quantity">Quantity</label>
					<input name="quantity" value="" pattern="[0-9]+" required="true" type="number" /><br />
				<label for="location">Location</label>
					<select class="location" id="location" name="location"> ';
	<?php	
		$query = new CustomQuery("select distinct location, f_id from facility");
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
		
		
</body>
</html>