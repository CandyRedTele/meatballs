<html>
<head>

</head>
<body>
<?php
echo'
<div id="demo_top_wrapper">

	<div id="demo_top">
		<div class="demo_container">
			<div id="my_logo">MENUS</div>
		</div>
	</div>

	<div id="sticky_navigation_wrapper">
		<div id="sticky_navigation">
			<div class="demo_container">
				<ul>';	//<li><a href="menuHOME.php" class="selected">MENU</a></li>
				$logger = Logger::getSingleInstace();
				$logger->write("HelloLogger!");
				
									// $query1 = new CustomQuery("SELECT count(f_id) from facility");
									
									// if (!is_null($query1))
										// $result1 = $query1->execute();
									// $nofac = mysqli_fetch_row($result1);
				
				$query = new CustomQuery("SELECT f_id, location from facility");
				
				if (!is_null($query))
					$result = $query->execute();
				
				// $c=1;
				while($row = mysqli_fetch_row($result)) 
				{	
					echo '<li><a href="menuHOME.php?'.$row[0].'">'.$row[1].'</a></li>' ;
					// $c++;
					// if($c > 6)
						// break;
				}

			echo'</ul>
			</div>
		</div>
	</div>';
		// <div id="sticky_navigation_wrapper">
		// <div id="sticky_navigation">
			// <div class="demo_container">
				// <ul>	
				// $query = new CustomQuery("SELECT f_id, location from facility where f_id >".$c);
				
				// if (!is_null($query))
					// $result = $query->execute();
				
				// while($row = mysqli_fetch_row($result)) 
				// {
					// echo '<li><a href="menuHOME.php?'.$row[0].'">'.$row[1].'</a></li>' ;   
				// }

			// echo'</ul>
			// </div>
		// </div>
		// </div>
	
echo'</div>
<!-- everything below is just content to fill the page -->

<section id="mainSECTION">

	<div id="content">';
	
?>
</body>
</html>