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

    public function __construct($query_string)
    {
        $this->query_string = $query_string;
    }

    public function getQueryString()
    {
        return $this->query_string;
    }
}
?>
