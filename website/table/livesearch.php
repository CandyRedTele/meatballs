
<?php 
include_once("../../src/SetPath.php");
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
		// echo get_include_path();
	include_once("IncludeAllQueries.php");
	session_start();
	
if(isset($_GET["q"])){
$q=$_GET["q"];

$logger = Logger::getSingleInstace();
$logger->write("HelloLogger!");
				
if(preg_match("/employeeTable/", $_SESSION['referrer']))
	if($_SESSION['accesslv']==1||$_SESSION['accesslv']==2)
		$query = new CustomQuery("SELECT staff_id, name from staff where title like '%$q%'");
	else if($_SESSION['accesslv']==3)
		$query = new CustomQuery("SELECT staff_id, name from staff natural join (select staff_id from localstaff natural join facility where location='".$_SESSION['location']."') as localstaff;");
else if(preg_match("/supply/", $_SESSION['referrer']))
	$query = new CustomQuery("SELECT sku, name from staff where type like '%$q%'");	




				if (!is_null($query)) 
					$result = $query->execute();
				echo "<ul>";
				while($row = mysqli_fetch_row($result)) 
				{
					if($row[0]!=null && $row[0]!="")
					
					//foreach ($row as $field) {
						echo "<li><a href='".$_SESSION['referrer']."?s=$row[0]'> $row[1] </a></li>" ;   
					//}
					//echo "<li><a onclick='remC()' href='remove.php?id=". $row[0] ."-employee'>REMOVE</a></li><li><a href='#'>MODIFY</a></li></ul>";
					//var_dump($row);
					else
						echo "not found";
				}
				echo "</ul>";

}
?>