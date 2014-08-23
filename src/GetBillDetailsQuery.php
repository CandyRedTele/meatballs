<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class GetBillDetailsQuery 
 *
 * PURPOSE : Get the details of a specified `b_id`
 *                  -> returns columns "mitem_id, name, category";
 *
 *************************************************************************/
include_once("IQuery.php");
class GetBillDetailsQuery extends IQuery
{
    private $b_id;
    private $columns;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct 
    *
    *-----------------------------------------------------------*/
    public function __construct()
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");

        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $fct = "__construct_" . $argc)) { 
            call_user_func_array(array($this, $fct), $args);
        }
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct_1 
    *
    *-----------------------------------------------------------*/
    private function __construct_1($b_id) 
    {
        $this->b_id = $b_id;
        $this->columns = "mitem_id, name, category, price";
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString 
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        return  "SELECT " . $this->columns
                . " FROM bill"
                . " NATURAL JOIN  bill_has_menu_item NATURAL JOIN menu_item"
                . " WHERE b_id=" . $this->b_id . ";";
    }
}
?>
