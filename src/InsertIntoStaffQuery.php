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
 *	 | access_level | int(11)     | YES  |     | NULL    |                |
 *	 +--------------+-------------+------+-----+---------+----------------+
 *	
 *	 
 **************************************************************************/
include_once("IQuery.php");
class InsertIntoStaffQuery extends IQuery
{
    private $table;
    private $columns;
    private $values;

    private $name;
    private $address;
    private $phone;
    private $ssn;
    private $title;
    private $access_level;

    public function __construct()
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
        $this->table = 'staff';

        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
        }
    }

    public function __construct_1($name)
    {
        $this->name = $name;
        $this->setColumnsAnsValues();
    }

    public function __construct_2($name, $address)
    {
        $this->name = $name;
        $this->address = $address;
        $this->setColumnsAnsValues();
    }

    public function __construct_3($name, $address, $phone)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;

        $this->setColumnsAnsValues();
    }

    public function __construct_4($name, $address, $phone, $ssn)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;

        $this->setColumnsAnsValues();
    }
    
    public function __construct_5($name, $address, $phone, $ssn, $title)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;
        $this->title = $title;

        $this->setColumnsAnsValues();
    }

    public function __construct_6($name, $address, $phone, $ssn, $title, $access_level)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;
        $this->title = $title;
        $this->access_level = $access_level;

        $this->setColumnsAnsValues();
    }

    private function setColumnsAnsValues()
    {
        $this->columns = "(";
        $this->values = "(";

        if (isset($this->name)) {
            $this->columns .= "name";
            $this->values .= "'$this->name'";
        }

        if (isset($this->address)) {
            $this->columns .= ", address";
            $this->values  .= ", '$this->address'"; 
        }
        
        if (isset($this->phone)) {
            $this->columns .= ", phone";
            $this->values  .= ", '$this->phone'"; 
        }

        if (isset($this->ssn)) {
            $this->columns .= ", ssn";
            $this->values  .= ", '$this->ssn'"; 
        }

        if (isset($this->title)) {
            $this->columns .= ", title";
            $this->values  .= ", '$this->title'"; 
        }

        if (isset($this->access_level)) {
            $this->columns .= ", access_level";
            $this->values  .= ", '$this->access_level'"; 
        }

        $this->columns .= ")";
        $this->values .= ")";
    }

    public function getQueryString()
    {
        return "INSERT INTO " . $this->table . " ". $this->columns . " VALUES " . $this->values . ";";
    }
}
?>
