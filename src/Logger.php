<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph 
 *
 * NAME : class Logger
 *
 * NOTES : To see the logs at the same time as you are browsing the site :
 *          - open a terminal on the server, type : 
 *                      tail -f 'pathOnTheMachine/comp353-project/src/log'
 *         
 *
 *************************************************************************/
class Logger
{
    private $fd;
    private $filename;
    private static $singleton;

    public static function getSingleInstace()
    {
        $argc = func_num_args();
        $args = func_get_args();

        if (self::$singleton === null) 
        {
            if ($argc == 0) 
            {
                self::$singleton = new Logger();
            } 
            else 
            {
                self::$singleton = new Logger($args[0]); // For Unit Testing purpose
            }
        }

        return self::$singleton;
    }
    
    private function __construct() 
    {
        $argc = func_num_args();
        $args = func_get_args();

        if (!preg_match('/htdocs/', $_SERVER['DOCUMENT_ROOT']) && !preg_match('/www/', $_SERVER['DOCUMENT_ROOT'])) { // it means we are in PHPUnit, run the test from the ROOT of the project
            $this->filename = getcwd() . "/src/log";
        } else {
            $this->filename = $_SERVER['DOCUMENT_ROOT'] . "/comp353-project/src/log";
        }
        
        if (method_exists($this, $f = '__construct_' . $argc)) 
        {
            call_user_func_array(array($this, $f), $args);    
        }

        $this->fd = fopen($this->filename, 'w');

        if (!$this->fd) { // give it another try
            $this->filename = substr(getcwd(), 0, strrpos(getcwd(), '/tests')) . '/src/log';
            $this->fd = fopen($this->filename, 'w') or die('Cannot open the log file: ' . $this->filename);
        }
    }

    private function __construct_1($filename)
    {
       $this->filename = $filename; 
    }

    public function write($str)
    {
        fwrite(self::$singleton->fd, $str . "\n");
    }
}
?>
