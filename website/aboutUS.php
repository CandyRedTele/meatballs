<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php");
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>About Us</title>
	<meta name="description" content="">
<meta name="viewport" content="width=device-width">
</script>
<link rel="stylesheet" href="css/stylesheet8.css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<style> 
#companyDESCRIPTION {width: 70%;}
#localADDRESS0, #localADDRESS1, #localADDRESS2{float:left;}
</style>
</head>
<div id="main">
		<div class="widget-area-highlight">
		<div class="width-container">
			
			<div class="grid4column homepage-widget" id="companyDESCRIPTION">
				<h3 class="header-underline">About us</h3>
				<p>At dawn on the 13th the Carnatic entered the port of Yokohama. This is an important port of call in the Pacific, where all the mail-steamers.</p>
			</div>
<?php			
			// <div class="grid4column homepage-widget">
				// <h3 class="header-underline">Email Updates</h3>
				// <!-- Begin MailChimp Signup Form -->
				// <div id="mc_embed_signup">
					// <form action="http://progressionstudios.us1.list-manage.com/subscribe/post?u=1a06aa3bca8613232881e8a6e&amp;id=2f5a556941" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						// <label for="mce-EMAIL">Join our digital mailing list and get news, deals, and be first to know about events at White Rock!</label>
						// <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter e-mail address" required>
						// <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
					// </form>
				// </div>
				// <!--End MailChimp Signup Form-->
			// </div>
			
?>				
			<div class="grid4column homepage-widget lastcolumn">
				<h3 class="header-underline">Our Hours</h3>
				<ul id="open-hours">
				<?php	$logger = Logger::getSingleInstace();
						$logger->write("HelloLogger!");
						
					$query = new CustomQuery("SELECT * from facilityhours");
						
					if (!is_null($query)) 
						$result = $query->execute();

							
					if(isset($result))
						while($row = mysqli_fetch_row($result)) 
						{
							$row[1]=preg_replace("/\:[0-9]{2}$/","",$row[1]);
							$row[2]=preg_replace("/\:[0-9]{2}$/","",$row[2]);
							echo "<li><div class='date-day grid2column'><h6>" . $row[0] . 
									"</h6></div><div class='hours-date grid2column lastcolumn'>" . $row[1] . 
									" to " . $row[2]. "</div><div class='clearfix'></div></li>";   
						}
				?>

				</ul>
			</div>
			
			
		<div class="clearfix"></div>
		</div><!-- close .width-container -->
		</div><!-- close .widget-area-highlight -->
			
		
		<div class="clearfix"></div>
		</div><!-- close #main -->

<footer>
		<div class="width-container">
			<div id="copyright">
				</br></br>
				<h3 class="header-underline">Visit us</h3>
				
				<div class="widget-area-highlight2" id="localADDRESS1">
					<div class="width-container">
						

						<div class="grid4column homepage-widget">
							</br></br>
							<h6 class="heading-address-widget">White Rock Restaurant</h6>
							<div class="address-widget">1422 1st St. Napa, CA 94559</div>
							<div class="phone-widget"><span>Phone:</span> (707) 255-0211</div>
							<div class="e-mail-widget"><span>E-mail:</span> <a href="#">admin@e-mail.com</a></div>
						</div>

				
						<div class="grid4column homepage-widget">
							</br></br>
							<h6 class="heading-address-widget">White Rock Restaurant</h6>
							<div class="address-widget">1422 1st St. Napa, CA 94559</div>
							<div class="phone-widget"><span>Phone:</span> (707) 255-0211</div>
							<div class="e-mail-widget"><span>E-mail:</span> <a href="#">admin@e-mail.com</a></div>
						</div>

			
						<div class="clearfix"></div>
					</div><!-- close .width-container -->
				</div><!-- close .widget-area-highlight -->
		
				<div class="widget-area-highlight2" id="localADDRESS2">
					<div class="width-container">
					
						<div class="grid4column homepage-widget">
							</br></br>
							<h6 class="heading-address-widget">White Rock Restaurant</h6>
							<div class="address-widget">1422 1st St. Napa, CA 94559</div>
							<div class="phone-widget"><span>Phone:</span> (707) 255-0211</div>
							<div class="e-mail-widget"><span>E-mail:</span> <a href="#">admin@e-mail.com</a></div>
						</div>

						
						<div class="grid4column homepage-widget">
							</br></br>
							<h6 class="heading-address-widget">White Rock Restaurant</h6>
							<div class="address-widget">1422 1st St. Napa, CA 94559</div>
							<div class="phone-widget"><span>Phone:</span> (707) 255-0211</div>
							<div class="e-mail-widget"><span>E-mail:</span> <a href="#">admin@e-mail.com</a></div>
						</div>
					
						<div class="clearfix"></div>
					</div><!-- close .width-container -->
				</div><!-- close .widget-area-highlight -->
				
				<div class="grid2column" width="30%" id="localADDRESS0"></br></br>
					<img src="img/aboutUSimg.jpg" width="100%" height="100%" alt="Logo-footer">
				</div>
				
				
			<div class="clearfix"></div>
			</div><!-- close #copyright -->
		</div><!-- close .width-container -->
	</footer>
		
</body>
</html>