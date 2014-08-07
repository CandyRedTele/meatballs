<?php
error_reporting(E_ALL);
include_once("src/Logger.php");
include_once("src/MySqlConnection.php");
class LoggerTest extends PHPUnit_Framework_TestCase
{
    public function testLogger_oneArgs_success()
    {
        $path = "src/log";
        $logger = Logger::getSingleInstace($path);

        $expected = "PHPUnit - Test";

        $logger->write($expected);

        $fd = fopen($path,'r');
        

        $actual= fread($fd, strlen($expected));

        $this->assertEquals($expected, $actual);
    }

    public function testLogger_noArgs_success()
    {
        $path = "src/log";
        $logger = Logger::getSingleInstace();

        $expected = "PHPUnit - Test";

        $logger->write($expected);

        $fd = fopen($path,'r');
        

        $actual= fread($fd, strlen($expected));

        $this->assertEquals($expected, $actual);
    }

}
?>
