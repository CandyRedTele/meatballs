<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
	<meta charset="utf-8"/>
	<title>Registration Form</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet3.css"/>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
		<?php	?>
</head>
<body>
//<script type="text/javascript" src="js/javascript2.js"></script>

<div id="RegisF">
<form action="php/register_valid.php" name="form" id="frm" method="post" onsubmit="return(validate());" enctype="multipart/form-data">
<div id="formH">Registration</div>

<div class="fields"><span class="rq">*</span><div class="fieldT">First Name:</div>
<div><input type="text" id="fn" name="firstN" size="50" maxlength="20"/></div>
<p class="hint">15 characters maximum</p>
</div>

<div class="fields"><span class="rq">*</span><div class="fieldT">Last Name:</div>
<div><input type="text" id="ln" name="lastN" size="50" maxlength="20" /></div>
<p class="hint">15 characters maximum</p>
</div>

<div class="fields"><span class="rq">*</span><div class="fieldT">Password:</div>
<div><input type="password" id="pw" name="pswd" size="50" placeholder="please enter at least 8 characters"/></div>
</div>

<div class="fields"><span class="rq">*</span><div class="fieldT">Password confirm:</div>
<div><input type="password" id="rp" name="repswd" size="50" placeholder="please re-enter your password"/></div>
<p class="hint">please retype the password</p>
</div>

<div class="fields" id="gender">
Male <input type="radio" name="gender" value="male" />
Female <input type="radio" name="gender" value="female" />
</div>

<div class="fields"><span class="rq">*</span><div class="fieldT">e-mail:</div>
<div><input type="text" id="em" name="email" size="50" placeholder="please enter a valid e-mail"/></div>
</div>

<div class="fields"><div class="fieldT">Phone Number:</div>
<div><input type="text" id="pn" name="phoneN" size="50" /></div>
</div>

<div class="fields"><div class="fieldT">Profile picture</div>
<div><input type="file" id="img" name="file" accept="image/*" /></div>
</div>

<div>
<input type="submit" id="register" name="submission" value="submit!" />
<input type="button" id="" name="" value="Go back" onclick="window.history.back()"/>
</div>
</form>

<div id="rightSide">
	<img src="img/goldMember.jpg"/>
</div>

</body>
</html>