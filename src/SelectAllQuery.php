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

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function getQueryString()
    {
        return "SELECT * FROM " . $this->table . ";";
    }
}
?>
