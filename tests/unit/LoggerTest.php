<?php
error_reporting(E_ALL);
include_once("src/Logger.php");
include_once("src/MySqlConnection.php");
class LoggerTest extends PHPUnit_Framework_TestCase
{
    public function testLogger_oneArgs_success()
    {
        $path = "log/phpunit_log";
        $logger = Logger::getSingleInstace($path);

        $expected = "PHPUnit - Test1";

        $logger->write($expected);

        $fd = fopen($path,'r');
        

        while (($line = fgets($fd))) {
            $prev_line = chop($line); // find the last line in the file
        }

        $actual = $prev_line;

        $this->assertEquals($expected, $actual);
    }

    public function testLogger_noArgs_success()
    {
        $path = "log/phpunit_log";
        $logger = Logger::getSingleInstace();

        $expected = "PHPUnit - Test2";

        $logger->write($expected);

        $fd = fopen($path,'r');
        
        while (($line = fgets($fd))) {
            $prev_line = chop($line); // find the last line in the file
        }

        $actual = $prev_line;

        $this->assertEquals($expected, $actual);
    }

}
?>
