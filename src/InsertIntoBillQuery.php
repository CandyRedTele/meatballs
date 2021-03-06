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
    private $g_id;
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
        $this->tables['golden_has_bills'] = 'golden_has_bills';

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
        $this->init($f_id, $menu_item_array, null); 
    }

    private function __construct_3($f_id, $menu_item_array, $g_id)
    {
        $this->init($f_id, $menu_item_array, $g_id); 
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : init
    *
    *-----------------------------------------------------------*/
    private function init($f_id, $menu_item_array, $g_id)
    {
        $this->f_id = $f_id;
        $this->menu_item_array= $menu_item_array;
        $this->g_id = $g_id;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : setColumnsAnsValues
    *
    *-----------------------------------------------------------*/
    private function setColumnsAnsValues()
    {
        /* bill */
        $this->columns['bill'] = "(";
        $this->values['bill'] = "(";

        if (isset($this->f_id)) {
            $this->columns['bill'] .= "f_id";
            $this->values['bill'] .= "'$this->f_id'";
        }

        $this->columns['bill'] .= ")";
        $this->values['bill'] .= ")";



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



        /* golden_has_bills */
        $this->columns['golden_has_bills'] = "(";
        $this->values['golden_has_bills'] = "(";

        if (isset($this->g_id)) {
            $this->columns['golden_has_bills'] .= "g_id";
            $this->values['golden_has_bills'] .= "'$this->g_id'";
        }

        $this->columns['golden_has_bills'] .= ", b_id";
        $this->values['golden_has_bills'] .= ", (SELECT MAX(b_id) FROM ".$this->tables['bill'].")";

        $this->columns['golden_has_bills'] .= ")";
        $this->values['golden_has_bills'] .= ")";
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

        if (isset($this->g_id))
        {
            $query .= " INSERT INTO ".$this->tables['golden_has_bills']." ".$this->columns['golden_has_bills']
                     ." VALUES " . $this->values['golden_has_bills']. ";";
        }


        if (isset($this->menu_item_array) 
                        && count($this->menu_item_array) > 0) 
        {
            $query .= " INSERT INTO ".$this->tables['bill_has_menu_item']." ".$this->columns['bill_has_menu_item']
                     ." VALUES " . $this->values['bill_has_menu_item']. ";";
        }

        $query .= "SELECT MAX(b_id) FROM " . $this->tables['bill'] . ";";

        $query .= "COMMIT;";
        return $query;
    }
}
?>
