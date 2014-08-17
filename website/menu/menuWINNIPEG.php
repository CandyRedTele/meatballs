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

<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
</head>
<body>
<?php include_once("menuNAVIGATION.php"); ?>
<!--								MENU starts HERE ! ! !							-->

	<div id="main">
		<div class="width-container">
			<div class="grid2column">
				<h3 class="header-underline">Main Courses</h3>
				<ul class="menu-items">
					<li>
						<a href="menu-post.html"><div class="grid2column">Roasted Apple Tart</div>
						<div class="grid2column lastcolumn">$12,00</div>
						<div class="clearfix"></div>
						<div class="item-description-menu">Cras eget est tempor odio molestie ultricies. Donec gravida libero at metus tincidunt sit amet.</div></a>
					</li>
					
				</ul>
				
				<div class="menu-spacer"></div>
			</div>
			<div class="grid2column lastcolumn">
				<h3 class="header-underline">Drinks</h3>
				<ul class="menu-items">
					<li>
						<div class="grid2column">Cola</div>
						<div class="grid2column lastcolumn">$4,00</div>
						<div class="clearfix"></div>
					</li>
					
				</ul>
				
				<div class="menu-spacer"></div>
				<h3 class="header-underline">Salads</h3>
				<ul class="menu-items">
					<li>
						<div class="grid2column">Sundried Tomato Salad</div>
						<div class="grid2column lastcolumn">$10,00</div>
						<div class="clearfix"></div>
						<div class="item-description-menu">Cras eget est tempor odio molestie ultricies. Donec gravida libero at metus tincidunt sit amet.</div>
					</li>
					
				</ul>
				
				<div class="menu-spacer"></div>
			</div>
			<div class="clearfix"></div>
			
			
		<div class="clearfix"></div>
		</div><!-- 						close .width-container (INNER MENU ends HERE!!!)							-->
		
	</div><!-- close #main -->
	
<!--								MENU ends HERE ! ! !							-->


</body>
</html>