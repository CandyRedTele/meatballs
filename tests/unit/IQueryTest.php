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
                                    . " FROM reservation WHERE r_id = (select max(r_id) from reservation);");
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
        $select = new CustomQuery("select name, title from localstaff natural join staff where name='".$name."';");
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
        $select = new CustomQuery("select name, title from admin natural join staff where name='".$name."';");
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
        $select = new CustomQuery("select name from staff where name='phpunit';");
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
