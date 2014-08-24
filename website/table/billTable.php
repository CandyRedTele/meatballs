<?php 
	error_reporting(E_ALL);
	include_once("../../src/SetPath.php");
	set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("IncludeAllQueries.php"); 

	session_start();
?>
<html>
<head>
	<title>Bill</title>
  <meta http-equiv="CONTENT-TYPE" content="TEXT/HTML; charset=utf-8">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  
  <link rel="stylesheet" href="stylesheet4.css" type="text/css">
  
  <script type="text/javascript" src="../js/domsort.js"></script>
<script type="text/javascript" src="../js/ajaxHelper.js"></script>
<link rel="stylesheet" href="../css/domsort.css" type="text/css" />
<link rel="stylesheet" href="../css/stylesheet6.css" type="text/css" />
<style>label {width:33%;}	#formContainer{width:75%;}</style>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<body>
<?php include_once("navigationBAR.php"); ?>

<!--                                   INFORMATION TABLES                                          -->


<table align="center" border="0" cellpadding="0" cellspacing="0" width="790" id="innerTABLE">
   <tr>
     <td width="20px">&nbsp;</td>
      <td colspan="2"><div class="ueberschrift">BILL</div></td>
      <td width="20px">&nbsp;</td>
   </tr>
   <tr>
   <td width="20px">&nbsp;</td>
      <td class="obenlinks"><img width="100%" height="100%"src="../img/welcomeALT1.jpg"/></td>
<?php echo '
      <td class="oben" valign="top"><div id="textobengross">'.$_SESSION['location'].'</div><div id="textobenklein">Here is your menu</div></td>'?>
      <td width="15px">&nbsp;</td>
   </tr>
   <tr> <td width="20px">&nbsp;</td>
     <td valign="top" class="links">

		</td>
		<td class="hauptfenster" valign="top">

		<h1>Create Bill</h1>
            <form action="add-bill.php" method="post" class="add-new-task">

                <span>Golden number</span><input type="text" name="gold_num">
                <input type="submit">
			</form>

<?php echo "<section><h1>Menu items in ".$_SESSION['location']."</h1>" ?>
    <div id="thelist"><ul id="control">
            <li class="button" onclick="sortTable(0, 'num', '1');" ondblclick="sortTable(0, 'num', '-1');">ID</li>
            <li class="button" onclick="sortTable(1, 'str', '1');" ondblclick="sortTable(1, 'str', '-1');">category</li>
			<li class="button" onclick="sortTable(2, 'str', '1');" ondblclick="sortTable(2, 'str', '-1');">name</li>
			<li class="button" onclick="sortTable(4, 'str', '1');" ondblclick="sortTable(4, 'str', '-1');">price</li>
            <li></li></ul>

    <?php
		if($_SESSION['accesslv']==6)
            $query = new CustomQuery("select mitem_id, category, name, price from menu_item natural join menu natural join facility where location='".$_SESSION['location']."'");

		if (!is_null($query))
			$result = $query->execute();


		if(isset($result))
			while($row = mysqli_fetch_row($result))
		{
				echo "<ul >";
				foreach ($row as $field) {
					echo "<li>" . $field . "</li>";
				}
				echo "<li><a class='addtobill' id='".$row[0]."' href=#>ADD</a></li></ul>";
			}
?>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $('.addtobill').click(function(e) {
            e.preventDefault();//in this way you have no redirect
            var new_task = $(this).attr('id');
            if(new_task != '') {
                $.post('add-bill-item.php', { task: new_task }, function( data ) {
                    $(data).prependTo('.add-new-task').hide().fadeIn();
                });
            }
        });

    });
</script>
</head>





</div>
</section>
</div>
<!--                                   supply LIST END HERE                                          -->
	  </td>
        <td width="10px">&nbsp;</td>
   </tr>
</table>

<!--									END OF INFORMATION TABLE								-->
<?php include_once("navigationBAR2.php"); ?>

</body>
</html>

