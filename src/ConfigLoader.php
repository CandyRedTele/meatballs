<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : ConfigLoader 
 *
 * PURPOSE : Loads a XML config file.
 *
 **************************************************************************/
class ConfigLoader
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $logger;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct 
    *
    *-----------------------------------------------------------*/
    public function __construct($config_file_path, $myConfigName)
    {
        $this->logger = Logger::getSingleInstace();

        if (file_exists($config_file_path)) {
            $xml = simplexml_load_file($config_file_path);
        } else {
            exit('Failed to open '.$config_file_path."\n"); // TODO log
        }

        $xpath = ($xml->xpath('/configurations/configuration[name="' . $myConfigName . '"]'));

        if (isset($xpath[0])) {
            $node = $xpath[0]; 
        } else {
            $msg = "[ERROR]::[" . __CLASS__ . "]" . " The xpath query returned empty"; 
            $this->logger->write($msg);

            print_r($xpath);
            exit($msg);
        }


        $this->host = $node->host;
        $this->username = $node->username;
        $this->database = $node->database;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    *  Accessors / Mutators
    *
    *-----------------------------------------------------------*/
    public function getHost()
    {
        return $this->host;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword() 
    {
        return $this->password;
    }

    public function getDatabase()
    {
        return $this->database;
    }
}
?>
