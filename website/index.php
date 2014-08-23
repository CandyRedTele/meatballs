<?php
    error_reporting(E_ALL);
    set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php");
	
    session_start();
	
    if(isset($_SESSION['views']))
        $_SESSION['views']=$_SESSION['views']+1;
    else
        $_SESSION['views']=1;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-CA" xml:lang="en-CA">
<head>
    <meta charset="utf-8"/>
    <title> Mamma Meatballs </title>
    <link href='http://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="client/css/stylesheet1.css" />
    <link href="client/css/hheader.css" rel="stylesheet" type="text/css" media="all" />
    <style type="text/css">* {margin: 0; padding: 0;}
    .menu {
        width: 80%;
        margin: 0 auto;
    }

    ul {
        list-style-type: none;
    }
    li h3 {
        text-decoration: none;
        color: #c74e3b;
        padding:8.5px 15px;
        text-align: center;
        font-size: 1.5em;

    }
    li h3 a{
        text-decoration: none;
        color: #c74e3b;

    }
    li {
      padding: 10px;
      float: left;
       /* or */
    display: inline-block;

    margin: 10px 0;
      overflow: auto;
    }

    li:hover {
      background:#333;
      cursor: pointer;
    }</style>
</head>
<body>
<div class="header-box"></div>

<div id="topleft">
    <div id="login_section">
    <?php
    if(isset($_SESSION['SID']))
        echo '<div id="templatemo_login_right">
                Hello ' . $_SESSION['name'] . '! </br> location: '. $_SESSION['location'] .' </br> access level: '. $_SESSION['accesslv'] .'
                <form id="form1" name="form1" method="post" action="logout.php">
                    <label><input type="submit" name="logout" id="logout" value="LOG OUT" /></label>
                </form>
            </div>';
    else echo '<div id="templatemo_login_left"><h3 class="heading3">STAFF LOGIN</h3></div>
                <div id="templatemo_login_right">

                <form id="form1" name="form1" method="post" action="login.php">
                    Staff ID:
                    <label><input type="text" name="username" id="username" placeholder="please enter s_id" required/></label>

                    <!--<br />Password: <label><input type="password" name="password" id="password" /></label><br />-->

                    <label><input type="submit" name="login" id="login" value="LOGIN" /></label>
                </form>
                </div>';
    ?>
    </div>
</div>
<div class="wrap">
    <div class="main">

        <div>
        <h1 class='logotitle'>Welcome to Mamma Meatballs!</h1>
        </div>
        <div class="heading3">
        <h3>Our Restaurants</h3>
        </div>

        <?php
        echo'
        <div class="menu">
                <ul>';
                $logger = Logger::getSingleInstance();
                $logger->write("HelloLogger!");

                $query = new CustomQuery("SELECT f_id, location from facility");

                if (!is_null($query))
                    $result = $query->execute();

                while($row = mysqli_fetch_row($result))
                {
                    echo
                    '<li>
                        <h3><a href="client/home.php?'.$row[0].'">'.$row[1].'</a></h3>
                    </li>' ;
                }

                    echo'</ul>
            </div>';
        ?>

    </div>
</div>
</body>
