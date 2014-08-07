<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class TestQuery 
 *
 *************************************************************************/
    include_once("IQuery.php");

    class TestQuery extends IQuery
    {
        public function getQueryString()
        {
            $query_string = "SELECT * FROM customers;";
            return $query_string;
        }
    }

?>
