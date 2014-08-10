<?php 
error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("CustomQuery.php"); 
        include_once("Logger.php"); 
        include_once("SelectAllQuery.php"); 

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta charset="utf-8"/>
<title>Results</title>
<script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
</head>
<body style="margin: 50px">
    <div class="errorMessage"><?php /*echo $outputMessage*/?></div>
	
<section>	<h1>ADD SOMETHING</h1>
<div id="formContainer">
    <div class="suggestion" id="suggestions"></div>
	
<form action="<?php /*echo $_SERVER['PHP_SELF']; */?>" method="post" name="form1" id="form1">
<fieldset>
<label for="itemName">Item Name</label><input name="itemName" onkeyup="" value="<?php /*echo saveFormValue('itemName');*/?> required="true" pattern="[^|]+" type="text" /><br />
<label for="itemCode">Code</label><input name="itemCode" value="<?php /*echo saveFormValue('itemCode'); */?> required="true" pattern="[^|]+" type="text" /><br />
<label for="itemPrice">Price</label><input name="itemPrice" value="<?php /*echo saveFormValue('itemPrice'); */?> pattern="[1-9][0-9]*\.\d{2,}" title="Price should be a number and have two float digits" required="true" type="text" /><br />
<label for="itemQty">Quantity</label><input name="itemQty" value="<?php /*echo saveFormValue('itemQty'); */?> required="true" type="number" /><br />
<label for="itemAmount">Amount</label><input name="itemAmount" value="<?php /*echo saveFormValue('itemAmount'); */?> required="true" type="text" /><br />
</fieldset>
<input type="hidden" name="formInsert" value="form1" />
<input type="submit">
</form>

</div>
</section>

<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">SKU</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">type</li>
            <li></li></ul><?php 
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");
		
		//$query = new SelectAllQuery("customers");

			//$query = new CustomQuery("SELECT * from customers");
			$query = new SelectAllQuery("customers");
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
            //echo "<br>" ;
        }
        ?></div>
</section>


</body>
</html>
