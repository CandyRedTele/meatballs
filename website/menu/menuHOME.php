<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php");
	//session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A "stick-to-top" navigation menu with jQuery - Backslash</title>
<link href="demo2.css" rel="stylesheet" type="text/css" />
<!-- required for this demo -->
<link rel="stylesheet" href="sticky-navigation.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<link rel="stylesheet" href="../css/stylesheet7.css" />

<script>
$(function() {
	// grab the initial top offset of the navigation 
	var sticky_navigation_offset_top = $('#sticky_navigation').offset().top;
	
	// our function that decides weather the navigation bar should have "fixed" css position or not.
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); // our current vertical position from the top
		
		// if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
		if (scroll_top > sticky_navigation_offset_top)
			$('#sticky_navigation').css({ 'position': 'fixed', 'top':0, 'left':0 });
		else 
			$('#sticky_navigation').css({ 'position': 'relative' }); 
	};
	
	// run our function on load
	sticky_navigation();
	
	// and run it again every time you scroll
	$(window).scroll(function() { sticky_navigation();});
	
	// NOT required:
	// for this demo disable all links that point to "#"
	$('a[href="#"]').click(function(event){	event.preventDefault(); });
});
</script>
<link rel="stylesheet" href="../css/recipeBOX.css" />
<style>.menu-items li{width:50%}</style>
</head>
<body>
<?php include_once("menuNAVIGATION.php"); ?>

<!--								MENU starts HERE ! ! !							-->

<?php
$parameter = $_SERVER['QUERY_STRING'];
echo "<div id='main'>
		<div class='width-container'>
			<div class='grid2column'>";

$query1 = new CustomQuery("select distinct category from menu_item");
if (!is_null($query1)) { $categories = $query1->execute();}

while($category = mysqli_fetch_row($categories)) {

    echo "<h3 class='header-underline'>".$category[0]."</h3>";
	
    $query2 = new CustomQuery("select name, price from menu_item natural join (menu natural join facility) where
        facility.f_id ='" . $parameter . "' and menu_item.category = '". $category[0]. "'");
		
    if (!is_null($query2)) { $menus_items = $query2->execute();}
	
    echo "<ul class='menu-items'>";
	
    while($menu_items = mysqli_fetch_row($menus_items)) {
		echo "<li><div class='grid2column'>" . $menu_items[0] . 
		"</div><div class='grid2column lastcolumn'>$" . $menu_items[1] . "</div>";
		
        
		$query3 = new CustomQuery("select image, menuI.name, supplies.name, amount
from supplies inner join (select * from menu_item natural join ingredients where name = '".$menu_items[0]."')
as menuI on supplies.sku = menuI.sku;");
		
		if (!is_null($query3)) { $recipe = $query3->execute();}
		
		// var_dump($recipe);
		
		$ing = array();
		while($info = mysqli_fetch_row($recipe)){
			$ing[] = "<div class='numF'>$info[3] $info[2]</div>";
			if(!isset($img))
				$img=$info[0];
			// echo $info[2];
		}
		
		echo "<div class='itemINFO'>
				<img src='".$img."' width='20%' height='10%'/><h3>".$menu_items[0]."</h3>";
				// $l=1;
		foreach($ing as $i){echo $i;}//$l++."_".
		
		echo "<form action=''><input type='button' value='order'/></form>
			</div><div class='clearfix'></div></li>";
		unset($img);
    }
	
    echo "</ul>";
    echo "<div class='menu-spacer'></div>";
}
echo "</div></div></div>";
?>

	
<!--								MENU ends HERE ! ! !							-->
	</div>
	
</section><!-- #main -->

<footer>
	<p>Copyright © 2014 Backslash • Created by XXX XXX XXX</p>
</footer>

</body>
</html>