<?php
include_once("DataAccess.php");
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class IQuery 
 *
 *************************************************************************/
abstract class IQuery    // TODO check if interface exist in php
{
    static protected $mysql;  // only one connection to avoid connect/unconnect multiple times

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : __construct, no arguments 
     *
     *-----------------------------------------------------------*/
    public function __construct() 
    {
        if (!isset(self::$mysql)) {
            self::$mysql = new MySqlConnection('localhost', 'root', '',  'classicmodels');
        } 
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : getQueryString 
     *
     * PURPOSE : To be overriden by subclasses.
     *
     * RETURNS : The query string to be executed by execute()
     *
     *-----------------------------------------------------------*/
    abstract protected function getQueryString();


    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : execute 
     *
     * PURPOSE : Execute the query returned by getQueryString()
     *
     *-----------------------------------------------------------*/
    public function execute()
    {
        $result = self::$mysql->execute($this->getQueryString());

        return $result;
    }
}
?>
