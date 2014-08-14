<!DOCTYPE html>
<html>
<head>
<title>GOLDEN MEMBER REGISTRATION</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="css/stylesheet3.css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/demo.css" media="all" />
	<!--<script type="text/javascript" src="js/javascript2.js"></script>-->
</head>
<body>
<div class="container">
			<!-- freshdesignweb top bar 
            <div class="freshdesignweb-top">
                <a href="http://www.freshdesignweb.com" target="_blank">Home</a>
                <span class="right">
                    <a href="http://www.freshdesignweb.com/beautiful-registration-form-with-html5-and-css3.html">
                        <strong>Back to the freshdesignweb Article</strong>
                    </a>
                </span>
                <div class="clr"></div>
            </div><!--/ freshdesignweb top bar -->
			<header>
				<h1><span>registration</span> Golden Member</h1>
            </header>       
	<div id="leftSide">
		<img src="img/goldMember.jpg"/>
	</div> 
      <div  class="form">
    	<form id="contactform" action="register_valid.php" onsubmit="return(validate());" enctype="multipart/form-data"> 
    		<p class="contact"><label for="name">First Name</label></p> 
    		<input id="firstN" name="firstN" placeholder="First name" required pattern="[A-z0-9]{2,20}" tabindex="1" type="text">
				
			<p class="contact"><label for="name">Last Name</label></p> 
    		<input id="lastN" name="lastN" placeholder="Last name" required pattern="[A-z0-9]{2,20}" tabindex="1" type="text"> 
    			 
    		<p class="contact"><label for="email">Email</label></p> 
    		<input id="email" name="email" placeholder="example@domain.com" required pattern="[A-z_0-9]+@(hotmail|yahoo|gmail).(com|ca)" type="email"> 
                
            <!--<p class="contact"><label for="username">Create a username</label></p> 
    		<input id="username" name="username" placeholder="username" pattern="" tabindex="2" type="text"> 
    			 
            <p class="contact"><label for="password">Create a password</label></p> 
			<input type="password" id="password" name="password" pattern="[A-z0-9]{8,16}"> 
            <p class="contact"><label for="repassword">Confirm your password</label></p> 
			<input type="password" id="repassword" name="repassword" pattern="[A-z0-9]{8,16}">  -->
        
            <fieldset>
                 <label>Birthday</label>
                  <label class="month"> 
                  <select class="select-style" name="BirthMonth">
                  <option value="">Month</option>
                  <option  value="01">January</option>
                  <option value="02">February</option>
                  <option value="03" >March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12" >December</option>
                  </label>
                 </select>    
                <label>Day<input class="birthday" maxlength="2" name="BirthDay"  placeholder="Day" pattern="d{2}"></label>
                <label>Year <input class="birthyear" maxlength="4" name="BirthYear" placeholder="Year" pattern="d{2}"></label>
            </fieldset>
  
            <select class="select-style gender" name="sex" required>
            <option value="m">male</option>
            <option value="f">female</option>
            <option value="p">private</option>
            <option value="o">Other</option>
            </select><br><br>
            
            <p class="contact"><label for="phone">phone (Mobile/home)</label></p> 
            <input id="phone" name="phone" placeholder="phone number" required pattern="[0-9]{10}" type="text"> <br>
            
			<input class="buttom" name="submit" id="submit" tabindex="5" value="Sign me up!" type="submit"> 	 
		</form> 
	</div>      
</div>

</body>
</html>