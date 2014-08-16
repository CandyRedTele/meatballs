<?php
include_once("src/ConfigLoader.php");
class ConfigLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testSample()
    {
        $loader = new ConfigLoader('./src/project.config.xml', "utest");
        $this->assertEquals($loader->getHost(), 'localhost');
        $this->assertEquals($loader->getUsername(), 'root');
        $this->assertEquals($loader->getPassword(), '');
        $this->assertEquals($loader->getDatabase(), 'classicmodels');
    }
}
?>
