<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class SelectAllQuery 
 *
 * PURPOSE : SELECT * FROM $table
 *
 *************************************************************************/
include_once("IQuery.php");
class SelectAllQuery extends IQuery
{
    private $table;
    private $logger;

    public function __construct($table)
    {
		parent::__construct();
		$this->logger = Logger::getSingleInstace();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
		$this->logger->write("\t? include path : " . get_include_path());
        $this->table = $table;
    }

    public function getQueryString()
    {
        return "SELECT * FROM " . $this->table . ";";
    }
}
?>
