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
        $query = "INSERT INTO aziende
                  (username,mail,citta,cap,codAteco,password, DIMENSIONE_dimensione)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('sssssss', $nome, $email, $citta, $cap, $codiceAteco, $password, $dimensione);
        return $statement->execute();
    }

    function getAziendaID($email) {
        $query = "SELECT codAzienda 
                FROM aziende 
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

    // QUERY categorie
    public function createCategory($category) {
        $query = "INSERT INTO categorie (nomeCategoria) VALUES (?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $category);
        $statement->execute();
    }

    public function getAllCategories() {
        $query = "SELECT *
                FROM categorie";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // QUERY codici_azienda
    public function createCodiciAzienda($idAzienda, $codiciCer) {
        $codiciArray = explode(',', $codiciCer);
        $codiciArray = array_map('trim', $codiciArray);

        foreach ($codiciArray as $codice) { 
            $query = "INSERT INTO codici_azienda (AZIENDE_codAzienda, CODICI_CER_codiceCER) VALUES (?, ?)";
            $statement = $this->db->prepare($query);
            $statement->bind_param('is', $idAzienda, $codice);
            $statement->execute();
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
        $query = "SELECT codiceCER FROM codici_cer";
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
        $query = "INSERT INTO codici_cer (codiceCER) VALUES (?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $codice);
        $statement->execute();
    }

    // QUERY Domande
    public function addDomanda($positiva, $testo, $categoria, $moderatore) {
        $query = "INSERT INTO domande (positiva, testo, CATEGORIE_idCATEGORIA, moderatori_codModeratore) VALUES (?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('issi', $positiva, $testo, $categoria, $moderatore);
        $statement->execute();
    }

    public function getDomandaID($testo) {
        $query = "SELECT codDomanda
                FROM domande 
                WHERE testo LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $testo);
        $this->error_string = $statement->execute() ? "TESTO" : "";
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cod = $row['codDomanda'];
            return $cod;
        } else {
            return false;
        }
    }

    public function updateDomanda($id ,$testo, $positiva, $categoria) {
        $query = "UPDATE domande 
                SET testo=?, positiva=?, CATEGORIE_idCATEGORIA=? WHERE codDomanda=?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('sisi', $testo, $positiva, $categoria, $id);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->execute();
    }

    public function getDomandaByCategoria($categoria) {
        $query = "SELECT * 
                FROM domande 
                WHERE CATEGORIE_idCATEGORIA LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $categoria);
        $this->error_string = $statement->execute() ? "DOMANDA" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // QUERY domande_questionari
    public function createDomandaQuestionario($numero, $peso, $codDomanda, $idQuestionario) {
        $query = "INSERT INTO domande_questionari
                  (numeroDomanda, peso, DOMANDE_codDomanda, QUESTIONARIO_codQuestionario)
                   VALUES (?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('sdss', $numero, $peso, $codDomanda, $idQuestionario);
        return $statement->execute();
    }


    // QUERY Moderatori
    public function createMod($nome, $email, $password) {
        if(count($this->isMailCompanyPresent($email))>0 || count($this->isMailModeratorPresent($nome)) > 0){
            return false;
        }
        $query = "INSERT INTO moderatori
                  (mail,username,password)
                   VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('sss', $email, $nome, $password);
        return $statement->execute();
    }

    public function getAllMods() {
        $query = "SELECT codModeratore, username
                FROM moderatori";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getModeratorID($email) {
        $query = "SELECT codModeratore
                FROM moderatori 
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

    // QUERY Questionari
    function createQuestionario($titolo) {
        if(count($this->getQuestionarioByTitolo($titolo))) {
            return false;
        }
        $query = "INSERT INTO questionari
                  (titolo)
                   VALUES (?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $titolo);
        return $statement->execute();
    }

    function getQuestionarioByTitolo($titolo) {
        $query = "SELECT * 
        FROM questionari
        WHERE titolo LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $titolo);
        $this->error_string = $statement->execute() ? "TITOLO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getQuestionarioID($titolo) {
        $query = "SELECT codQuestionario
                FROM questionari 
                WHERE titolo LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $titolo);
        $this->error_string = $statement->execute() ? "TITOLO" : "";
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cod = $row['codQuestionario'];
            return $cod;
        } else {
            return false;
        }
    }

    // QUERY Scelte
    public function addScelte($valore, $peso, $domande_codDomanda) {
        $query = "INSERT INTO scelte (valore, peso, domande_codDomanda) VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('sdi', $valore, $peso, $domande_codDomanda);
        $statement->execute();
    }


    // Utils
    public function isMailCompanyPresent($email) {
        $query = "SELECT * 
                FROM aziende 
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "MAIL" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isMailModeratorPresent($email) {
        $query = "SELECT * 
                FROM moderatori
                WHERE mail LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $this->error_string = $statement->execute() ? "MAIL" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function isNamePresent($name) {
        $query = "SELECT * 
                FROM aziende 
                WHERE username LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $name);
        $this->error_string = $statement->execute() ? "USERNAME" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isUsernamePresent($name) {
        $query = "SELECT * 
                FROM moderatori 
                WHERE username LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $name);
        $this->error_string = $statement->execute() ? "USERNAME" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isCategoryPresent($category) {
        $query = "SELECT * 
                FROM categorie 
                WHERE nomeCategoria LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $category);
        $this->error_string = $statement->execute() ? "CATEGORY" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}