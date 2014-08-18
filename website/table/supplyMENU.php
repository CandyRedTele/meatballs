<html>
<body>
<?php 

echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="790" id="innerTABLE">
   <tr>
     <td width="20px">&nbsp;</td>
      <td colspan="2"><div class="ueberschrift">'.$_SESSION['location'].'</div></td>
      <td width="20px">&nbsp;</td>
   </tr>
   <tr>
   <td width="20px">&nbsp;</td>
      <td class="obenlinks"><img width="100%" height="100%"src="../img/supply_logo.jpg"/></td>
      <td class="oben" valign="top"><div id="textobengross">My beautiful new website</div><div id="textobenklein">Here you find everything you need</div></td>
      <td width="15px">&nbsp;</td>
   </tr>
   <tr> <td width="20px">&nbsp;</td>
     <td valign="top" class="links">
        <ul class="menue">';
			if($_SESSION['accesslv']==4)
				echo '<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>
					<li><a title="recipes" href="supplyRECIPE.php">&raquo; Recipee</a></li>';
			else if($_SESSION['accesslv']==1 || $_SESSION['accesslv']==3)
				echo'<li><a title="Overall" href="localTable.php">&raquo; OVERALL</a></li>
					<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>
					<li><a title="Service Item" href="supplySERVICE.php">&raquo; Service Item</a></li>
					<li><a title="Linen" href="supplyLINEN.php">&raquo; Linen</a></li>
					<li><a title="Kitchen Equipment" href="supplyKITCHEN.php">&raquo; Kitchen Equipment</a></li>
					<li><a title="recipes" href="supplyRECIPE.php">&raquo; Recipee</a></li>';
	echo '</ul>
		</td>
	<td class="hauptfenster" valign="top">
	
	
	
	';
	
	
	
		?>
<div class="errorMessage">$outputMessage</div>
	
<section>	<h1>ADD SOMETHING</h1>
<div id="formContainer">
	<div class="suggestion" id="suggestions"></div>

<form action="$_SERVER['PHP_SELF'];" method="post" name="form1" id="form1">
<fieldset>
	<label for="sku">SKU</label>
		<input name="sku" value="" required="true" pattern="[0-9]+" type="text" /><br />
	<label for="itemName">Item Name</label>
		<input name="itemName" onkeyup="" value="" required="true" pattern="[a-Z]+" type="text" /><br />
	<label for="itemPrice">Price</label>
		<input name="itemPrice" value="" pattern="[1-9][0-9]*\.\d{2,}" title="Price should be a number and have two float digits" required="true" type="text" /><br />
	<label for="itemQty">Quantity</label>
		<input name="itemQty" value="" pattern="[0-9]+" required="true" type="number" /><br />
	<label for="itemAmount">Amount</label>
		<input name="itemAmount" value="" required="true" type="text" /><br />
</fieldset>
	<input type="hidden" name="formInsert" value="form1" />
	<input type="submit">
</form>

</div>
</section>
</body>
</html>