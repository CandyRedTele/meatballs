<?
/**************************************************************************
 *
 * AUTHORS : Team 3 
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

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * PURPOSE : Constructor
     *
     *-----------------------------------------------------------*/
    public function __construct() 
    {
        $argc = func_num_args();
        $args = func_get_args();

        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
        }

        if (!$this->connect()) {
            // TODO log error
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
        echo " - " . $this->__toString() . "<br>"; // TODO log
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
            echo " + " . $this . "<br>"; // TODO log
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
     * ARGS : args[0]  -  the query as a string. 
     *
     *-----------------------------------------------------------*/
    public function execute()
    {
        $args = func_get_args();
        $result = "TODO";

        echo "executing query : " . $args[0] . "<br>"; // TODO log

        // TODO
        //mysqli_query($this.connection, "SELECT * FROM Persons");

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
