<html>
<head>

<!--<link rel="stylesheet" href="searchB.css" type="text/css">-->
<style> #apple{float:left;} #apple form div a{float:none;}</style>
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<!-- <div class='search' id='search'>
<form action='".$_SESSION['referrer']."?search=XXX' id='searchthis' method='get'>
<input name='max-results' type='hidden' value='5'/>
translate 
<input id='search-box' name='q' placeholder='Search' size='25' type='text'/>
<input id='search-btn' type='submit' value='Search'/>
</form>
</div>-->
<div id="apple">
<?php if(preg_match("/employeeTable/", $_SESSION['referrer']))
		echo '<h3 id="sT"> Search by title </h3>';
	else if(preg_match("/supply/", $_SESSION['referrer']) || preg_match("/local/", $_SESSION['referrer']))
		echo '<h3 id="sT"> Search by name </h3>';
	else if(preg_match("/salesTable/", $_SESSION['referrer']))
		echo '<h3 id="sT"> Don\'t search for now </h3>';
	else if(preg_match("/vendorO/", $_SESSION['referrer']))
		echo '<h3 id="sT"> Don\'t search for now </h3>';?>
<form>
<input type="text" size="30" onkeyup="showResult(this.value)">
<div id="livesearch"></div>
</form>
<p id="stest"> </p>
</div>

<div id="testing"></div>

</body>
</html>