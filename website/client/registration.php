<?php
    error_reporting(E_ALL);
    set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
    include_once("IncludeAllQueries.php");
    $parameter = $_SERVER['QUERY_STRING'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mamma Meatballs</title>
<link rel="stylesheet" href="sticky-navigation.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

<link rel="stylesheet" href="css/stylesheet7.css" />

<link rel="stylesheet" href="css/recipeBOX.css" />
<style>.menu-items li{width:50%}</style>
  <link href="css/hheader.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<div class="header-box"></div>
<div class="wrap">
  <div class="total">
    <div class="header">
      <div class="header-bot">
        <div class="logo">
          <a href="index.php"><img width="300px" height="150px" src="img/welcomeALT1.jpg" alt=""/></a>
        </div>
      </div>
     </div>
    <div class="menu">
      <div class="top-nav">
        <ul>
        <?php
          echo '
          <li><a href="home.php?'.$parameter.'">HOME</a></li>
            <li><a href="reservation.php?'.$parameter.'">Reservation</a></li>
            <li><a href="aboutUS.php?'.$parameter.'">About Us</a></li>
            <li class="active"><a href="registration.php?'.$parameter.'">Golden member</a></li>';
        ?>
        </ul>
      </div>
    </div>
<div class="clear"></div>
<div class="main">
    <div class="section group">
        <div class="col span_2_of_contact">
          <div class="contact-form">
            <h3>Register as a Golden Member!</h3>
    	<?php
          echo '<form action="register_valid.php?'.$parameter.'" onsubmit="return(validate());" method="post" enctype="multipart/form-data">'?> 
        <div>
          <span><label>First Name</label></span>
          <span><input id="firstN" name="firstN" placeholder="First name" required pattern="[A-z]{2,20}" tabindex="1" type="text"></span>
        </div>
        <div>
          <span><label>Last Name</label></span>
          <span><input id="lastN" name="lastN" placeholder="Last name" required pattern="[A-z]{2,20}" tabindex="1" type="text"></span>
        </div>
        <div>
            <span><label>Phone Number</label></span>
            <input id="phone" name="phone" placeholder="###-###-####" required pattern="[0-9]{3}([0-9]{3}|\-[0-9]{3})([0-9]{4}|\-[0-9]{4})" type="text">
        </div>
        <div>
          <span><label>Email</label></span>
          <span><input id="email" name="email" placeholder="example@domain.com" required pattern="[A-z_0-9]+@[A-z]{2,20}.[A-z]{2,4}" type="email"></span>
        </div>
        <div>
              <span><label>Birthday</label></span>
              <span>
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
                <label>Year <input class="birthyear" maxlength="4" name="BirthYear" placeholder="Year" pattern="d{4}"></label>
            </span>
          </div>
          <div>
                <span><label for="sex">gender</label></span>
                <span>
                    <select class="select-style gender" name="sex" required>
                      <option value="m">male</option>
                      <option value="f">female</option>
                      <option value="o">other</option>
                    </select>
                </span>
          </div>
         <div>
            <span><input type="submit" value="Submit"></span>
        </div>
        </form>
          </div>
          </div>
         <div class="clear"> </div>
      </div>
  </div>
</div>
</body>
</html>