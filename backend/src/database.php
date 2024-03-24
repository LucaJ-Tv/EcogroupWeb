<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
                        
class Database {
    private $db;
    private $error_string;

    public function __construct() {
        $this->error_string = "";
        $this->db = new mysqli(CONF_DATABASE["server"], CONF_DATABASE["user"], CONF_DATABASE["password"], CONF_DATABASE["dbname"], CONF_DATABASE["port"]);
        if($this->db->connect_error) {
            die("Connection failed : ".$this->db->connect_error);
        }
    }

    public function getErrorString(){
        return $this->error_string;
    }

}