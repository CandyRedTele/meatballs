<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : IQueryTest 
 *
 * PURPOSE : Test all IQuery's
 *
 **************************************************************************/
include_once("src/IncludeAllQueries.php");

/**
 * @requires extension mysqli
  */
class IQueryTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        if (!extension_loaded('mysqli')) {
            $this->markTestSkipped('The MySQLi extension is not available.'); // Does the same job as the '@requires extension mysqli
        }
    }

    public function test_GetBillTotalQuery_success()
    {
        $this->markTestSkipped('TODO');
    }

    public function test_InsertIntoBillQuery_success()
    {
        $this->markTestSkipped('TODO');
    }

    public function test_GetTrainingQuery()
    {
        $staff_id = 200;
        $query = new CustomQuery(" SELECT training FROM admin natural JOIN staff WHERE staff_id=" . $staff_id .";");
        $result = $query->execute();

        if ($result->num_rows > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            $actual_training = $row['training'];
        } else {
            $query = new CustomQuery(" SELECT training FROM localstaff natural JOIN staff WHERE staff_id=" . $staff_id .";");
            $result = $query->execute();
            $row = mysqli_fetch_assoc($result);
            $actual_training = $row['training'];
        }
        
        $query = new GetTrainingQuery($staff_id);
        $result = $query->execute();

        if (!$result) {
           $this->fail("no result"); 
        }

        $row = mysqli_fetch_assoc($result);


        $this->assertEquals($actual_training, $row['training']);
    }

    public function test_GetSalaryQuery()
    {
        $staff_id = 200;

        $query = new CustomQuery(" SELECT staff_id, title, base, exp_rate, overtime FROM wage natural JOIN staff WHERE staff_id=" . $staff_id .";");
        $result = $query->execute();

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);

            $actual_title = $row['title'];
            $actual_base = $row['base'];
            $actual_exp_rate = $row['exp_rate'];
            $actual_overtime = $row['overtime'];
        } else {
            $query = new CustomQuery(" SELECT staff_id, title, base, exp_rate, train_rate,  FROM pay natural JOIN staff WHERE staff_id=" . $staff_id .";");
            $result = $query->execute();

            $row = mysqli_fetch_assoc($result);
            $actual_title = $row['title'];
            $actual_base = $row['base'];
            $actual_exp_rate = $row['exp_rate'];
            $actual_train_rate = $row['train_rate'];
        }


        $query = new GetSalaryQuery($staff_id);
        $result = $query->execute();

        if (!$result) {
            $this->fail('result is null');
        }

        $row = mysqli_fetch_assoc($result);

        $this->assertEquals($actual_title, $row['title']);
        $this->assertEquals($actual_base, $row['base']);
        $this->assertEquals($actual_exp_rate, $row['exp_rate']);
        if (isset($actual_overtime)) {
            $this->assertEquals($actual_overtime, $row['overtime']);
        } else {
            $this->assertEquals($actual_train_rate, $row['train_rate']);
        }
    }
    
    public function testInsertIntoReservationQuery_success()
    {
        $name = 'Jean-Paul 666';
        $time =  date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, 1998));
        $nb_of_seats = 666;
        $event_type  = 'french ballet';
        $f_id = 6;

        // 1. Insert some values.
        $insert= new InsertIntoReservation($name, $time, $nb_of_seats, $event_type, $f_id);

        if(!$insert->execute()) {
            $this->fail('execute failed');
        }

        // 2. Retreive those values.
        $select = new CustomQuery("select name, time, nb_of_seats, event_type, f_id" 
                                    . " FROM reservation WHERE r_id = (select max(r_id) FROM reservation);");
        $result = $select->execute();
        
        if (!$result) {
            $this->assertTrue(false); // Fail it.
        }

        $actual = mysqli_fetch_assoc($result);

        // 3. assert
        $this->assertEquals($name, $actual['name']);
        $this->assertEquals($time, $actual['time']);
        $this->assertEquals($nb_of_seats, $actual['nb_of_seats']);
        $this->assertEquals($event_type, $actual['event_type']);
        $this->assertEquals($f_id,       $actual['f_id']);

    }


    public function testInsertIntoStaffQuery_localstaffGetsUpdated()
    {
        $name = 'Jean-Paul III';
        $title = 'cook';
        $f_id = 1;

        // 1. Insert some values.
        $insert= new InsertIntoStaffQuery($name, 
                                            '224 rue XYZ', 
                                            '819-789-1234', 
                                            '123456789', 
                                            $title, 
                                            $f_id);
        if(!$insert->execute()) {
            $this->fail('execute failed');
        }

        
        // 2. Retreive those values.
        $select = new CustomQuery("select name, title FROM localstaff natural JOIN staff WHERE name='".$name."';");
        $result = $select->execute();
        
        if (!$result) {
            mysqli_free_result($result);
            $this->assertTrue(false); // Fail it.
        }


        $actual = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        // 3. assert
        $this->assertEquals($name, $actual['name']);
        $this->assertEquals($title, $actual['title']);

    }


    public function testInsertIntoStaffQuery_adminGetsUpdated()
    {
        $name = 'Jean-Paul II';
        $title = 'ceo';

        // 1. Insert some values.
        $insert= new InsertIntoStaffQuery($name, 
                                            '224 rue XYZ', 
                                            '819-789-1234', 
                                            '123456789', 
                                            $title, 
                                            'Montreal');

        if(!$insert->execute()) {
            $this->fail('execute failed');
        }

        
        // 2. Retreive those values.
        $select = new CustomQuery("select name, title FROM admin natural JOIN staff WHERE name='".$name."';");
        $result = $select->execute();
        
        if (!$result) {
            mysqli_free_result($result);
            $this->assertTrue(false); // Fail it.
        }


        $actual = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        // 3. assert
        $this->assertEquals($name, $actual['name']);
        $this->assertEquals($title, $actual['title']);

    }


    public function testCustomQuery()
    {
        $expected = 'phpunit';

        // 1. Insert some values.
        $insert = new CustomQuery("insert into staff (name) values ('" . $expected . "');");

        if (!($result = $insert->execute())) {
            $this->fail('insertion failed');    
        }
        
        // 2. Retreive those values.
        $select = new CustomQuery("select name FROM staff WHERE name='phpunit';");
        $result = $select->execute();
        
        if (!$result) {
            $this->fail('result is null');
        }

        $actual = mysqli_fetch_row($result);

        // 3. assert
        $this->assertEquals($expected, $actual[0]);

        mysqli_free_result($result);
    }

    public function test_GetAccessLevelQuery_success()
    {
        $this->markTestSkipped('TODO');
    }
}
?>
