<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;
  // Imposta gli header CORS appropriati per le richieste POST
  header('Content-Type: application/json');
  
  // Accedi direttamente ai dati 
  $nome = isset($_POST['nomeAzienda']) ? $_POST['nomeAzienda'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $dimensioni = isset($_POST['dimensioni']) ? $_POST['dimensioni'] : '';
  $cap = isset($_POST['cap']) ? $_POST['cap'] : '';
  $citta = isset($_POST['citta']) ? $_POST['citta'] : '';
  $ateco = isset($_POST['ateco']) ? $_POST['ateco'] : '';
  $codiciCER = isset($_POST['codiciCer']) ? $_POST['codiciCer'] : '';
  $userId = 0;

  $result = "Azienda not created";
  // Controllo mail
  if (!is_valid_email($email)) {
    $response = "invalid email";
  }
  // Controllo nome azienda
  if (!is_valid_name($nome)) {
    $response = "invalid name";
  }
  // Controllo password
  if (!is_valid_password($password)) {
    $response = "invalid password";
  }
  // Controllo dimensioni
  if (empty($dimensioni)) {
    $response = "invalid size";
  }
  if (empty($cap) || !is_only_numbers($cap)) {
    $response = "invalid cap";
  }
  // Controllo città
  if (empty($citta)) {
    $response = "invalid city";
  }
  // Controllo codice ATECO
  if (empty($ateco) || !is_only_numbers($ateco)) {
    $response = "invalid ATECO";
  }
  // Controllo codici CER
  if (!empty($codiciCER)) {
    $codiciCERPuliti = clear_CER($codiciCER);
    if (!validate_CER($codiciCERPuliti)) {
      $response = "invalid CER";
    }
  } else {
    $response = "invalid CER";
  }
  if(!isset($response)){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $dbh->createAzienda($nome, $email, $password_hash, $dimensioni, $cap, $citta, $ateco, $codiciCER);
    $response='';
    $userId=$dbh->getAziendaID($email);
    $result = 'Azienda created';
  }

  $message = array(
    'error' => $response,
    'result' => $result,
    'userid' => $userId
  );

  echo json_encode($message);
}
