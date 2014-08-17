<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta charset="utf-8"/>
<title>Results</title>
<link rel="stylesheet" type="text/css" href="css/view.css" />
<script type="text/javascript" src="js/reservationVIEW.js"></script>
<script type="text/javascript" src="js/reservationCALENDER.js"></script>
<link rel="stylesheet" href="http://yui.yahooapis.com/3.17.2/build/cssbutton/cssbutton.css">
<style> body{background-color:#C3D9FF}</style>
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
				<li id="li_2" >
					<label class="description" for="element_2">Your Name </label>
					<span>
						<input id="firstN" name= "firstN" class="element text" maxlength="44" size="15" value="" pattern="[A-z]{2,20}"/>
						<label>First</label>
					</span>
					<span>
						<input id="lastN" name= "lastN" class="element text" maxlength="44" size="15" value="" pattern="[A-z]{2,20}"/>
						<label>Last</label>
					</span> 
				</li>		
				<li id="li_4" >
					<label class="description" for="email">Your Email </label>
					<div>
						<input id="email" name="email" class="element text medium" type="text" maxlength="55" value="" pattern="[A-z_0-9]+@(hotmail|yahoo|gmail).(com|ca)"/> 
					</div> 
				</li>		
				<li id="li_9" >
					<label class="description" for="phone">Your Phone </label>
					<span><input id="phone1" name="phone1" class="element text" size="3" maxlength="3" value="" type="text" pattern="[0-9]{3}"> -
						<label for="phone1">(###)</label>
					</span>
					<span>
						<input id="phone2" name="phone2" class="element text" size="3" maxlength="3" value="" type="text" pattern="[0-9]{3}"> -
						<label for="phone2">###</label>
					</span>
					<span>
						<input id="phone3" name="phone3" class="element text" size="4" maxlength="4" value="" type="text" pattern="[0-9]{4}">
						<label for="phone3">####</label>
					</span> 
				</li>		
				
				<li id="li_3" >
					<label class="description" for="element_3">Date </label>
					<span>
						<input id="date1" name="date1" class="element text" size="2" maxlength="2" value="" type="text" > /
						<label for="date1">MM</label>
					</span>
					<span>
						<input id="date2" name="date2" class="element text" size="2" maxlength="2" value="" type="text"> /
						<label for="date2">DD</label>
					</span>
					<span>
						<input id="date3" name="date3" class="element text" size="4" maxlength="4" value="" type="text">
						<label for="date3">YYYY</label>
					</span>
					<span id="calendar_3">
						<img id="cal_img_3" class="datepicker" src="img/calendar.gif" alt="Pick a date.">	
					</span>
					<script type="text/javascript">
						Calendar.setup({
						inputField	 : "date3",
						baseField    : "element_3",
						displayArea  : "calendar_3",
						button		 : "cal_img_3",
						ifFormat	 : "%B %e, %Y",
						onSelect	 : selectDate
						});
					</script>
				</li>
				
				<li id="li_5" >
					<label class="description" for="element_5">Time </label>
					<span>
						<input id="time1" name="time1" class="element text " size="2" type="text" maxlength="2" value=""/ pattern="([0-9]|[1][0-9]|[2][0-4])"> : 
						<label>HH</label>
					</span>
					<span>
						<input id="time2" name="time2" class="element text " size="2" type="text" maxlength="2" value="" pattern="[0-5][0-9]"/> : 
						<label>MM</label>
					</span>
					<span>
						<input id="time3" name="time3" class="element text " size="2" type="text" maxlength="2" value="" pattern="[0-5][0-9]"/>
						<label>SS</label>
					</span>
				<!--	<span>
						<select class="element select" style="width:4em" id="element_5_4" name="element_5_4">
							<option value="AM" >AM</option>
							<option value="PM" >PM</option>
						</select>
						<label>AM/PM</label>
					</span> -->
				</li>		
				<li id="li_7" >
					<label class="description" for="element_7">Number of Guests </label>
					<div>
					<select class="element select medium" id="guestNO" name="guestNO"> 
						<option value="" selected="selected"></option>
						<option value="5" >less than 5</option>
						<option value="10" >5 to 10</option>
						<option value="15" >10 to 15</option>
						<option value="20" >15 to 20</option>
						<option value="25" >20 to 25</option>
					</select>
					</div> 
				</li>		
		
				<li id="li_7" >
					<label class="description" for="element_7">Type of banquet</label>
					<div>
						<select class="element select medium" id="resTYPE" name="resTYPE"> 
							<option value="" selected="selected"></option>
							<option value="1" >Birthday</option>
							<option value="2" >Company festival</option>
							<option value="3" >Individual party</option>
							<option value="4" >Other</option>
						</select>
					</div> 
				</li>
		
		<!--		<li id="li_10" >
				<label class="description" for="element_10">Type of banquet</label>
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
				</li>-->		
				
				<li id="li_7" >
					<label class="description" for="element_7">Please choose your location</label>
					<div>
						<select class="element select medium" id="location" name="location"> 
							<option value="" selected="selected"></option>
							<option value="Montreal" >Montreal</option>
							<option value="Toronto" >Toronto</option>
							<option value="Winipeg" >Winipeg</option>
							<option value="Narnia" >Narnia</option>
							<option value="Calgary" >Calgary</option>
							<option value="Faraway" >Faraway</option>
							<option value="Halifax" >Halifax</option>
							<option value="Ottawa" >Ottawa</option>
							<option value="Vancouver" >Vancouver</option>
							<option value="Regina" >Regina</option>
							<option value="Quebec" >Quebec</option>
							<option value="Sherbrooke" >Sherbrooke</option>
						</select>
					</div> 
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