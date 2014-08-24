<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : GetTrainingQuery
 *
 *************************************************************************/
include_once("IQuery.php");
class GetTrainingQuery extends IQuery
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
    public function __construct($staff_id)
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");

        $this->tables['staff'] = 'staff';
        $this->tables['admin_or_localstaff'] = 'admin';
        $this->columns = 'staff_id, training';

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
        $admin_or_localstaff = new CustomQuery("SELECT staff_id "
                                        . " FROM staff "
                                        . " NATURAL JOIN admin "
                                        . " WHERE staff_id=" . $this->staff_id ."; ");
        $result = $admin_or_localstaff->execute();

        if ($result->num_rows > 0) 
        {
            $this->tables['admin_or_localstaff'] = 'admin';
        } 
        else 
        {
            $this->tables['admin_or_localstaff'] = 'localstaff';
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
                 . " FROM         " . $this->tables['admin_or_localstaff']
                 . " NATURAL JOIN " . $this->tables['staff']
                 . " WHERE staff_id=" . $this->staff_id ."; ";

        return $query;
    }
}
?>
