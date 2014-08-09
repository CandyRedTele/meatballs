<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class MeatballUser 
 *
 *************************************************************************/
include_once("IQuery.php");
class MeatballUser
{
    private function __construct()
    {
    }

    public static function getAccessLevel($staff_id)
    {
        $logger = Logger::getSingleInstace();

        $query = new CustomQuery("SELECT acces_level FROM staff WHERE staff_id= " . $staff_id);
        $result = $query->execute();
        $level = mysqli_fetch_row($result)[0];

        $logger->write("[" . __CLASS__ . "] ? level = " . $level);

        return $level;
    }
}
?>
