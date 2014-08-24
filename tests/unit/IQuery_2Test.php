<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Ryan
 *
 * NAME : IQuery_2Test 
 *
 **************************************************************************/
include_once("src/IncludeAllQueries.php");
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
       
        // 1. Create a new instance of GetAccessLevelQuery based on staff id.
        $access_query = new GetAccessLevelQuery($staff_id);
        $result = $access_query->execute();

        if(!$result) {
            $this->fail('execute failed');
        }

        // 2. Retreive the expected access level.
        $row = mysqli_fetch_assoc($result);
        $access = $row['access_level'];

        // 3. Get a value to compare.
        $select = new CustomQuery("select access_level from access_level natural join staff where staff_id='".$staff_id."';");
        $result = $select->execute();

        if (!$result) {
            mysqli_free_result($result);
            $this->assertTrue(false); // Fail it.
        }

        $expected = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        // 4. assert
        $this->assertEquals($expected['access_level'], $access);

    }
}
?>
