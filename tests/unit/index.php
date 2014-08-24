<!-- Testing the backend --> 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>BackEnd-Development</title>
    <meta charset="utf-8">
</head>
<body>
    <p><b><h2>Test Site</h2></b></p>

    <?php
        error_reporting(E_ALL);
        
        include_once("../../src/SetPath.php");

        include_once("IncludeAllQueries.php");  // <- +++++++ Include ALL the queries in one shot!
        include_once("TestQuery.php");          // <- ------- Test stuff = don't care
        include_once("Logger.php");             // <- +++++++ You want to LOG stuff???
        include_once("MeatballsUser.php");      // <- +++++++ Possibly useful too...
    ?> 

    <?php
        $logger = Logger::getSingleInstance();
        $logger->write("HelloLogger!");

        $query2 = new TestQuery();
        $query1 = new CustomQuery("SELECT customerName from customers");
        $query3 = new SelectAllQuery("staff");

        // just display what getSrcPath returned
        echo "<p><b>include path</b> : ". getSrcPath(). "</p>";

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

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * InsertIntoGoldenQuery 
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        $insert = new InsertIntoGoldenQuery('Joseph', 'Martineau', 'M', 'jos@msn.com', '123-123-1234');
        $insert->execute();

       $insert_staff = new InsertIntoStaffQuery('Joseph Martineau', 
                                                '224 rue XYZ', 
                                                '819-789-1234', 
                                                '123456789', 
                                                'ceo', 
                                                'Montreal',
                                                32,
                                                'Master Of The Street');
        $result = $insert_staff->execute();

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * GetLocationQuery
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        $staff_id = "10"; 
        $locationQuery = new GetLocationQuery($staff_id);
        $result = $locationQuery->execute();
        $location = mysqli_fetch_row($result)[0];
        echo "<br><br>location of staff_id $staff_id is : " . $location;

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * GetBillDetailsQuery
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        echo "<br><b> GetBillDetailsQuery(b_id) : <b><br>";
        $b_id = '1';
        $bill_details_query = new GetBillDetailsQuery($b_id);
        $result = $bill_details_query->execute();
        if ($result) {
            while($row = mysqli_fetch_row($result)) 
            {
                foreach ($row as $field) {
                    echo $field . " ";
                    
                }

                echo "<br>" ;
            }
        }

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * InsertIntoBill 
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        echo "<br><b> InsertIntoBillQuery (b_id) : <b><br>";
        $f_id = 1;
        $g_id = 30;
        $menu_item_array = array(1, 2, 3); 
        $query = new InsertIntoBillQuery($f_id, $menu_item_array, $g_id);
        $result = $query->execute();
        if ($result) {
            $row = mysqli_fetch_row($result); 
            echo "b_id :  " . $row[0];

            echo "<br>" ;
        }

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * GetBillTotalQuery 
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        $b_id = $row[0];
        echo "<br><b> GetBillTotalQuery (b_id) : <b><br>";
        $query = new GetBillTotalQuery($b_id);
        $result = $query->execute();
        if ($result) {
            while($row = mysqli_fetch_row($result)) 
            {
                foreach ($row as $field) {
                    echo $field . " ";
                }

                echo "<br>" ;
            }
        }

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * GetSalaryQuery
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        echo "<br><b> GetSalaryQuery(staff_id) : <b><br>";
        $staff_id = 39;
        $query = new GetSalaryQuery($staff_id);
        $result = $query->execute();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
            foreach ($row as $field) {
                echo $field. " ";
            }

            echo "<br>" ;
        }

       /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        * GetTrainingQuery
        * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
        echo "<br><b> GetTrainingQuery(staff_id) : <b><br>";
        $staff_id = 39;
        $query = new GetTrainingQuery($staff_id);
        $result = $query->execute();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
            foreach ($row as $field) {
                echo $field. " ";
            }
        }

    ?>


</body>
</html>
