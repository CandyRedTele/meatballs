<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class GetAccessLevelQuery.php 
 *
 * PURPOSE : Get the access level related to a specific staff id.
 *
 *************************************************************************/
include_once("IQuery.php");
class GetAccessLevelQuery extends IQuery
{
    private $staff_id;

    public function __construct($staff_id)
    {
		parent::__construct();
        $this->staff_id = $staff_id;
    }

    public function getQueryString()
    {
        return "SELECT access_level FROM staff WHERE staff_id= " . $this->staff_id;
    }
}
?>
