<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : class InsertIntoGoldenQuery
 *
 * PURPOSE : add one row to the 'golden' table;
 *
 *************************************************************************/
include_once("IQuery.php");
class InsertIntoGoldenQuery extends IQuery
{
    private $table;

    private $firstname;
    private $lastname;
    private $sex;
    private $email;
    private $phone;

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : __construct
    *
    *-----------------------------------------------------------*/
    public function __construct($firstname, $lastname, $sex, $email, $phone)
    {
		parent::__construct();
		$this->logger->write("[" . __CLASS__ . "] - __construct()");

        $this->table = 'golden';

        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->sex = $sex;
        $this->email = $email;
        $this->phone = $phone;
    }

   /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    * 
    * NAME : getQueryString
    *
    *-----------------------------------------------------------*/
    public function getQueryString()
    {
        return "INSERT INTO ".$this->table." (firstname, lastname, sex, email, phone) VALUES " 
                        ."('$this->firstname', '$this->lastname', '$this->sex', '$this->email', '$this->phone')"
                        .";";
    }
}
?>
