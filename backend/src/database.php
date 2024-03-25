<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
                        
class Database {
    private $db;
    private $error_string;

    public function __construct() {
        $this->error_string = "";
        $this->db = new mysqli("mysql", "root", "root","eco_group", "3306");
        if($this->db->connect_error) {
            die("Connection failed : ".$this->db->connect_error);
        }
    }

    public function getErrorString(){
        return $this->error_string;
    }


    public function getAllMods(){
        $query = "SELECT codModeratore, username
                FROM MODERATORI";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}