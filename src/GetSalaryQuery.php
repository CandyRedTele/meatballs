<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : GetSalaryQuery 
 *
 * PURPOSE :
 *
 *************************************************************************/
include_once("IQuery.php");
class GetSalaryQuery extends IQuery
{
    private $tables;
    private $columns;
    private $values;

    private $staff_id;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct 
    *
    *-----------------------------------------------------------*/
    public function __construct()
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");
        $this->tables['staff'] = 'staff';

        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $fct = "__construct_" . $argc)) { 
            call_user_func_array(array($this, $fct), $args);
            $this->setColumnsAnsValues();
        }
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct_1 
    *
    *-----------------------------------------------------------*/
    private function __construct_1($staff_id) 
    {
        $this->staff_id = $staff_id;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : setColumnsAnsValues
    *
    *-----------------------------------------------------------*/
    private function setColumnsAnsValues()
    {
       /*
        * check if the staff_id is a local/admin
        */
        $pay_of_wage = new CustomQuery("SELECT staff_id "
                                        . " FROM staff "
                                        . " NATURAL JOIN wage "
                                        . " WHERE staff_id=" . $this->staff_id ."; ");
        $result = $pay_of_wage->execute();

        if ($result->num_rows > 0) 
        {
            $this->tables['salary'] = 'wage';
            $this->columns = 'staff_id, title, base, exp_rate, overtime';
        } 
        else 
        {
            $this->tables['salary'] = 'pay';
            $this->columns = 'staff_id, title, base, exp_rate, train_rate';
        }
    }
    
   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString 
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
   
        $query =   " SELECT  " . $this->columns
                 . " FROM         " . $this->tables['salary']
                 . " NATURAL JOIN " . $this->tables['staff']
                 . " WHERE staff_id=" . $this->staff_id ."; ";

        return $query;
    }
}
?>
