<?php
    class ConfigLoader
    {
        private $host;
        private $username;
        private $password;
        private $database;

        public function __construct($config_file_path, $myConfigName)
        {
            if (file_exists($config_file_path)) {
                $xml = simplexml_load_file($config_file_path);
            } else {
                exit('Failed to open '.$config_file_path."\n");
            }

            $xpath = ($xml->xpath('/configurations/configuration[name="' . $myConfigName . '"]'));

            if (isset($xpath[0])) {
                $node = $xpath[0]; 
            } else {
                print_r($xpath);
                exit("[ERROR] the xpath query returned empty \n");
            }


            $this->host = $node->host;
            $this->username = $node->username;
            $this->database = $node->database;
        }

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
