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
        $this->columns = 'b_id, date';
        $this->total = ' SUM(price) as total ';

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
        $check_if_golden = new CustomQuery('SELECT g_id FROM golden_has_bills WHERE b_id = ' . $this->b_id . ';');
        $result = $check_if_golden->execute();

        if ($result->num_rows > 0) {
            $this->total = ' CAST((SUM(price) * 0.9) as DECIMAL(15,2)) as total ';
        }


        $query =    " SELECT " . $this->columns  . ", " . $this->total
                  . " FROM " . $this->tables['bill'] 
                  . " NATURAL JOIN bill_has_menu_item "
                  . " NATURAL JOIN menu_item "
                  . " WHERE b_id = " . $this->b_id . "; ";

        return $query;
    }
}
?>
