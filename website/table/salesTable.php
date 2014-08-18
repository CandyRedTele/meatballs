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
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->
<div class="errorMessage"><?php /*echo $outputMessage*/?></div>

<p id="testing"> </p>
<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">SKU</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">type</li>
            <li></li></ul><?php 
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");
		
		$query = new CustomQuery("select b_id from bill");
		if (!is_null($query)) 
			$bills = $query->execute();

		
		 while($b_id = mysqli_fetch_row($bills)) 
        {

            foreach ($b_id as $id) {
			
                $query = new GetBillDetailsQuery($id);
				
				if (!is_null($query)) 
					$result = $query->execute();
					
				while($row = mysqli_fetch_row($result)) 
				{
					echo "<ul>";
					foreach ($row as $field) {
					echo "<li>" . $field . "</li>" ;   
				}
				echo "</ul>";

				}
            }

        }
		
		$query = new GetBillDetailsQuery();
		if (!is_null($query)) 
		{
			//echo var_dump( $query);
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
<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>
