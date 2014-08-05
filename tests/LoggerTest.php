<?php
include_once("src/Logger.php");
include_once("src/DataAccess.php");
class LoggerTest extends PHPUnit_Framework_TestCase
{
    public function testSample()
    {
        Logger::getSingleInstace("src/log");
        $this->fail("TODO");
    }

}
?>
