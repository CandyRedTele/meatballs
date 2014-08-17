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
					<li><a title="Food" href="supplyRECIPEE.php">&raquo; Recipee</a></li>';
			else if($_SESSION['accesslv']==1 || $_SESSION['accesslv']==3)
				echo'<li><a title="Overall" href="localTable.php">&raquo; OVERALL</a></li>
					<li><a title="Food" href="supplyFOOD.php">&raquo; Food</a></li>
					<li><a title="Service Item" href="supplySERVICE.php">&raquo; Service Item</a></li>
					<li><a title="Linen" href="supplyLINEN.php">&raquo; Linen</a></li>
					<li><a title="Kitchen Equipment" href="supplyKITCHEN.php">&raquo; Kitchen Equipment</a></li>
					<li><a title="Food" href="supplyRECIPEE.php">&raquo; Recipee</a></li>';
	echo '</ul>
		</td>
	<td class="hauptfenster" valign="top">';
		?>
</body>
</html>