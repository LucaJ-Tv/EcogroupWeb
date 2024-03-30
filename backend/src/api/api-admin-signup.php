<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;
  // Imposta gli header CORS appropriati per le richieste POST
  header('Content-Type: application/json');
  
  // Accedi direttamente ai dati 
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $userId = 0;

  $result = "Admin not created";
  // Controllo mail
  if (!is_valid_email($email)) {
    $response = "invalid email";
  }
  if (!is_valid_username($email)) {
    $response = "invalid username";
  }
  // Controllo password
  if (!is_valid_password($password)) {
    $response = "invalid password";
  }

  if(!isset($response)){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $dbh->createMod($username, $email, $password_hash);
    $userId=$dbh->getModeratorID($email);
    $response='';
    $result = 'Admin created';
  }

  $message = array(
    'error' => $response,
    'result' => $result,
    'userid' => $userId
  );

  echo json_encode($message);
}
