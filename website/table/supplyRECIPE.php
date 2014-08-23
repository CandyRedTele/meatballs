<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	
	session_start();
?>
<html>
<head>
	<title>RECIPES</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; charset=utf-8">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<link rel="stylesheet" href="../css/stylesheet6.css" type="text/css" />
<style>label {width:33%;}	#formContainer{width:75%;} #addSTOCK {display:none;}</style>
</head>

<body>
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->
<?php 		include_once("supplyMENU.php");		?>
<div class="haupttext" id="foodINFO">
<!--                                   Content LIST                                          -->



<p id="testing"> </p>
<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">ID</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">dishes</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">sku</li>
			<li class="button" onclick="sortTable(3, 'str', '1');" ondblclick="sortTable(3, 'str', '-1');">ingredient</li>
			<li class="button" onclick="sortTable(4, 'str', '1');" ondblclick="sortTable(4, 'str', '-1');">qtt</li>
            <li></li><li></li></ul><?php 
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");
		
		$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=\.]+/","",$_SESSION['referrer']);
		$menuID_sku;
		if(!isset($_GET['m'])){
			if($_SESSION['accesslv']==1)
				$query = new CustomQuery("select mitem_id, menuI.name, menuI.sku, supplies.name, amount from supplies inner join 
										(select * from ingredients natural join menu_item) as menuI on supplies.sku = menuI.sku;");
			else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5)
				$query = new CustomQuery("select mitem_id, menuI.name, menuI.sku, supplies.name, amount from supplies inner join 
										(select * from ingredients natural join (select * from menu_item natural join 
										(select * from menu natural join facility where location ='".$_SESSION['location']."') 
										as localMenu) as localItem) as menuI on supplies.sku = menuI.sku;");
		}
		else if(isset($_GET['m'])){
			$menuID_sku=explode(".",$_GET['m']);
			if($_SESSION['accesslv']==1)
				$query = new CustomQuery("select mitem_id, menuI.name, menuI.sku, supplies.name, amount from supplies inner join 
										(select * from ingredients natural join menu_item where mitem_id='".$menuID_sku[0]."' AND
										ingredients.sku='".$menuID_sku[1]."') as menuI on supplies.sku = menuI.sku ;");
			else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5)
				$query = new CustomQuery("select mitem_id, menuI.name, menuI.sku, supplies.name, amount from supplies inner join 
										(select * from ingredients natural join (select * from menu_item natural join 
										(select * from menu natural join facility where location ='".$_SESSION['location']."') 
										as localMenu where mitem_id='".$menuID_sku[0]."' AND ingredients.sku='".$menuID_sku[1]."')
										as localItem) as menuI on supplies.sku = menuI.sku;");
		}
		
		if (!is_null($query)) 
			$result = $query->execute();

			
        while($row = mysqli_fetch_row($result)) 
        {
			echo "<ul>";
            foreach ($row as $field) {
                echo "<li>" . $field . "</li>" ;   
            }
			if(!isset($_GET['m']))
					echo "<li><a onclick='remC()' href='remove.php?id=$row[0].$row[2]-recipe'>remove</a></li>
					<li><a href='".$_SESSION['referrer']."?m=$row[0].$row[2]'>modify</a></li></ul>";
				else
					echo "<li><a onclick='remC()' href='remove.php?id=$row[0].$row[2]-recipe'>remove</a></li>
					<li><a href='".$_SESSION['referrer']."'>modify</a></li></ul>";
        }
		
		if(isset($_GET['m'])){
			$query = new CustomQuery("SELECT * from ingredients where mitem_id='".$menuID_sku[0]."' AND ingredients.sku='".$menuID_sku[1]."';");

			$result = $query->execute();
				
			$row = mysqli_fetch_row($result);
			
			echo '</div></section>			
				<div><form action="modify.php" method="post" name="form1" id="form1">
					<fieldset>
						<label for="amount">ingredient amount</label>
							<input name="amountm" value="'.$row[2].'" placeholder="#" required="true" pattern="[0-9]+" type="text" /><br />
					</fieldset>
						<input type="hidden" name="sidm" value="'.$row[0].'.'.$row[1].'" />
						<input type="submit">
				</form></div>';
			//echo "<div>".$_SESSION['referrer']."</div>";
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