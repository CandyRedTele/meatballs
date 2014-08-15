<?php 
	error_reporting(E_ALL);
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
					<h1><?php echo $_SESSION['name'];?></h1> <!-- NAME -->
					<h2><?php echo $_SESSION['title'];?></h2> <!-- TITLE -->
				</div>
				<div class="yui-u">
					<div class="contact-info">
						<h3>LOCATION</h3>
						<h3><a href="mailto:name@yourdomain.com"><?php echo"NO EMAIL!?";?></a></h3> <!-- EMAIL -->
						<h3><?php echo "phone: ".$_SESSION['phone'];?></h3> <!-- PHONE -->
					</div><!--// .contact-info -->
				</div>
			</div><!--// .yui-gc -->
		</div><!--// hd -->

		<div id="bd">
			<div id="yui-main">
				<div class="yui-b">
					<div class="yui-gf">
						<div class="yui-u first">
							<h2>SSN</h2>
						</div>
						<div class="yui-u">
							<p class="enlarge">
								 <?php echo $_SESSION['ssn'];?>
							</p>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<h2>EXPERIENCE</h2>
						</div>
						<div class="yui-u">
								<div class="talent">
									<h2>START DATE/EXPERIENCE</h2> <!-- START DATE -->
									<p>Assertively exploit wireless initiatives rather than synergistic core competencies.	</p>
								</div>

								<div class="talent">
									<h2>Training</h2>
									<p>Credibly streamline mission-critical value with multifunctional functionalities.	 </p>
								</div>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<h2>Technical</h2>
						</div>
						<div class="yui-u">
							<ul class="talent">
								<li>XHTML</li>
								<li>CSS</li>
								<li class="last">Javascript</li>
							</ul>

							<ul class="talent">
								<li>Jquery</li>
								<li>PHP</li>
								<li class="last">CVS / Subversion</li>
							</ul>
						</div>
					</div><!--// .yui-gf-->

					<div class="yui-gf">
	
						<div class="yui-u first">
							<h2>PREVIOUS Experience</h2>
						</div><!--// .yui-u -->

						<div class="yui-u">

							<div class="job">
								<h2>Facebook</h2>
								<h3>Senior Interface Designer</h3>
								<h4>2005-2007</h4>
								<p>Intrinsicly enable optimal core competencies through corporate relationships. Phosfluorescently implement worldwide vortals and client-focused imperatives. Conveniently initiate virtual paradigms and top-line convergence. </p>
							</div>

						</div><!--// .yui-u -->
					</div><!--// .yui-gf -->


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