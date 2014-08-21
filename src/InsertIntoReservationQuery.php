<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class InsertIntoReservation
 *
 * PURPOSE : add one row to the 'reservation' table;
 *
 * +------------+-------------+------+-----+-------------------+-------+
 * | Field      | Type        | Null | Key | Default           | Extra |
 * +------------+-------------+------+-----+-------------------+-------+
 * | r_id       | int(11)     | NO   | PRI | NULL              |       |
 * | name       | varchar(45) | YES  |     | NULL              |       |
 * | time       | datetime    | YES  |     | CURRENT_TIMESTAMP |       |
 * | #_seats    | int(11)     | YES  |     | 1                 |       |
 * | event_type | varchar(25) | YES  |     | NULL              |       |
 * | f_id       | int(11)     | NO   | MUL | NULL              |       |
 * +------------+-------------+------+-----+-------------------+-------+
 *
 **************************************************************************/
include_once("IQuery.php");
class InsertIntoReservation extends IQuery
{
    private $tables;
    private $columns;
    private $values;

    /* reservation */
    private $name;
    private $time;
    private $nb_of_seats;
    private $event_type;
    private $f_id;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct
    *
    *-----------------------------------------------------------*/
    public function __construct()
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");

        /* tables involved in this query */
        $this->tables['reservation'] = 'reservation';

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
    * NAME : __construct_5 
    *
    *-----------------------------------------------------------*/
    private function __construct_5($name, $time, $nb_of_seats, $event_type, $facility_id)
    {
        $this->init($name, $time, $nb_of_seats, $event_type, $facility_id);
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : init 
    *
    *-----------------------------------------------------------*/
    private function init($name, $time, $nb_of_seats, $event_type, $facility_id)
    {
        $this->name = $name;
        $this->time = $time;
        $this->nb_of_seats = $nb_of_seats;
        $this->event_type = $event_type;
        $this->f_id = $facility_id;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : setColumnsAnsValues 
    *
    *-----------------------------------------------------------*/
    private function setColumnsAnsValues()
    {
        $this->columns['reservation'] = "(";
        $this->values['reservation'] = "(";

        /* reservation */
        if (isset($this->name)) {
            $this->columns['reservation'] .= "name";
            $this->values['reservation'] .= "'$this->name'";
        }

        if (isset($this->time)) {
            $this->columns['reservation'] .= ", time";
            $this->values['reservation']  .= ", '$this->time'"; 
        }
        
        if (isset($this->nb_of_seats)) {
            $this->columns['reservation'] .= ", nb_of_seats";
            $this->values['reservation']  .= ", '$this->nb_of_seats'"; 
        }

        if (isset($this->event_type)) {
            $this->columns['reservation'] .= ", event_type";
            $this->values['reservation']  .= ", '$this->event_type'"; 
        }

        if (isset($this->f_id)) {
            $this->columns['reservation'] .= ", f_id";
            $this->values['reservation']  .= ", '$this->f_id'"; 
        }

        /* close */
        $this->columns['reservation'] .= ")";
        $this->values['reservation'] .= ")";
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString 
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        $query = "START TRANSACTION;\n";
        $query .= "INSERT INTO " . $this->tables['reservation'] . " ". $this->columns['reservation']
                   . " VALUES " . $this->values['reservation'] . ";";


        $query .= "COMMIT;";
        return $query;
    }
}
?>
