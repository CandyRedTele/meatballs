<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : GetBillTotalQuery 
 *
 *
 *************************************************************************/
include_once("IQuery.php");
class GetBillTotalQuery extends IQuery
{
    private $tables;
    private $columns;
    private $values;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct 
    *
    *-----------------------------------------------------------*/
    public function __construct($staff_id)
    {
		parent::__construct();

        $this->tables['bill'] = 'bill';
        $this->columns = 'b_id, sum(price) as total, date';

        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
        }
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : overloaded contructor
    *
    *-----------------------------------------------------------*/
    private function __construct_1($b_id)
    {
        $this->init($b_id);
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : init
    *
    *-----------------------------------------------------------*/
    private function init($b_id)
    {
        $this->b_id = $b_id;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString 
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        $query =    " SELECT " . $this->columns  
                  . " FROM " . $this->tables['bill'] 
                  . " NATURAL JOIN bill_has_menu_item "
                  . " NATURAL JOIN menu_item "
                  . " WHERE b_id = " . $this->b_id . "; ";

        return $query;
    }
}
?>
