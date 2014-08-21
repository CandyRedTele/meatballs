function validate(){
var val1=document.form.firstN.value;
var val2=document.form.lastN.value;
var val3=document.form.pswd.value;
var val4=document.form.repswd.value;
var val5=document.form.email.value;

var patt1=/[A-z]{2,20}/;
var patt2=/[A-z0-9]{8,30}/;
var patt3=/[A-z_0-9]+@(hotmail|yahoo|gmail).(com|ca)/;
var patt4=/(\d{0,1}\-(800)\-){0,1}\d{3}\-\d{3}\-\d{4}$/;
if( val1 =="" || !patt1.test(val1)){	
	alert("Please enter your First Name again correctly!"+val1);
	document.form.firstN.focus();
	return false;
}
else if( val2 =="" || !patt1.test(val2)){	
	alert("Please enter your Last Name again correctly!"+val2);
	document.form.lastN.focus();
	return false;
}
else if( val3 =="" || !patt2.test(val3)){	
	alert("Please enter at least 6 characters and maximum 30 characters!"+val3);
	document.form.pswd.focus();
	return false;
}
else if( val3!=val4 ){	
	alert("The passwords are not the identical!?, please enter again"+val4);
	document.form.repswd.focus();
	return false;
}
else if( val5 =="" || !patt3.test(val5)){	
	alert("The email address format is wrong, please enter again!"+val5);
	document.form.email.focus();
	return false;
}
}