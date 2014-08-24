<?php
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php");
    $parameter = $_SERVER['QUERY_STRING'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mamma Meatballs</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<link rel="stylesheet" href="css/stylesheet7.css" />

<link href='http://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/recipeBOX.css" />
<link href="css/hheader.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
    .menu-items li{width:50%}
</style>

</head>
                
<body>
<div class="header-box"></div>
<div class="wrap">
	<div class="total">
		<div class="header">
			<div class="header-bot">
				<div class="logo">
					<a href="../index.php"><img width="300px" height="150px" src="img/welcomeALT1.jpg" alt=""/></a>
				</div>
			</div>
		 </div>
		<div class="menu">
			<div class="top-nav">
				<ul>
				<?php
					echo '
                    <li><a href="../index.php">HOME</a>
                    <li class="active"><a href="home.php?'.$parameter.'">Menu</a></li>
				    <li><a href="reservation.php?'.$parameter.'">Reservation</a></li>
				    <li><a href="aboutUS.php?'.$parameter.'">About Us</a></li>
				    <li><a href="registration.php?'.$parameter.'">Golden member</a></li>';
				?>
				</ul>
			</div>
		</div>
<div class="clear"></div>

<div id="main">
<?php
    $queryLocation = new CustomQuery("select location from facility where f_id=".$parameter."");
    if (!is_null($queryLocation)) { $resultF = $queryLocation->execute();}
    if(isset($resultF)) {
            $rowF = mysqli_fetch_row($resultF);}
    echo"<h1 class='logotitle'>Mamma Meatballs Menu</h1>";
    echo "<h3 class='logosubtitle'>".$rowF[0]."</h3>"?>

    <div class="width-container">
        <div class="grid2column">

<?php
$categories=array("entree","main","kids","deserts","wines");
$arrlength=count($categories);

for($x=0;$x<$arrlength;$x++) {
    echo "<div class='heading3'><h3>".ucwords($categories[$x])."</h3></div>";

    $query2 = new CustomQuery("select name, price from menu_item natural join (menu natural join facility) where
							facility.f_id ='" . $parameter . "' and menu_item.category = '". $categories[$x]. "'");

    if (!is_null($query2)) { $menus_items = $query2->execute();}

    echo "<ul class='menu-items'>";

    while($menu_items = mysqli_fetch_row($menus_items)) {
		echo "<li><div class='grid2column'>" . $menu_items[0] .
		"</div><div class='grid2column lastcolumn'>$" . $menu_items[1] . "</div>";


		$query3 = new CustomQuery("select image, menuI.name, supplies.name, amount "
									. " from supplies inner join (select * from menu_item natural join ingredients  "
									. " where name = '".$menu_items[0]."') as menuI on supplies.sku = menuI.sku;");

		if (!is_null($query3)) { $recipe = $query3->execute();}

		$ing = array();
		while($info = mysqli_fetch_row($recipe)){
			if ($categories[$x] != 'wines') 
				$ing[] = "<div class='numF'>$info[3] $info[2]</div>";
			if(!isset($img))
				$img=$info[0];
		}

		if ($categories[$x] == 'wines'){
			$query4 = new CustomQuery("select rate from wine natural join (select mitem_id from menu_item where name='".$menu_items[0]."') as item;");

			$wRATE = $query4->execute();
			$rate = mysqli_fetch_row($wRATE);

			$ing[] = "<div class='numF'>Rating: $rate[0]</div>";
		}

		echo "<div class='itemINFO'>
				<img src='".$img."' width='40%' height='20%'/><h3>".$menu_items[0]."</h3>";

		foreach($ing as $i){echo $i;}

		echo "	</div><div class='clearfix'></div></li>";
		unset($img);
    }

    echo "</ul>";
    echo "<div class='menu-spacer'></div>";
}
echo "</div></div></div>";
?>

   </div>
</div>
</body>
</html>
