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
			<?php 
				if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==2|| $_SESSION['accesslv']==3)
						$query = new CustomQuery("SELECT yrs_exp from admin where staff_id='".$_SESSION['SID']."';");
				else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5|| $_SESSION['accesslv']==6|| $_SESSION['accesslv']==7|| $_SESSION['accesslv']==10)
						$query = new CustomQuery("SELECT start_date from localstaff where staff_id='".$_SESSION['SID']."';");	
				
				$result = $query->execute();
						
				if(isset($result)){
					$xp = mysqli_fetch_row($result);
					if($_SESSION['accesslv']==1|| $_SESSION['accesslv']==2|| $_SESSION['accesslv']==3)
						echo "<em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$xp[0] years</em>";
					else if($_SESSION['accesslv']==4||$_SESSION['accesslv']==5|| $_SESSION['accesslv']==6|| $_SESSION['accesslv']==7|| $_SESSION['accesslv']==10)
						echo "on<em> $xp[0]</em>";
				}
			?>
								</p>
								</div>

								<div class="talent">
									<h2>Training</h2>
									<p>
			<?php 
				$query = new GetTrainingQuery($_SESSION['SID']);
				$result = $query->execute();
			
				$row = mysqli_fetch_row($result);
				echo "<em>$row[1]</em>";
			?>							
									</p>
								</div>
						</div>
					</div><!--// .yui-gf -->

			<?php if($_SESSION['accesslv']==7 || $_SESSION['accesslv']==10 || $_SESSION['title']=="wait staff"){
					echo '<div class="yui-gf">
							<div class="yui-u first">
								<h2>Shifts Hours</h2>
							</div>
							<div class="yui-u">';
			
					$getSHIFT = new CustomQuery("select shift.* from staff natural join shift where staff.staff_id ='".$_SESSION['SID']."';");
					
					$shiftR = $getSHIFT->execute();


					while($shift = mysqli_fetch_row($shiftR)){
						if(!($shift[1]<date("Y-m-d"))) {

                            $salQ = new CustomQuery("select base from wage where title = (select title from staff where staff.staff_id = ". $_SESSION['SID'].")");
                           $resultQ = $salQ->execute(); 
                            $sal = mysqli_fetch_row($resultQ);
                            $base = $sal[0];

                            $pay = 0;
                            $diff = $shift[3] - $shift[2];
                            $count = 0;

                            if ($diff < 8)
                                $pay = $base * $diff;
                            else
                                $pay = $base * 8 + ($base*1.25 * ($diff - 8));
							echo '<ul class="talent">
									<li>date:&nbsp;'.$shift[1].'</li>
									<li>start: '.$shift[2].'</li>
									<li>end:&nbsp;&nbsp; '.$shift[3].'</li>
									<li class="last">pay:&nbsp;&nbsp; '.$pay.'</li>
								</ul>';
                        }
					}
					echo '</div>
						</div><!--// .yui-gf-->';
				}
			?>
<?php 

                $query = new GetSalaryQuery($_SESSION['SID']);
                $result = $query->execute();
            $row = mysqli_fetch_row($result);
            $salary;
            if ($_SESSION['accesslv'] == 1 || $_SESSION['accesslv'] == 2 || $_SESSION['accesslv'] == 3 || $_SESSION['accesslv'] == 4 || $_SESSION['accesslv'] == 5) {
                $dt = strtotime($xp[0]);
                $xp= date("Y-m-d", $dt);
                $diff = date("Y-m-d") - $xp ;
                $add = ($row[3] *($diff/2));
                $salary = $row[2] + $add;


                echo '
					<div class="yui-gf">
	
						<div class="yui-u first">
							<h2>Salary/wage</h2>
						</div><!--// .yui-u -->

						<div class="yui-u">

							<div class="job">
								<h3>base:'.$row[2].'</h2>
								<h3>additional:'.$add.'</h3>
								<h3>actual:'.$salary.'</h4>
							</div>

						</div><!--// .yui-u -->
					</div><!--// .yui-gf -->';
            }
 ?>

<!--								THE END OF INFORMATION TABLE						-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>
