<!-- Testing the backend --> 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>BackEnd-Development</title>
    <meta charset="utf-8">
</head>
<body>
    <p><b>Test Site :</b></p>

    <?php

        function getSrcPath()
        {
            $root =  $_SERVER['DOCUMENT_ROOT'];

            if (strrpos($root, '/') == strlen($root) - 1) 
            {
                $root = substr($root, 0, -1); // remove trailing '/' (for windows)
            }

            return $root."/comp353-project/src"; 
        }

        error_reporting(E_ALL);
        echo "<p><b>include path</b> : ". getSrcPath(). "</p>";
        set_include_path(getSrcPath());
        include_once("IncludeAllQueries.php");
        include_once("TestQuery.php"); 
        include_once("Logger.php"); 
        include_once("MeatballsUser.php");
    ?> 

    <?php
        $logger = Logger::getSingleInstace();
        $logger->write("HelloLogger!");

        $query2 = new TestQuery();
        $query1 = new CustomQuery("SELECT customerName from customers");
        $query3 = new SelectAllQuery("staff");

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
        $insert_staff = new InsertIntoStaffQuery('Joseph Martineau');
        $insert_staff->execute();


        $staff_id = "10"; 
        $locationQuery = new GetLocationQuery($staff_id);
        $result = $locationQuery->execute();
        $location = mysqli_fetch_row($result)[0];
        echo "<br><br>location of staff_id $staff_id is : " . $location;
    ?>


</body>
</html>
