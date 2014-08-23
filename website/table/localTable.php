<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	
	session_start();
?>
<html>
<head>
	<title>OVERALL</title>
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
<?php 		include_once("supplyMENU.php");			
			if($_SESSION['accesslv']==1)
				include_once("searchBOX.php"); ?>
				
<p id="testing"> </p>
<section><!--<h1>Administration</h1>-->
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">SKU</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">location</li>
			<li class="button" onclick="sortTable(3, 'str', '1');" ondblclick="sortTable(3, 'str', '-1');">quantity</li>
			<li class="button" onclick="sortTable(4, 'str', '1');" ondblclick="sortTable(4, 'str', '-1');">price</li>
            <li></li></ul><?php 
<<<<<<< HEAD
        $logger = Logger::getSingleInstace();

=======
        $logger = Logger::getSingleInstance();
        $logger->write("HelloLogger!");
>>>>>>> cdf686ded792b9c78ee02ee3fd33dd681714d6a6
		
		$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=]+/","",$_SESSION['referrer']);
		
		if(!isset($_GET['s']))
			if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==3)
				$query = new CustomQuery("SELECT sku, name, location, quantity, price from supplies natural join (select * from facilityStock natural join facility) as stock");
			else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5)
				$query = new CustomQuery("SELECT sku, name, location, quantity, price from supplies NATURAL JOIN (select * from facilityStock NATURAL JOIN facility) as stock where location='".$_SESSION['location']."'");
		if(isset($_GET['s']))
			$query = new CustomQuery("SELECT sku, name, location, quantity, price from supplies natural join (select * from facilityStock natural join facility) as stock where sku='".$_GET['s']."'");

			
		if (!is_null($query)) 
			$result = $query->execute();
		
		
		if(isset($result))
			while($row = mysqli_fetch_row($result)) 
			{
				echo "<ul>";
				foreach ($row as $field) {
					echo "<li>" . $field . "</li>" ;   
				}
				echo "<li><a href='remove.php?id=".$row[0]."-supply'>remove</a></li></ul>";
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
