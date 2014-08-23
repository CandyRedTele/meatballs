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
    protected $result;
    static private $log_once_flag = false; // log only when the first IQuery is created, not after
	
   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct
    *
    *-----------------------------------------------------------*/
    public function __construct() 
    {
		$this->logger = Logger::getSingleInstance();
		
        $config_path = $_SERVER['DOCUMENT_ROOT'];

        MeatballUser::removeTrailingSlash($config_path);

        $config_path .= '/comp353-project/src/project.config.xml';

        if (!file_exists($config_path)) {
            $config_path = __DIR__ . '/project.config.xml'; 
        }
		
        if (!IQuery::$log_once_flag) {
		    $this->logger->write("\t? \$config_path = " . $config_path);
		    $this->logger->write("\t? \$include path = " . get_include_path());
            IQuery::$log_once_flag = true;
        }

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
    * NAME : __destruct
    *
    *-----------------------------------------------------------*/
    public function __destruct()
    {
        $this->free();
    }

    public function free()
    {
        if (isset($this->result) && gettype($this->result) == 'mysqli_result') {
            mysqli_free_result($this->result);
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
		
        $this->result = self::$mysql->execute($this->getQueryString());

        if (!$this->result) {
            $this->logger->write("[".__CLASS__ ."] $ ".__FUNCTION__."() ? "
                                    .self::$mysql->getLastError());
        }

        return $this->result;
    }
}
?>
