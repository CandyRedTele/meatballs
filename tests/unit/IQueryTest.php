<?php
include_once("src/CustomQuery.php");
putenv("DOCUMENT_ROOT='/home/jamg85/git");

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

    public function testCustomQuery()
    {
        $expected = 'phpunit';

        // 1. Insert some values.
        $insert = new CustomQuery("insert into staff (name) values ('" . $expected . "')");
        $insert->execute();
        
        // 2. Retreive those values.
        $select = new CustomQuery("select name from staff where name='phpunit'");
        $result = $select->execute();
        
        if (!$result) {
            $this->assertTrue(false); // Fail it.
        }

        $actual = mysqli_fetch_row($result);

        // 3. assert
        $this->assertEquals($expected, $actual[0]);

        // 4. check logs

    }

    public function testGetAccessLevelQuery()
    {
        $this->markTestSkipped('TODO');
    }
}
?>
