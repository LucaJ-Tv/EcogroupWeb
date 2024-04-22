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

    public function getAllDomande() {
        $query = "SELECT * 
                FROM domande";
        $statement = $this->db->prepare($query);
        $this->error_string = $statement->execute() ? "DOMANDA" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function getDomandaAlterableByCategoria($categoria){
        $query = "SELECT DISTINCT d.*
                FROM domande AS d
                LEFT JOIN domande_questionari AS dq ON d.codDomanda = dq.DOMANDE_codDomanda
                JOIN categorie c ON d.CATEGORIE_idCATEGORIA = c.nomeCategoria
                WHERE nomeCategoria = ?
                AND sezioni_questionari_codQuestionario IS NULL;";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $categoria);
        $this->error_string = $statement->execute() ? "DOMANDA" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminateDomandaByCodDomanda($codDomanda) {
        $query = "DELETE FROM domande
                WHERE codDomanda LIKE ?";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('s', $codDomanda);
        return $statement->execute();
    }

    public function getDomandaByCodDomanda($codDomanda) {
        $query = "SELECT * 
                FROM domande 
                WHERE codDomanda LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $codDomanda);
        $this->error_string = $statement->execute() ? "DOMANDA" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // QUERY domande_questionari
    public function createDomandaQuestionario($numero, $peso, $codDomanda, $sezioneNome, $idQuestionario) {
        $query = "INSERT INTO domande_questionari
                  (numeroDomanda, peso, DOMANDE_codDomanda, sezioni_nome, sezioni_questionari_codQuestionario)
                   VALUES (?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('sdsss', $numero, $peso, $codDomanda, $sezioneNome, $idQuestionario);
        return $statement->execute();
    }

    public function getDomandaQuestionarioByQuestionarioID($idQuestionario) {
        $query = "SELECT * 
                FROM domande_questionari 
                WHERE sezioni_questionari_codQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $idQuestionario);
        $this->error_string = $statement->execute() ? "DOMANDAQUESTIONARIO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDomandaQuestionarioByCodDomandaQuesrionario($codDomandaQuestionario) {
        $query = "SELECT codDomandaQuestionario, peso
                FROM domande_questionari 
                WHERE codDomandaQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $codDomandaQuestionario);
        $this->error_string = $statement->execute() ? "DOMANDAQUESTIONARIO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminateAllDomandaQuestionarioByQuestionarioId($idQuestionario) {
        $query = "DELETE FROM domande_questionari
                WHERE sezioni_questionari_codQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('s', $idQuestionario);
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

    // QUERY modifiche
    function createModifica($codModeratore, $descrizione, $codQuestionario) {
        $query = "INSERT INTO modifiche
                (descrizione, MODERATORI_codModeratore, QUESTIONARI_codQuestionario)
                VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
          // Gestione dell'errore se la preparazione della query fallisce
          die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('sii', $descrizione, $codModeratore, $codQuestionario);
        return $statement->execute();
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

    function modificaTitoloQuestionario($titolo, $codQuestionario) {
        $query = "UPDATE questionari 
                SET titolo=?
                WHERE codQuestionario=?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('si', $titolo, $codQuestionario);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->execute();
    }

    function eliminateQuestionarioByQuestionarioId($codQuestionario) {
        $query = "DELETE FROM questionari
                WHERE codQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $codQuestionario);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->execute();
    }

    function getQuestionariNonCompilati(){
        $query = "SELECT *
            FROM questionari AS q
            LEFT JOIN questionari_compilati AS qc ON q.codQuestionario = qc.QUESTIONARI_codQuestionario
            WHERE qc.codQuestionarioCompilato IS NULL";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getTitoloByCodQuestionario($codQuestionario) {
        $query = "SELECT titolo
            FROM questionari
            WHERE codQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $codQuestionario);
        $this->error_string = $statement->execute() ? "TITOLO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // QUERY questionari_compilati
    function createQuestionarioCompilato($codQuestionario, $codAzienda) {
        $query = "INSERT INTO questionari_compilati (dataCompilazione, QUESTIONARI_codQuestionario, aziende_codAzienda)
                VALUES (CURRENT_DATE(), ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
          // Gestione dell'errore se la preparazione della query fallisce
          die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('ii', $codQuestionario, $codAzienda);
        return $statement->execute();
    }

    function getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario, $codAzienda) {
        $query = "SELECT codQuestionarioCompilato
            FROM questionari_compilati
            WHERE QUESTIONARI_codQuestionario = ? AND aziende_codAzienda = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('ii', $codQuestionario, $codAzienda);
        $this->error_string = $statement->execute() ? "QUESTIONARIOCOMPILATO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getAllQuestionarioCompilatoByCodAzienda($codAzienda) {
        $query = "SELECT *
            FROM questionari_compilati
            WHERE aziende_codAzienda = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $codAzienda);
        $this->error_string = $statement->execute() ? "QUESTIONARIOCOMPILATO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // QUERY risposte
    function createRisposta($valore, $codQuestionario, $codDomanda) {
        $query = "INSERT INTO risposte (punteggio, QUESTIONARI_COMPILATI_codQuestionarioCompilato, DOMANDE_QUESTIONARI_codDomandaQuestionario)
        VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        if (!$statement) {
          // Gestione dell'errore se la preparazione della query fallisce
          die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('dii', $valore, $codQuestionario, $codDomanda);
        return $statement->execute();
    }

    function getRisposteByCodQuestionario($codQuestionario) {
        $query = "SELECT punteggio, DOMANDE_QUESTIONARI_codDomandaQuestionario AS codDomandaQuestionario
                FROM risposte
                WHERE QUESTIONARI_COMPILATI_codQuestionarioCompilato = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $codQuestionario);
        $this->error_string = $statement->execute() ? "RISPOSTA" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // QUERY Scelte
    public function addScelte($valore, $peso, $domande_codDomanda) {
        $query = "INSERT INTO scelte (valore, peso, domande_codDomanda) VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('sdi', $valore, $peso, $domande_codDomanda);
        $statement->execute();
    }

    public function eliminateAllScelteByCodDomanda($codDomanda) {
        $query = "DELETE FROM scelte
                WHERE domande_codDomanda LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $codDomanda);
        if (!$statement) {
            // Gestione dell'errore se la preparazione della query fallisce
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->execute();
    }

    public function getScelteByCodDomanda($codDomanda) {
        $query = "SELECT *
            FROM scelte
            WHERE domande_codDomanda LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $codDomanda);
        $this->error_string = $statement->execute() ? "SCELTE" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // QUERY sezioni
    public function createSezioni($sezioniNomi, $idQuestionario) {
        // Verifica se la sezione è già presenti nel database
        $existingSezioni = $this->getExistingSezioni();
        var_dump($existingSezioni);
        foreach ($sezioniNomi as $sezione) {
            $sezioneDiversa = true;
            // Verifica se la sezione è già presente nel database
            if( count($existingSezioni) > 0) {
                foreach ($existingSezioni as $existingSezione) {
                    if ($existingSezione['nome'] === $sezione && $existingSezione['questionari_codQuestionario'] === $idQuestionario) {
                        $sezioneDiversa = false;
                        break; // Esci dal ciclo interno se la sezione è stata trovata
                    }
                }
            }
            // Se la sezione è diversa, aggiungila
            if ($sezioneDiversa) {
                $this->addSezione($sezione, $idQuestionario);
            }
        }
    }

    private function getExistingSezioni() {
        $query = "SELECT * FROM sezioni";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    private function addSezione($sezione, $idQuestionario) {
        $query = "INSERT INTO sezioni (nome, questionari_codQuestionario) VALUES (?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param('ss', $sezione, $idQuestionario);
        $statement->execute();
    }

    public function getSezioniByCodQuestionario($codQuestionario) {
        $query = "SELECT * 
                FROM sezioni 
                WHERE questionari_codQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $codQuestionario);
        $this->error_string = $statement->execute() ? "SEZIONI" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function eliminateSezioniByQuestionarioId($codQuestionario) {
        $query = "DELETE FROM sezioni
                WHERE questionari_codQuestionario LIKE ?";
        $statement = $this->db->prepare($query);
        if (!$statement) {
            die("Errore nella preparazione della query: " . $this->db->error);
        }
        $statement->bind_param('s', $codQuestionario);
        return $statement->execute();
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
    
    function getQuestionarioByTitoloDiverso($titolo , $codQuestionario) {
        $query = "SELECT * 
        FROM questionari
        WHERE titolo LIKE ? AND codQuestionario NOT LIKE ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('ss', $titolo, $codQuestionario);
        $this->error_string = $statement->execute() ? "TITOLO" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}