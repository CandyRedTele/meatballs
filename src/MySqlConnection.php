<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class MysqlConnection
 *
 *************************************************************************/
class MySqlConnection 
{
    private $host;
    private $username;
    private $db;
    private $password;          // N.B. In real life, we would not let this password here!
    private $connection;
    private $logger;

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * PURPOSE : Constructor
     *
     *-----------------------------------------------------------*/
    public function __construct() 
    {
        $argc = func_num_args();
        $args = func_get_args();

        $this->logger = Logger::getSingleInstace();

        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
        }

        if (!$this->connect()) {
            $this->logger->write("[ERROR] :: Cannot connect to mysql.");
            return null; // TODO do something more please!
        }
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME __construct_4
     *
     * PURPOSE : Four args constructor
     *
     *-----------------------------------------------------------*/
    private function __construct_4($host, $uname, $password, $db)
    {
        $this->host = $host; 
        $this->username = $uname;
        $this->db = $db;
        $this->password = $password;
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : __destruct
     *
     *----------------------------------------------------------*/
    public function __destruct()
    {
        $this->logger->write("[" . __CLASS__ . "]" . " - " . $this->__toString());
        $this->close();
    }

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : connect 
     *
     * RETURNS : true on success, false otherwise
     *
     *-----------------------------------------------------------*/
    private function connect()
    {
        $result = false;

        $this->connection = mysqli_connect($this->host,     $this->username,
                $this->password, $this->db);

        if ($this->connection) 
        {
            $this->logger->write("[" . __CLASS__ . "]" . " + " . $this);
            $result = true;
        } 

        return $result;
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : close 
     *
     *-----------------------------------------------------------*/
    public function close()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : execute 
     *
     * PURPOSE : executes a given query
     *
     * ARGS : $query  -  the query as a string. 
     *
     * RETURNS : $result as a mysqli_result object.
     *           See : 
     *           http://php.net/manual/en/class.mysqli-result.php
     *
     *-----------------------------------------------------------*/
    public function execute($query)
    {

        $this->logger->write("[" . __CLASS__ . "]" . " $ execute() : '" . $query . "'"); 

        $result = mysqli_query($this->connection, $query);

        return $result;
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * NAME : __toString
     *
     *-----------------------------------------------------------*/
    public function __toString()
    {
        return $this->username . "@" . $this->host;
    }
}
?>
