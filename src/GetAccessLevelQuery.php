<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class GetAccessLevelQuery
 *
 * PURPOSE : Get the access level related to a specific staff id.
 *
 *************************************************************************/
include_once("IQuery.php");
class GetAccessLevelQuery extends IQuery
{
    private $table;
    private $staff_id;
    private $column;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct 
    *
    *-----------------------------------------------------------*/
    public function __construct($staff_id)
    {
		parent::__construct();
        $this->staff_id = $staff_id;

        $this->table = 'access_level';
        $this->column = 'access_level'; // yes, same name as the table...
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString 
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        return    "SELECT " . $this->table
                . " FROM " . $this->column 
                . " NATURAL JOIN staff "
                . " WHERE staff_id= " . $this->staff_id;
    }
}
?>
