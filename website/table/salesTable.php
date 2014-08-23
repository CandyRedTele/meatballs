<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
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
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->
<div class="errorMessage"><?php /*echo $outputMessage*/?></div>

<p id="testing"> </p>
<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
        <?php 
        $logger = Logger::getSingleInstance();
        $logger->write("HelloLogger!");
		
		$_SESSION['referrer']   = preg_replace("/\?[A-z0-9\=]+/","",$_SESSION['referrer']);
		
		if(!isset($_GET['detail'])){
			echo '<li class="button" onclick="sortTable(0, \'num\', \'1\');" ondblclick="sortTable(0, \'num\', \'-1\');">b_id</li>
            <li class="button" onclick="sortTable(1, \'str\', \'1\');" ondblclick="sortTable(1, \'str\', \'-1\');">expense</li>
			<li class="button" onclick="sortTable(2, \'str\', \'1\');" ondblclick="sortTable(2, \'str\', \'-1\');">date:time</li>
            <li></li></ul>';
		
			if($_SESSION['accesslv']==1||$_SESSION['accesslv']==2)
				$query1 = new CustomQuery("select b_id from bill");
			else if($_SESSION['accesslv']==4)
				$query1 = new CustomQuery("select b_id from bill natural join facility where location ='".$_SESSION['location']."';");
				
		}else if(isset($_GET['detail'])){
			echo '<li class="button" onclick="sortTable(0, \'num\', \'1\');" ondblclick="sortTable(0, \'num\', \'-1\');">b_id</li>
            <li class="button" onclick="sortTable(1, \'str\', \'1\');" ondblclick="sortTable(1, \'str\', \'-1\');">mitem_id</li>
			<li class="button" onclick="sortTable(2, \'str\', \'1\');" ondblclick="sortTable(2, \'str\', \'-1\');">dishes</li>
			<li class="button" onclick="sortTable(2, \'str\', \'1\');" ondblclick="sortTable(2, \'str\', \'-1\');">category</li>
            <li>Total</li></ul>';
			$query1 = new getBillDetailsQuery($_GET['detail']);
		}
		
		if (!is_null($query1)) 
					$bills = $query1->execute();
					
		 while($b_id = mysqli_fetch_row($bills)) 
        {
            if (isset($_GET['detail'])) {
			    $query2 = new getBillTotalQuery($_GET['detail']);
            } else {
			    $query2 = new getBillTotalQuery($b_id[0]);
            }
			$expense = $query2->execute();
			$ex = mysqli_fetch_row($expense);
			
			if(!isset($_GET['detail'])){
				echo "<ul><li>" . $ex[0] . "</li>
							<li>$" . $ex[2] . "</li>
							<li>" . $ex[1] . "</li>
					<li><a href='".$_SESSION['referrer']."?detail=".$ex[0]."'>details</a></li></ul>" ;
			}
			else if(isset($_GET['detail'])){
				echo "<ul><li>" . $_GET['detail'] . "</li>
							<li>" . $b_id[0] . "</li>
							<li>$" . $b_id[1] . "</li>
							<li>" . $b_id[2] . "</li>
							<li> item price </li></ul>";
			}
        }
		echo "<ul><li></li><li></li><li></li><li></li><li>$ex[2]</li></ul>";
        ?></div>
</section>
<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>
