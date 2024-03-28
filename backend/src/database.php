<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/www/config.php");
                        
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

    // QUERY Aziende
    public function createAzienda($nome, $email, $password, $dimensione, $cap, $citta, $codiceAteco, $codiciCer) {
        if(count($this->isMailCompanyPresent($email))>0 || count($this->isNamePresent($nome)) > 0){
            return false;
        }
        $this->createCodiciCer($codiciCer);
        $query = "INSERT INTO AZIENDE
                  (username,mail,citta,cap,codAteco,password, DIMENSIONE_dimensione)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('sssssss', $nome, $email, $citta, $cap, $codiceAteco, $password, $dimensione);
        $this->createCodiciCer($codiciCer);
        return $statement->execute();
    }

    function getAziendaID($email) {
        $query = "SELECT codAzienda 
                FROM AZIENDE 
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "MAIL" : "";
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $codAzienda = $row['codAzienda'];
            return $codAzienda;
        } else {
            return false;
        }
    }

    // QUERY CodiciCER
    public function createCodiciCer($codiciCer) {
        $codiciArray = explode(',', $codiciCer);
        $codiciArray = array_map('trim', $codiciArray);

        // Verifica se i codici sono già presenti nel database
        $existingCodici = $this->getExistingCodici();
        foreach ($codiciArray as $codice) {
            // Se il codice non è presente nel database
            if (!in_array($codice, $existingCodici)) {
                $this->addCodiceCer($codice);
            }
        }
    }
    
    private function getExistingCodici() {
        $query = "SELECT codiceCER FROM CODICI_CER";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $existingCodici = array();
        while ($row = $result->fetch_assoc()) {
            $existingCodici[] = $row['codiceCER'];
        }
        return $existingCodici;
    }
    
    private function addCodiceCer($codice) {
        $query = "INSERT INTO CODICI_CER (codiceCER) VALUES (?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $codice);
        $statement->execute();
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

    function getModeratorID($email) {
        $query = "SELECT codModeratore
                FROM MODERATORI 
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "MAIL" : "";
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cod = $row['codModeratore'];
            return $cod;
        } else {
            return false;
        }
    }

    // Utils
    public function isMailCompanyPresent($email) {
        $query = "SELECT * 
                FROM AZIENDE 
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "MAIL" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isMailModeratorPresent($email) {
        $query = "SELECT * 
                FROM MODERATORI
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "MAIL" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function isNamePresent($name) {
        $query = "SELECT * 
                FROM AZIENDE 
                WHERE username LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $name);
        $this->error_string = $statement->execute() ? "USERNAME" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}