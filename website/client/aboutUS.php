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
<link href="css/demo2.css" rel="stylesheet" type="text/css" />
<!-- required for is demo -->
<link rel="stylesheet" href="sticky-navigation.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <style type="text/css">.contact_info p {font-size: 13px;
		color: #333;
		line-height: 1.8em;}
		.hh {font-size: 13px;
		color: #333;
		line-height: 1.8em;}</style>

<link rel="stylesheet" href="css/stylesheet7.css" />

<link rel="stylesheet" href="css/recipeBOX.css" />
<style>.menu-items li{width:50%}</style>
  <link href="css/hheader.css" rel="stylesheet" type="text/css" media="all" />

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
          <li><a href="home.php?'.$parameter.'">HOME</a></li>
            <li><a href="reservation.php?'.$parameter.'">Reservation</a></li>
            <li class="active"><a href="aboutUS.php?'.$parameter.'">About Us</a></li>
            <li><a href="registration.php?'.$parameter.'">Golden member</a></li>';
        ?>
        </ul>
      </div>
    </div>
<div class="clear"></div>
<div class="main">
	<div class="section group">
		<div class="col span_2_of_contact">
			<div class="contact-form">
			<h3>Our Hours</h3>
				<?php
					$query = new CustomQuery("SELECT * from facilityHours");

					if (!is_null($query))
						$result = $query->execute();

					if(isset($result))
						while($row = mysqli_fetch_row($result))
						{
							$row[1]=preg_replace("/\:[0-9]{2}$/","",$row[1]);
							$row[2]=preg_replace("/\:[0-9]{2}$/","",$row[2]);
							echo "<div class='hh date-day grid2column'>" . $row[0] .
									"</div><div class='hh hours-date grid2column lastcolumn'>" . $row[1] .
									" to " . $row[2]. "</div>";
						}
				?>
			</div>
		</div>
		<div class="col span_1_of_contact">
			<div class="contact_info">
			     	<h3>Address</h3>
			<?php
					$query = new CustomQuery("SELECT address, phone from facility where f_id = ". $parameter. "");

					if (!is_null($query))
						$result = $query->execute();

					if(isset($result)) {
						$row = mysqli_fetch_row($result);
							echo "<p>" .$row[0]. "</p>
                                  <p>Phone: " .$row[1]."</p>";
                    }
			?>
			</div>
		<div class="clear"></div>
	</div>
</div>

</div>
</body>

</html>
