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
					<li><a href="menuHOME" class="selected">MENU</a></li>
					<li><a href="menu1.php">LOCAL2</a></li>
					<li><a href="menu2.php">LOCAL3</a></li>

					<li><a href="menu3.php">LOCAL4</a></li>
					<li><a href="#">LOCAL5</a></li>
					<li><a href="#">LOCAL6</a></li>
				</ul>
			</div>
		</div>
	</div>

	
</div><!-- #demo_top_wrapper -->

<!-- everything below is just content to fill the page -->

<section id="main">

	<div id="content">

	
	
<!--                end of main content									-->
	</div>
	
</section><!-- #main -->

<footer>
	<p>Copyright © 2014 Backslash • Created by XXX XXX XXX</p>
</footer>

</body>
</html>