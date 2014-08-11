<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta charset="utf-8"/>
<title>Results</title>
</head>
<body>
<section id="form_area_reserv">
  <div id="shadow"></div>
  <article class="container">
    <div class=" four columns" id="top-msg">
      <div id="top-msg-wp">
        <h1>Reserve</h1>
        <h2>Complete the form</h2>
        <p>Lorem ipsum dolor sit amet, eu pri voluptaria efficiantur, quo ea feugiat legimus intellegebat. </p>
        <p><a class="fancybox"  href="img/demo-reservation.jpg">View a demo</a> screenshot of the email sent to the owner of the site.</p>
      </div>
    </div>
    <div class="twelve columns" >
      <form id="custom" action="reservation-send.php" method="POST" >
      
        <fieldset title="Step 1">
          <legend>Request</legend>
          <div class="five columns alpha">
            <label>Check in<a href="#" class="tooltip_1" title="Your tooltip">Info</a></label>
            <input type="date" name="check_in"/>
          </div>
          <div class="five columns omega">
            <label>Check out<a href="#" class="tooltip_1" title="Your tooltip">Info</a></label>
            <input type="date" name="check_out" />
          </div>
          <div class="five columns alpha " >
            <label>Number of guest</label>
              <select name="guest" >
              <option></option>
              <option>1 guest</option>
              <option>2 guest</option>
              <option>3 guest</option>
            </select>
          </div>
          <div class="five columns omega" >
            <label>Number of rooms</label>
            <select name="rooms" >
              <option></option>
              <option>1 room</option>
              <option>2 rooms</option>
              <option>3 rooms</option>
            </select>
          </div>
          <br class="clear">
        </fieldset><!-- End Step one -->
        
        <fieldset title="Step 2" >
          <legend>Personal info</legend>
          <div class="five columns alpha">
            <label>Name<a href="#" class="tooltip_1" title="Your tooltip">Info</a></label>
            <input type="text"  name="name" />
          </div>
          <div class="five columns omega">
            <label>Last name <a href="#" class="tooltip_1" title="Your tooltip">Info</a></label>
            <input type="text"  name="last_name" />
          </div>
          <div class="five columns alpha " >
            <label>Your Email <a href="#" class="tooltip_1" title="Your tooltip">Info</a></label>
            <input type="email"  name="email" />
          </div>
          <div class="five columns omega" >
            <label>Phone number <a href="#" class="tooltip_1" title="Your tooltip">Info</a></label>
            <input type="text"  name="phone_number" />
          </div>
          <br class="clear">
        </fieldset><!-- End Step two -->
        
        <fieldset title="Step 3">
          <legend>Message</legend>
          <label>Write your message</label>
          <textarea name="message" rows="5" cols="60"></textarea>
          <p><input name="terms" type="checkbox" value="Yes"><a class="fancybox fancybox.ajax" href="terms.txt">I accept terms and condition </a></p>
        </fieldset><!-- End Step three -->
        
        <input type="submit" class="finish" value="Finish!" />
      </form>
    </div>
  </article>
  <div id="shadow_2"></div>
</section><!-- End Form Area -->

</body>
</html>