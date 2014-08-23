
<?php 
include_once("../../src/SetPath.php");
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
		// echo get_include_path();
	include_once("IncludeAllQueries.php");
	session_start();
	
if(isset($_GET["q"])){
$q=$_GET["q"];

$logger = Logger::getSingleInstance();
$logger->write("HelloLogger!");
				
if(preg_match("/employeeTable/", $_SESSION['referrer'])){
	if($_SESSION['accesslv']==1||$_SESSION['accesslv']==2)
		$query = new CustomQuery("SELECT staff_id, name from staff where title like '%$q%'");
	else if($_SESSION['accesslv']==4)
		$query = new CustomQuery("SELECT staff.staff_id, name from staff natural join (select staff_id from localstaff natural join facility 
									where location='".$_SESSION['location']."') as localstaff where title like '%$q%';");
}
else if(preg_match("/RECIPE/", $_SESSION['referrer']) ){
	if($_SESSION['accesslv']==1)
		$query = new CustomQuery("select distinct mitem_id, menuI.name, menuI.sku from supplies inner join 
								(select * from ingredients natural join menu_item) as menuI on menuI.name like '%$q%' group by mitem_id;");
	if($_SESSION['accesslv']==4 || $_SESSION['accesslv']==5){
		$query = new CustomQuery("select distinct mitem_id, menuI.name, menuI.sku from supplies inner join 
									(select * from ingredients natural join (select * from menu_item natural join 
									(select * from menu natural join facility where location ='".$_SESSION['location']."') 
									as localMenu) as localItem) as menuI on menuI.name like '%$q%' group by mitem_id;");
	}
}
else if((preg_match("/supply/", $_SESSION['referrer']) || preg_match("/local/", $_SESSION['referrer'])) && $_SESSION['accesslv']==1){
	$type="";
	if(preg_match("/FOOD/", $_SESSION['referrer']))$type = "food";
	else if(preg_match("/KITCHEN/", $_SESSION['referrer'])) $type ="kitchen supplies";
	else if(preg_match("/LINEN/", $_SESSION['referrer'])) $type ="linens";
	else if(preg_match("/SERVICE/", $_SESSION['referrer'])) $type ="service items";
	
	$query = new CustomQuery("SELECT distinct sku, name from supplies natural join (select * from facility natural join facilitystock) as facility where supplies.name like '%$q%' AND type = '$type';");	
	if(preg_match("/localTable/", $_SESSION['referrer']))
		$query = new CustomQuery("SELECT distinct sku, name from supplies natural join (select * from facility natural join facilitystock) as facility where supplies.name like '%$q%';");
}


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