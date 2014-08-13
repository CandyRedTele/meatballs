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
        $this->columns = "(name)";
        $this->name = $name;
        $this->values = "CHECK";
    }

    public function __construct_6($name, $address, $phone, $ssn, $title, $access_level)
    {
        $this->columns = "(name, address, phone, ssn, title, access_level)";

        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->ssn = $ssn;
        $this->title = $title;
        $this->access_level = $access_level;

        $this->values = "('$this->name', '$this->address', '$this->phone', '$this->ssn', '$this->title')";
    }

    public function getQueryString()
    {
        return "INSERT INTO " . $this->table . " ". $this->columns . " VALUES " . $this->values . ";";
    }
}
?>
