<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class MeatballUser 
 *
 *************************************************************************/
include_once("IncludeAllQueries.php");
class MeatballUser
{
    private function __construct()
    {
        /* this is a static class */
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : getAccessLevel
     *
     * RETURNS : the access level on sucess, false otherwise
     *
     *-----------------------------------------------------------*/
    public static function getAccessLevel($staff_id)
    {
        $logger = Logger::getSingleInstace();

        $query = new GetAccessLevelQuery($staff_id);
        $result = $query->execute();

        if ($result->num_rows == 0) {
            $logger->write("[" . __CLASS__ . "] $ " . __FUNCTION__ . "() ? No row returned for staff id : ".$staff_id );
            return false;
        }

        $level = mysqli_fetch_row($result)[0];

        $logger->write("[" . __CLASS__ . "] $ ".__FUNCTION__."() ? level = " . $level);

        return $level;
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : removeTrailingSlash 
     *
     * RETURNS : removes the trailing slash of a path (intended to 
     *           Windows user)
     *
     *-----------------------------------------------------------*/
    public static function removeTrailingSlash(&$str)
    {
        if (strrpos($str, '/') == strlen($str) - 1) 
        {
            $str = substr($str, 0, -1); // remove trailing '/' (for windows)
        }
        
        return $str;
    }
}
?>
