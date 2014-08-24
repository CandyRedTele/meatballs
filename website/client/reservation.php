<?php
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php");
	//session_start();
        $parameter = $_SERVER['QUERY_STRING'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mamma Meatballs</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

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
			    <!-- <div class="clear"></div> -->
			</div>
		 </div>
		<div class="menu">
			<div class="top-nav">
				<ul>
				<?php
					echo '
                    <li><a href="../index.php">HOME</a>
					<li><a href="home.php?'.$parameter.'">Menu</a></li>
				    <li class="active"><a href="reservation.php?'.$parameter.'">Reservation</a></li>
				    <li><a href="aboutUS.php?'.$parameter.'">About Us</a></li>
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
				  	<h3>Make a reservation</h3>
					    <?php
          					echo '<form action="reservation_valid.php?'.$parameter.'" onsubmit="return(validate());" method="post" enctype="multipart/form-data">'?> 
					    	<div>
						    	<span><label>Name</label></span>
						    	<span><input name="userName" type="text" class="textbox" required></span>
						    </div>
						    <div>
						    	<span><label>Date</label></span>
						    	<span><input name="date" type="text" id="datepicker"></span>
						    </div>
						    <div>
						    	<span><label>Time</label></span>
						    	<span>
									<select name="timeHour">
										<option value="">Hour</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
									</select>
									:
									<select name="timeMins">
										<option value="">Minutes</option>
										<option value="00">00</option>
										<option value="15">15</option>
										<option value="30">30</option>
										<option value="45">45</option>
									</select>
								</span>
							</div>

							<div>
								<span><label>Number of Guests</label></span>
								<span>
									<select name="guestNO">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
									</select>
								</span>
							</div>
							<div>
						    	<span><label>Type of banquet</label></span>
						    	<span>
						    		<select class="element select medium" id="resTYPE" name="resTYPE">
										<option value="" selected="selected"></option>
										<option value="1" >Birthday</option>
										<option value="2" >Company festival</option>
										<option value="3" >Individual party</option>
										<option value="4" >Other</option>
									</select>
								</span>
						    </div>
						   <div>
						   		<span><input type="submit" value="Submit"></span>
						  </div>
					    </form>
				  </div>
  				</div>
		     <div class="clear"> </div>
			</div>
	</div>
</div>
</body>
</html>
