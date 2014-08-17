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
<?php 		include_once("supplyMENU.php");		?>
<div class="haupttext" id="foodINFO">
<!--                                   Content LIST                                          -->

</div>
	  </td>
        <td width="10px">&nbsp;</td>
   </tr>
</table>

<!--									END OF INFORMATION TABLE								-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>