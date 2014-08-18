<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 

	session_start();

?>
<html>
<head>
	<title>employess information</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; CHARSET=ISO-8859-1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<style>label {width:33%;}	#formContainer{width:75%;}</style>
</head>

<body>
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->

<div class="errorMessage"><?php echo $outputMessage?></div>

<section>	<h1>ADD NEW EMPLOYEE</h1>
<div id="formContainer">
<div class="suggestion" id="suggestions"></div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
<fieldset>
	<label for="EmployeeN">Employee Name</label>
		<input name="EmployeeN" onkeyup="" value="<?php /*echo saveFormValue('EmployeeN');*/?>" placeholder="firstName, lastname" required="true" pattern="[A-z]{2,70}" type="text" /><br />
	<label for="address">address</label>
		<input name="address" value="<?php /*echo saveFormValue('address'); */?>" placeholder="living place" required="true" pattern="[A-z0-9]{2,50}" type="text" /><br />
	<label for="phone">phone</label>
		<input name="phone" value="<?php /*echo saveFormValue('phone'); */?>" placeholder="###-###-####" required="true" pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" title="phone" required="true" type="text" /><br />
	<label for="title">title</label>
		<input name="title" value="<?php /*echo saveFormValue('title'); */?>" placeholder="ex: marketing"required="true" type="text" pattern="[A-z]{2,20}"/><br />
	<label for="ssn">ssn</label>
		<input name="ssn" value="<?php /*echo saveFormValue('ssn'); */?>" placeholder="###-###-###"required="true" type="text" pattern="[0-9]{3}\-[0-9]{3}\-[0-9]{3}"/><br />
	<label for="location">location</label>
		<input name="location" value="<?php /*echo saveFormValue('location'); */?>" placeholder="working place" type="text" pattern="[A-z0-9]{2,50}"/><br />
</fieldset>
	<input type="hidden" name="formInsert" value="form1" />
	<input type="submit">
</form>

</div>
</section>

<p id="testing"> </p>
<section><h1>Administration</h1>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">id</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">first name</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">last name</li>
			<li class="button" onclick="sortTable(3, 'str', '1');" ondblclick="sortTable(3, 'str', '-1');">email</li>
			<li class="button" onclick="sortTable(4, 'str', '1');" ondblclick="sortTable(4, 'str', '-1');">phone</li>
			<li class="button" onclick="sortTable(5, 'str', '1');" ondblclick="sortTable(5, 'str', '-1');">sex</li>
            <li></li></ul><?php 
				$logger = Logger::getSingleInstace();
				$logger->write("HelloLogger!");
				
				// if($_SESSION['accesslv']==1)
					// $query = new CustomQuery("SELECT * from staff");
				// else if($_SESSION['accesslv']==3)
					// $query = new CustomQuery("SELECT * from staff natural join (select staff_id from localstaff natural join facility where location='".$_SESSION['location']."') as localstaff;");
				
				$query = new CustomQuery("SELECT DISTINCT g_id, firstname, lastname, email, phone, sex FROM golden");
				if (!is_null($query)) 
				{
					//var_dump( $query);
					$result = $query->execute();
				}
				
			if(isset($result))
				while($row = mysqli_fetch_row($result)) 
				{
					echo "<ul>";
					foreach ($row as $field) {
						echo "<li>" . $field . "</li>" ;   
					}
					echo "<li><a href='#'>REMOVE</a></li></ul>";
					//echo $row['customerName'];
					//var_dump($row);
				}
		
        ?></div>
</section>
<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>