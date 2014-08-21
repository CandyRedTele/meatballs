<?php
include_once("src/IncludeAllQueries.php");
include_once("src/CustomQuery.php");
include_once("src/InsertIntoStaffQuery.php");
putenv("DOCUMENT_ROOT='/home/jamg85/git");

/**
 * @requires extension mysqli
  */
class IQuery_2Test extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        if (!extension_loaded('mysqli')) {
            $this->markTestSkipped('The MySQLi extension is not available.'); // Does the same job as the '@requires extension mysqli
        }
    }


    public function testGetAccesLevel_success()
    {
        $staff_id = 12;
        $table = 'access_level';
        $column = 'access_level';

        // 1. Create a new instance of GetAccessLevelQuery based on staff id.
        $access = new GetAccessLevelQuery($staff_id);

            if(!$access->execute()) {
            $this->fail('execute failed');
        }

        // 2. Retreive the access level value.
        $select = new CustomQuery("select access_level from access_level  natural join staff where staff_id='".$staff_id."';");
        $result = $select->execute();

        if (!$result) {
            mysqli_free_result($result);
            $this->assertTrue(false); // Fail it.
        }

        $actual = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        // 3. assert
        
        $this->assertEquals($column, $actual['access_level']);
        
        //$this->fail("TODO");

    }
/*
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

    public function testGetAccessLevelQuery()
    {
        $this->markTestSkipped('TODO');
    }
    //*/
}
?>
