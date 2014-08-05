<?
    include_once("IQuery.php");

    class TestQuery extends IQuery
    {

        public function execute()
        {
            $query_string = __CLASS__ . "::getQueryString()";
            $result = self::$mysql->execute($query_string);

            return $result;
        }
    }

?>
