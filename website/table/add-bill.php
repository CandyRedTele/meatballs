<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
?>
<?php 
$menu_item = $_POST['menu_item'];
var_dump($menu_item);
$mitem_array = array();
foreach( $menu_item as $key => $n ) {
  print "The menu item ".$n."\n";
  array_push($mitem_array, $n);
}
var_dump($mitem_array);

$logger = Logger::getSingleInstace();

$gold_n = $_POST['gold_num'];

if ($gold_n == '') {
    $query = new InsertIntoBillQuery(1, $mitem_array); 
} else {
    $logger->write("\t[add-bill.php] gold_n is :" .  $gold_n );
    $query = new InsertIntoBillQuery(1, $mitem_array, $gold_n); 
}

$result = $query->execute();

if ($result) {
    $row = mysqli_fetch_row($result);
    $b_id = $row[0];


    $query_call_back = new GetBillTotalQuery($b_id);
    $result_call_back = $query_call_back->execute();

    if ($result_call_back) {
        $row = mysqli_fetch_row($result_call_back);
        $total = $row[2];
        echo '\n';
        print $total;
    }
}
?>
