<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class CustomQuery 
 *
 * PURPOSE : Executes the Query String passed to the constructor
 *
 *************************************************************************/
include_once("IQuery.php");
class CustomQuery extends IQuery
{
    private $query_string;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct 
    *
    *-----------------------------------------------------------*/
    public function __construct($query_string)
    {
		parent::__construct();
        $this->query_string = $query_string;
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString 
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        return $this->query_string;
    }
}
?>
