<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class InsertIntoBill
 *   
 * PURPOSE : Insert in `bill` and add the specified `menu_item` to the table
 *              `bill_has_menu_item`
 *
 *  	 
 **************************************************************************/
include_once("IQuery.php");
class InsertIntoBillQuery extends IQuery
{
    private static $admin = array('ceo', 'cto', 'cfo');

    private $tables;
    private $columns;
    private $values;

    /* bill */
    private $f_id;

    private $menu_item_array;


   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct
    *
    *-----------------------------------------------------------*/
    public function __construct()
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
        $this->tables['bill'] = 'bill';
        $this->tables['bill_has_menu_item'] = 'bill_has_menu_item';

        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
            $this->setColumnsAnsValues();
        }

    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : overloaded contructor
    *
    *-----------------------------------------------------------*/
    private function __construct_2($f_id, $menu_item_array)
    {
        $this->init($f_id, $menu_item_array); 
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : init
    *
    *-----------------------------------------------------------*/
    private function init($f_id, $menu_item_array)
    {
        $this->f_id = $f_id;
        $this->menu_item_array= $menu_item_array;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : setColumnsAnsValues
    *
    *-----------------------------------------------------------*/
    private function setColumnsAnsValues()
    {
        /* open */
        $this->columns['bill'] = "(";
        $this->values['bill'] = "(";


        /* bill */
        if (isset($this->f_id)) {
            $this->columns['bill'] .= "f_id";
            $this->values['bill'] .= "'$this->f_id'";
        }

        /* bill_has_menu_item */
        $this->columns['bill_has_menu_item'] = "(";
        $this->columns['bill_has_menu_item'] .= "b_id";
        $this->columns['bill_has_menu_item'] .= ", mitem_id";
        $this->columns['bill_has_menu_item'] .= ")";


        if (isset($this->menu_item_array) && count($this->menu_item_array) > 0) 
        {
            $this->values['bill_has_menu_item'] = "(";
            $this->values['bill_has_menu_item'] .= "(SELECT MAX(b_id) FROM ".$this->tables['bill'].")";
            $this->values['bill_has_menu_item'] .= ", ". $this->menu_item_array[0];
            $this->values['bill_has_menu_item'] .= ")";

            for ($i=1; $i<count($this->menu_item_array); $i++) {
                $this->values['bill_has_menu_item'] .= ", (";
                $this->values['bill_has_menu_item'] .= "(SELECT MAX(b_id) FROM ".$this->tables['bill'].")";
                $this->values['bill_has_menu_item'] .= ", " . $this->menu_item_array[$i];
                $this->values['bill_has_menu_item'] .= ")";
            }
        }


        /* close */
        $this->columns['bill'] .= ")";
        $this->values['bill'] .= ")";

    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        $query = "START TRANSACTION;\n";
        $query .= "INSERT INTO " . $this->tables['bill'] . " ". $this->columns['bill']
                   . " VALUES " . $this->values['bill'] . ";";


        if (isset($this->menu_item_array) 
                        && count($this->menu_item_array) > 0) 
        {
            $query .= " INSERT INTO ".$this->tables['bill_has_menu_item']." ".$this->columns['bill_has_menu_item']
                     ." VALUES " . $this->values['bill_has_menu_item']. ";";
        }

        $query .= "COMMIT;";
        return $query;
    }
}
?>
