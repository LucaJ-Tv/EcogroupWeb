<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
                        
class Database {
    private $db;
    private $error_string;

    public function __construct() {
        $this->error_string = "";
        $this->db = new mysqli(CONF_DATABASE['server'], CONF_DATABASE['user'], CONF_DATABASE['password'], CONF_DATABASE['dbname'], CONF_DATABASE['port']);
        if($this->db->connect_error) {
            die("Connection failed : ".$this->db->connect_error);
        }
    }

    public function getErrorString() {
        return $this->error_string;
    }

    // QUERY Moderatori
    public function getAllMods() {
        $query = "SELECT codModeratore, username
                FROM MODERATORI";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Utils
    public function isMailPresent($email) {
        $query = "SELECT * 
                FROM AZIENDE 
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "EMAIL" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function isNamePresent($name) {
        $simbol = 's';
        $query = "SELECT * 
                FROM AZIENDE 
                WHERE nome LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($simbol, $name);
        $this->error_string = $statement->execute() ? "NOME" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}