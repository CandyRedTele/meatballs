<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class IQuery 
 *
 *************************************************************************/
include_once("MySqlConnection.php");
include_once("ConfigLoader.php");
abstract class IQuery 
{
    static protected $mysql;  // only one connection to avoid connect/unconnect multiple times
    protected $logger;
	
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : __construct, no arguments 
     *
     *-----------------------------------------------------------*/
    public function __construct() 
    {
		$this->logger = Logger::getSingleInstace();
		$this->logger->write("[" . __CLASS__ . "] $ __construct()");
		
        if (preg_match('/unit$/', getcwd())) {
            $config_path = '../../src/project.config.xml'; // For testing purpose
        } else {
			$config_path = $_SERVER['DOCUMENT_ROOT'] . '/comp353-project/src/project.config.xml';
		}
		
		$this->logger->write("\t? \$config_path = " . $config_path);

        $loader = new ConfigLoader($config_path, "localhost");

        if (!isset(self::$mysql)) {
            self::$mysql = new MySqlConnection($loader->getHost(), 
                                               $loader->getUsername(), 
                                               $loader->getPassword(),  
                                               $loader->getDatabase());
        } 
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : getQueryString 
     *
     * PURPOSE : To be overriden by subclasses.
     *
     * RETURNS : The query string to be executed by execute()
     *
     *-----------------------------------------------------------*/
    abstract protected function getQueryString();


    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : execute 
     *
     * PURPOSE : Execute the query returned by getQueryString()
     *
     *-----------------------------------------------------------*/
    public function execute()
    {
		if (is_null(self::$mysql)) {
			$this->logger->write(__CLASS__ . "not connected");
		}
		
        $result = self::$mysql->execute($this->getQueryString());

        if (!$result) {
            $this->logger->write("[".__CLASS__ ."] $ ".__FUNCTION__."() ? "
                                    .self::$mysql->getLastError());
        }

        return $result;
    }
}
?>
