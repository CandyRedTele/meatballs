<?
    include_once("DataAccess.php");

    class IQuery    // TODO check if interface exist in php
    {
        static protected $mysql;  // only one connection to avoid connect/unconnect multiple times

        /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
         * 
         * NAME : __construct, no arguments 
         *
         *----------------------------------------------------------------*/
        public function __construct() 
        {
            if (!isset(self::$mysql)) {
                self::$mysql = new MySqlConnection('localhost', 'root', '',  'classicmodels');
            } 
        }

        /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
         * 
         * NAME : execute 
         *
         * PURPOSE : To be overriden by subclasses.
         *
         *----------------------------------------------------------------*/
        public function execute()
        {
            $query_string = __CLASS__ . "::getQueryString()";
            $result = self::$mysql->execute($query_string);

            return $result;
        }
    }
?>
