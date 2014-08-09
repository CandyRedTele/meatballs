<!-- Testing the backend --> 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>BackEnd-Development</title>
    <meta charset="utf-8">
</head>
<body>

    <?php
        error_reporting(E_ALL);
        //echo $_SERVER['DOCUMENT_ROOT'] . "/comp353-project/src";
        set_include_path($_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src');
        include_once("TestQuery.php"); 
        include_once("CustomQuery.php"); 
        include_once("Logger.php"); 
        include_once("SelectAllQuery.php");
        include_once("MeatballsUser.php");
        include_once("InsertIntoGoldenQuery.php");
    ?> 

    <?php
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");

        $query2 = new TestQuery();
        $query1 = new CustomQuery("SELECT customerName from customers");
        $query3 = new SelectAllQuery("customers");

        //$result = $query1->execute();
        //$result = $query2->execute();
        $result = $query3->execute();

        if ($result) {
            while($row = mysqli_fetch_row($result)) 
            {
                foreach ($row as $field) {
                    echo $field . " ";
                    
                }

                //echo $row['customerName'];
                //var_dump($row);
                echo "<br>" ;
            }
        }
        //*/

        $staff_id = "9";
        $access_level = MeatballUser::getAccessLevel($staff_id);

        if ($access_level) {
            echo "access level  $access_level";
        }

        $insert = new InsertIntoGoldenQuery('Joseph', 'Martineau', 'M', 'jos@msn.com', '123-123-1234');
        $insert->execute();
    ?>


</body>
</html>
