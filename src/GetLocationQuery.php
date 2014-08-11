<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class GetLocationQuery 
 *
 * PURPOSE : Executes the Query String passed to the constructor
 *
 *************************************************************************/
include_once("IQuery.php");
class GetLocationQuery extends IQuery
{
    private $staff_id;

    public function __construct($staff_id)
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
		$this->logger->write("\t? include path : " . get_include_path());

        $this->staff_id= $staff_id;
    }

    public function getQueryString()
    {
        return "SELECT location FROM facility WHERE f_id = (SELECT f_id FROM staff NATURAL JOIN localstaff WHERE staff_id="
                    .$this->staff_id.");"; 
    }
}
?>
