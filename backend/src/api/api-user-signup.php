<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/bootstrap.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/utils/validators.php");

  // Imposta gli header CORS appropriati per le richieste POST
  header('Access-Control-Allow-Origin: *');
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
  $userId = 1;

  // Controllo mail
  $error = false;
  $response = '';
  if (!is_valid_email($email)) {
    $error = true;
    $response = "invalid email";
  }
  // Controllo nome azienda
  if (!is_valid_name($nome)) {
    $error = true;
    $response = "invalid name";
  }
  // Controllo password

  // Controllo dimensioni
  if (empty($dimensioni)) {
    $error = true;
    $response = "invalid size";
  }
  // Controllo città
  if (empty($citta)) {
    $error = true;
    $response = "invalid city";
  }
  // Controllo codice ATECO
  if (empty($ateco) && is_only_numbers($ateco)) {
    $error = true;
    $response = "invalid ATECO";
  }

  $message = array(
    'error' => $response,
    'nome' => $nome,
    'email' => $email,
    'citta' => $citta,
    'ateco' => $ateco,
    'dimensioni' => $dimensioni,
    'codiciCER' => $codiciCER,
    'userid' => $userId
  );

  echo json_encode($message);
}
