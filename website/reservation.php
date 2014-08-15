<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta charset="utf-8"/>
<title>Results</title>
<link rel="stylesheet" type="text/css" href="css/view.css" />
<script type="text/javascript" src="js/reservationVIEW.js"></script>
<script type="text/javascript" src="js/reservationCALENDER.js"></script>
<link rel="stylesheet" href="http://yui.yahooapis.com/3.17.2/build/cssbutton/cssbutton.css">
</head>
<body>
	<img id="top" src="img/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
		<form id="form_888344" class="appnitro"  method="post" action="reservation_valid.php">
					<div class="form_description">
			<h2>BOOK A RESERVATION?</h2>
			<p></p>
		</div>						
			<ul >
					<li id="li_2" >
		<label class="description" for="element_2">Your Name </label>
		<span>
			<input id="element_2_1" name= "element_2_1" class="element text" maxlength="44" size="15" value=""/>
			<label>First</label>
		</span>
		<span>
			<input id="element_2_2" name= "element_2_2" class="element text" maxlength="44" size="15" value=""/>
			<label>Last</label>
		</span> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Your Email </label>
		<div>
			<input id="element_4" name="element_4" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_9" >
		<label class="description" for="element_9">Your Phone </label>
		<span><input id="element_9_1" name="element_9_1" class="element text" size="3" maxlength="3" value="" type="text"> -
			<label for="element_9_1">(###)</label>
		</span>
		<span>
			<input id="element_9_2" name="element_9_2" class="element text" size="3" maxlength="3" value="" type="text"> -
			<label for="element_9_2">###</label>
		</span>
		<span>
	 		<input id="element_9_3" name="element_9_3" class="element text" size="4" maxlength="4" value="" type="text">
			<label for="element_9_3">####</label>
		</span>
		 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Date </label>
		<span>
			<input id="element_3_1" name="element_3_1" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_3_1">MM</label>
		</span>
		<span>
			<input id="element_3_2" name="element_3_2" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_3_2">DD</label>
		</span>
		<span>
	 		<input id="element_3_3" name="element_3_3" class="element text" size="4" maxlength="4" value="" type="text">
			<label for="element_3_3">YYYY</label>
		</span>
	
		<span id="calendar_3">
			<img id="cal_img_3" class="datepicker" src="img/calendar.gif" alt="Pick a date.">	
		</span>
		<script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_3_3",
			baseField    : "element_3",
			displayArea  : "calendar_3",
			button		 : "cal_img_3",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script>
		 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">Time </label>
		<span>
			<input id="element_5_1" name="element_5_1" class="element text " size="2" type="text" maxlength="2" value=""/> : 
			<label>HH</label>
		</span>
		<span>
			<input id="element_5_2" name="element_5_2" class="element text " size="2" type="text" maxlength="2" value=""/> : 
			<label>MM</label>
		</span>
		<span>
			<input id="element_5_3" name="element_5_3" class="element text " size="2" type="text" maxlength="2" value=""/>
			<label>SS</label>
		</span>
		<span>
			<select class="element select" style="width:4em" id="element_5_4" name="element_5_4">
				<option value="AM" >AM</option>
				<option value="PM" >PM</option>
			</select>
			<label>AM/PM</label>
		</span> 
		</li>		<li id="li_7" >
		<label class="description" for="element_7">Number of Guests </label>
		<div>
		<select class="element select medium" id="element_7" name="element_7"> 
			<option value="" selected="selected"></option>
<option value="1" >less than 5</option>
<option value="2" >5 to 10</option>
<option value="3" >10 to 15</option>
<option value="4" >15 to 20</option>
<option value="5" >20 to 25</option>

		</select>
		</div> 
		</li>		<li id="li_10" >
		<label class="description" for="element_10">Multiple Choice </label>
		<span>
			<input id="element_10_1" name="element_10" class="element radio" type="radio" value="1" />
<label class="choice" for="element_10_1">Birthday</label>
<input id="element_10_2" name="element_10" class="element radio" type="radio" value="2" />
<label class="choice" for="element_10_2">Company festival</label>
<input id="element_10_3" name="element_10" class="element radio" type="radio" value="3" />
<label class="choice" for="element_10_3">Individual party</label>
<input id="element_10_4" name="element_10" class="element radio" type="radio" value="4" />
<label class="choice" for="element_10_4">Other</label>

		</span> 
		</li>		<li id="li_8" >
		<label class="description" for="element_8">description </label>
		<div>
			<textarea id="element_8" name="element_8" class="element textarea medium"></textarea> 
		</div><p class="guidelines" id="guide_8"><small>any specific requirement?</small></p> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="888344" />
			    
				<input id="saveForm" class="yui3-button" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="img/bottom.png" alt="">

</body>
</html>