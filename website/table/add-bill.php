<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title>Bill</title>
    <style type="text/css" media="all">
    h2 {
        margin-left:40px;
        color:#333;
    }
    p {
        margin-left:40px;
        color:#333;
    }

    table {
        font-family:Arial, Helvetica, sans-serif;
        color:#666;
        font-size:12px;
        text-shadow: 1px 1px 0px #fff;
        background:#eaebec;
        margin:20px;
        border:#ccc 1px solid;

        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        border-radius:3px;

        -moz-box-shadow: 0 1px 2px #d1d1d1;
        -webkit-box-shadow: 0 1px 2px #d1d1d1;
        box-shadow: 0 1px 2px #d1d1d1;
    }
    table th {
        padding:21px 25px 22px 25px;
        border-top:1px solid #fafafa;
        border-bottom:1px solid #e0e0e0;

        background: #ededed;
        background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
        background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
    }
    table th:first-child {
        text-align: left;
        padding-left:20px;
    }
    table tr:first-child th:first-child {
        -moz-border-radius-topleft:3px;
        -webkit-border-top-left-radius:3px;
        border-top-left-radius:3px;
    }
    table tr:first-child th:last-child {
        -moz-border-radius-topright:3px;
        -webkit-border-top-right-radius:3px;
        border-top-right-radius:3px;
    }
    table tr {
        text-align: center;
        padding-left:20px;
    }
    table td:first-child {
        text-align: left;
        padding-left:20px;
        border-left: 0;
    }
    table td {
        padding:18px;
        border-top: 1px solid #ffffff;
        border-bottom:1px solid #e0e0e0;
        border-left: 1px solid #e0e0e0;

        background: #fafafa;
        background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
        background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
    }
    table tr.even td {
        background: #f6f6f6;
        background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
        background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
    }
    table tr:last-child td {
        border-bottom:0;
    }
    table tr:last-child td:first-child {
        -moz-border-radius-bottomleft:3px;
        -webkit-border-bottom-left-radius:3px;
        border-bottom-left-radius:3px;
    }
    table tr:last-child td:last-child {
        -moz-border-radius-bottomright:3px;
        -webkit-border-bottom-right-radius:3px;
        border-bottom-right-radius:3px;
    }
    table tr:hover td {
        background: #f2f2f2;
        background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
        background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
    }
    </style>
</head>
<body>
<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	session_start();
?>
<?php 
$menu_item = $_POST['menu_item'];
$mitem_array = array();
$current_location = $_SESSION['location'];
echo "<h2>Bill for ".$current_location."</h2>";
echo "<table>";
echo "		<thead>
			<tr>
				<th>Articles</th>
				<th>Price</th>
			</tr>
		</thead>";
foreach( $menu_item as $key => $n ) {
    $query_des = new CustomQuery("select name, price from menu_item where mitem_id=".$n);
    if (!is_null($query_des)) {
        $result_mitem = $query_des->execute();
    }
    $row = mysqli_fetch_row($result_mitem);
    echo "<tr>";
    echo "<td>".$row[0]."</td><td>".$row[1]."</td>";
    echo "</tr>";
    array_push($mitem_array, $n);
}

$logger = Logger::getSingleInstance();

$gold_n = $_POST['gold_num'];
$query_fa = new CustomQuery("select f_id from facility where location='".$current_location."'");
$result_f_id = $query_fa->execute();
if ($result_f_id) {
    $row_fa = mysqli_fetch_row($result_f_id);
    $current_location_id = $row_fa[0];
}


if ($gold_n == '') {
    $query_f = new InsertIntoBillQuery($current_location_id, $mitem_array);
} else {
    $logger->write("\t[add-bill.php] gold_n is :" .  $gold_n );
    echo "<tr><td>Golden Discount</td><td>-10%</td></tr>";
    $query_f = new InsertIntoBillQuery($current_location_id, $mitem_array, $gold_n);
}

$result_b = $query_f->execute();

if ($result_b) {
    $row = mysqli_fetch_row($result_b);
    $b_id = $row[0];


    $query_call_back = new GetBillTotalQuery($b_id);
    $result_call_back = $query_call_back->execute();

    if ($result_call_back) {
        $row = mysqli_fetch_row($result_call_back);
        $total = $row[2];
        echo "<tr><td><b>TOTAL</b></td><td><b>".$total."</b></td></tr>";
        echo "</table>";
        echo "<p>You were served by ".$_SESSION['name']."</p>";
    }
}
?>
</body>
</html>

