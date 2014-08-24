<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
?>
<?php 
    $mitem_id = strip_tags( $_POST['task'] );
    echo '<input name="menu_item['.$mitem_id.']" value="'.$mitem_id.'" type="hidden">';


    $query_mi = new CustomQuery("select name, price from menu_item where mitem_id=".$mitem_id);
    $result_m = $query_mi->execute();
    if ($result_m) {
        $row_mi = mysqli_fetch_row($result_m);
        echo '<div>'.$mitem_id.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$row_mi[0].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_mi[1].'</div>';
    }
?>
