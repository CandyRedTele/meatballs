<?php 
	error_reporting(E_ALL);
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php");
	session_start();
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
</head>
<body>

<div id="demo_top_wrapper">

	<div id="demo_top">
		<div class="demo_container">
			<div id="my_logo">Our logo</div>
		</div>
	</div>

	<div id="sticky_navigation_wrapper">
		<div id="sticky_navigation">
			<div class="demo_container">
				<ul>
					<li><a href="#" class="selected">HOME</a></li>
					<li><a href="#">ABOUT US</a></li>
					<li><a href="#">SERVICES</a></li>

					<li><a href="#">CLIENTS</a></li>
					<li><a href="#">PARTNERS</a></li>
					<li><a href="#">CONTACT</a></li>
				</ul>
			</div>
		</div>
	</div>

	
</div><!-- #demo_top_wrapper -->

<!-- everything below is just content to fill the page -->

<section id="main">

	<div id="content">
	
		
	</div>
	
</section><!-- #main -->

<footer>
	<p>Copyright © 2011 Backslash • Created by <a href="http://www.backslash.gr">Nikos Tsaganos</a></p>
</footer>

</body>
</html><!-- #demo_top_wrapper -->

<!-- everything below is just content to fill the page -->
<!--
<table align="center" border="0" cellpadding="0" cellspacing="0" width="920">
   <tr>
     <td width="25px">&nbsp;</td>
      <td colspan="2"><div class="ueberschrift">Put a little heading here</div></td>
      <td width="25px">&nbsp;</td>
   </tr>
   <tr>
   <td width="25px">&nbsp;</td>
      <td class="obenlinks">Text/Logo</td>
      <td class="oben" valign="top"><div id="textobengross">My beautiful new website</div><div id="textobenklein">Here you find everything you need</div></td>
      <td width="20px">&nbsp;</td>
   </tr>
   <tr> <td width="25px">&nbsp;</td>
     <td valign="top" class="links">
        <ul class="menue">
          <li><a title="Home" href="tableHOME.php">&raquo; Home</a></li>
          <li><a title="employees" href="table1.html">&raquo; entrée</a></li>
          <li><a title="Page 3" href="#">&raquo; main course</a></li>
          <li><a title="Page 4" href="#">&raquo; wine</a></li>
          <li><a title="Page 5" href="#">&raquo; dessert</a></li>
          <li><a title="Page 6" href="#">&raquo; children’s menu</a></li>
        </ul>
      </td>
      <td class="hauptfenster" valign="top"><div class="haupttext">
<!--                                   MENU LIST                                          
		
		
		
		
	  </td>
        <td width="25px">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="4"><div class="ueberschrift"><a href="mailto:ihreadresse@ihremprovider.de">Mail</a> | <a href="#">Imprint</a> | <a href="#">Terms of Use</a></div></td>
   </tr>
</table>

</body>
</html>-->