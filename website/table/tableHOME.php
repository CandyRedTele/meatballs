<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 
	
	session_start();
?>
<html>
<head>
  <title>My information</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; CHARSET=ISO-8859-1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  <meta name="description" content="" />
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" media="all" /> 
  <link rel="stylesheet" type="text/css" href="../css/resume.css" media="all" />
  <style> #staffTITLE{ text-transform: uppercase;} </style>
</head>

<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="865">
	
	<?php include_once("navigationBAR.php"); ?> <!-- navigation bar on top -->

    <tr>
      <td id="mainbg" valign="top"><div id="haupttext">
<!--                                   INFORMATION TABLES                                          -->

<div id="doc2" class="yui-t7">
	<div id="inner">
		<div id="hd">
			<div class="yui-gc">
				<div class="yui-u first">
					<p id="staffNAME" style="font-size:30px;"><em><?php echo $_SESSION['name'];?></em></p> <!-- NAME -->
					<br/>
					<h2>ID: <?php echo $_SESSION['SID'];?></h2> <!-- TITLE -->
				</div>
				<div class="yui-u">
					<div class="contact-info">
						<h3>SSN: <?php echo $_SESSION['ssn'];?></h3>
						<h3>Location: <?php if($_SESSION['accesslv']==1 ||$_SESSION['accesslv']==2 || $_SESSION['accesslv']==3)
												echo "Montreal";
											else
												echo $_SESSION['location'];?></h3> 
						<h3>Phone: <?php echo $_SESSION['phone'];?></h3> <!-- PHONE -->
					</div><!--// .contact-info -->
				</div>
			</div><!--// .yui-gc -->
		</div><!--// hd -->

		<div id="bd">
			<div id="yui-main">
				<div class="yui-b">
					<div class="yui-gf">
						<div class="yui-u first">
							<h2>Title</h2>
						</div>
						<div class="yui-u">
							<p class="enlarge" id="staffTITLE">
								 <?php echo $_SESSION['title'];?>
							</p>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<h2>EXPERIENCE</h2>
						</div>
						<div class="yui-u">
								<div class="talent">
									<h2>START DATE/ EXPERIENCE</h2> <!-- START DATE -->
									<p>
	<?php if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==2|| $_SESSION['accesslv']==3)
				$query = new CustomQuery("SELECT yrs_exp from admin where staff_id='".$_SESSION['SID']."';");
		else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5|| $_SESSION['accesslv']==6|| $_SESSION['accesslv']==7|| $_SESSION['accesslv']==10)
				$query = new CustomQuery("SELECT start_date from localstaff where staff_id='".$_SESSION['SID']."';");	
		
		$result = $query->execute();
				
		if(isset($result)){
			$row = mysqli_fetch_row($result);
			if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==2|| $_SESSION['accesslv']==3)
				echo "<em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$row[0] years</em>";
			else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5|| $_SESSION['accesslv']==6|| $_SESSION['accesslv']==7|| $_SESSION['accesslv']==10)
				echo "on<em> $row[0]</em>";
		}
	?>
								</p>
								</div>

								<div class="talent">
									<h2>Training</h2>
									<p>
	<?php if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==2|| $_SESSION['accesslv']==3){
				// $query = new CustomQuery("SELECT training from admin where staff_id='".$_SESSION['SID']."';");
				
				// $result = $query->execute();
				
			// if(isset($result)){
				// $row = mysqli_fetch_row($result);
				// if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==2|| $_SESSION['accesslv']==3)
					// echo "<em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$row[0]</em>";
			// }
			echo "<em>NOT AVAILABLE</em>";
		}
		else if($_SESSION['accesslv']==4|| $_SESSION['accesslv']==6|| $_SESSION['accesslv']==7|| $_SESSION['accesslv']==10)
				echo "<em>NOT AVAILABLE</em>";
		else if($_SESSION['accesslv']==5){
			$query = new CustomQuery("select training from staff natural join localstaff where staff.staff_id = '".$_SESSION['SID']."';");
				
				$result = $query->execute();
				
			if(isset($result)){
				$row = mysqli_fetch_row($result);
				echo "<em>$row[0]</em>";
			}
		}	
		

	?>
									
									</p>
								</div>
						</div>
					</div><!--// .yui-gf -->

		<?php if($_SESSION['accesslv']==7){
				echo '<div class="yui-gf">
						<div class="yui-u first">
							<h2>Shifts Hours</h2>
						</div>
						<div class="yui-u">';
		
				$getSHIFT = new CustomQuery("select shift.* from staff natural join shift where staff.staff_id ='".$_SESSION['SID']."';");
				
				$shiftR = $getSHIFT->execute();
				

				while($shift = mysqli_fetch_row($shiftR)){
					if(!($shift[1]<date("Y-m-d")))
						echo '<ul class="talent">
								<li>date:&nbsp;'.$shift[1].'</li>
								<li>start: '.$shift[2].'</li>
								<li>end:&nbsp;&nbsp; '.$shift[3].'</li>
								<li class="last">pay:&nbsp;&nbsp; '.$shift[4].'</li>
							</ul>';
				}
				echo '</div>
					</div><!--// .yui-gf-->';
			}
		?>
					<!--<div class="yui-gf">
	
						<div class="yui-u first">
							<h2>PREVIOUS Experience</h2>
						</div><!--// .yui-u -->

						<!--<div class="yui-u">

							<div class="job">
								<h2>Facebook</h2>
								<h3>Senior Interface Designer</h3>
								<h4>2005-2007</h4>
								<p>Intrinsicly enable optimal core competencies through corporate relationships. Phosfluorescently implement worldwide vortals and client-focused imperatives. Conveniently initiate virtual paradigms and top-line convergence. </p>
							</div>

						</div><!--// .yui-u -->
					<!--</div><!--// .yui-gf -->


					<!--<div class="yui-gf last">
						<div class="yui-u first">
							<h2>Education</h2>
						</div>
						<div class="yui-u">
							<h2>Indiana University - Bloomington, Indiana</h2>
							<h3>Dual Major, Economics and English &mdash; <strong>4.0 GPA</strong> </h3>
						</div>
					</div><!--// .yui-gf -->

				</div><!--// .yui-b -->
			</div><!--// yui-main -->
		</div><!--// bd -->

		<!--<div id="ft">
			<p>Jonathan Doe &mdash; <a href="mailto:name@yourdomain.com">name@yourdomain.com</a> &mdash; (313) - 867-5309</p>
		</div><!--// footer -->

	</div><!-- // inner -->
</div><!--// doc -->

<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>