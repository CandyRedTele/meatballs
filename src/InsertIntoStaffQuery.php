<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class InsertIntoStaffQuery
 *
 * PURPOSE : add one row to the 'staff' table;
 *   
 *   mysql> desc staff;
 *	 +--------------+-------------+------+-----+---------+----------------+
 *	 | Field        | Type        | Null | Key | Default | Extra          |
 *	 +--------------+-------------+------+-----+---------+----------------+
 *	 | staff_id     | int(11)     | NO   | PRI | NULL    | auto_increment |
 *	 | name         | varchar(45) | YES  |     | NULL    |                |
 *	 | address      | varchar(60) | YES  |     | NULL    |                |
 *	 | phone        | char(12)    | YES  |     | NULL    |                |
 *	 | ssn          | char(11)    | YES  |     | NULL    |                |
 *	 | title        | varchar(45) | NO   |     | NULL    |                |
 *	 +--------------+-------------+------+-----+---------+----------------+
 *
 * mysql> desc localstaff;
 * +------------+---------+------+-----+---------+-------+
 * | Field      | Type    | Null | Key | Default | Extra |
 * +------------+---------+------+-----+---------+-------+
 * | start_date | date    | YES  |     | NULL    |       |
 * | f_id       | int(11) | YES  | MUL | NULL    |       |
 * | staff_id   | int(11) | NO   | PRI | NULL    |       |
 * +------------+---------+------+-----+---------+-------+
 *
 * mysql> desc admin;
 * +----------+-------------+------+-----+----------+-------+
 * | Field    | Type        | Null | Key | Default  | Extra |
 * +----------+-------------+------+-----+----------+-------+
 * | staff_id | int(11)     | NO   | PRI | NULL     |       |
 * | location | varchar(55) | NO   | PRI | Montreal |       |
 * | yrs_exp  | int(11)     | YES  |     | NULL     |       |
 * | training | varchar(45) | YES  |     | NULL     |       |
 * +----------+-------------+------+-----+----------+-------+
 *	
 *	 
 **************************************************************************/
include_once("IQuery.php");
class InsertIntoStaffQuery extends IQuery
{
    private static $admin = array('ceo', 'cto', 'cfo');

    private $tables;
    private $columns;
    private $values;

    /* staff */
    private $name;
    private $address;
    private $phone;
    private $ssn;
    private $title;

    /* admin */
    private $location;

    public function __construct()
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
        $this->tables['staff'] = 'staff';
        $this->tables['admin'] = 'admin';
        $this->tables['localstaff'] = 'localstaff';

        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
            $this->setColumnsAnsValues();
        }

    }

    private function __construct_1($name)
    {
        $this->name = $name;
    }

    private function __construct_2($name, $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    private function __construct_3($name, $address, $phone)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
    }

    private function __construct_4($name, $address, $phone, $ssn)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;
    }
    
    private function __construct_5($name, $address, $phone, $ssn, $title)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;
        $this->title = $title;
    }

    private function __construct_6($name, $address, $phone, $ssn, $title, $location)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;
        $this->title = $title;
        $this->location = $location;
    }


    private function setColumnsAnsValues()
    {
        $this->columns['staff'] = "(";
        $this->values['staff'] = "(";

        $this->columns['admin'] = "(";
        $this->values['admin'] = "(";

        $this->columns['localstaff'] = "(";
        $this->values['localstaff'] = "(";

        $this->localstaff_col = "(";
        $this->localstaff_val = "(";

        /* staff */
        if (isset($this->name)) {
            $this->columns['staff'] .= "name";
            $this->values['staff'] .= "'$this->name'";
        }

        if (isset($this->address)) {
            $this->columns['staff'] .= ", address";
            $this->values['staff']  .= ", '$this->address'"; 
        }
        
        if (isset($this->phone)) {
            $this->columns['staff'] .= ", phone";
            $this->values['staff']  .= ", '$this->phone'"; 
        }

        if (isset($this->ssn)) {
            $this->columns['staff'] .= ", ssn";
            $this->values['staff']  .= ", '$this->ssn'"; 
        }

        if (isset($this->title)) {
            $this->columns['staff'] .= ", title";
            $this->values['staff']  .= ", '$this->title'"; 
        }

        /* admin */
        if (isset($this->location)) {
            $this->columns['admin'] .= "location";
            $this->values['admin']  .= "'$this->location'"; 
        }

        /* localstaff 
         * if the insert has a localstaff 'title' then location is the `f_id`
         */
        if (isset($this->location)) {
            $this->columns['localstaff'] .= "f_id";
            $this->values['localstaff']  .= "$this->location"; 
        }

        /* close */

        /* need to set the staff ID ! */
        $this->columns['admin'] .= ", staff_id)";
        $this->values['admin'] .= ", (SELECT MAX(staff_id) FROM ".$this->tables['staff'].") )";

        $this->columns['localstaff'] .= ", staff_id)";
        $this->values['localstaff'] .= ", (SELECT MAX(staff_id) FROM ".$this->tables['staff'].") )";

        $this->columns['staff'] .= ")";
        $this->values['staff'] .= ")";
    }

    public function getQueryString()
    {
        $query = "INSERT INTO " . $this->tables['staff'] . " ". $this->columns['staff']
                   . " VALUES " . $this->values['staff'] . ";";


        $isAdmin = false;

        if (isset($this->title)) {
            $this->logger->write("check");
            foreach (InsertIntoStaffQuery::$admin as $title) {
                if (strcasecmp($this->title, $title) == 0) {
                    $isAdmin = true;
                }
            }

            if ($isAdmin) {
                $query .= " INSERT INTO ".$this->tables['admin']." ".$this->columns['admin']
                         ." VALUES " . $this->values['admin']. ";";
            } else {
                $query .= " INSERT INTO ".$this->tables['localstaff']." ".$this->columns['localstaff']
                         ." VALUES " . $this->values['localstaff']. ";";
            }
        }

        return $query;
    }
}
?>
