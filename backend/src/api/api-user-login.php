<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/bootstrap.php");
  global $dbh;
  // Imposta gli header CORS appropriati per le richieste POST
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  $company = $dbh->isMailCompanyPresent($email);
  if (count($company) > 0) {
    if (password_verify($password, $company['0']['password'])) {
      $error = '';
      $userId = $dbh->getAziendaID($email);
      $result = 'loggin succesfull';
      $_SESSION['user_id'] = $userId;
    } else {
      $error = 'invalid mail or password';
      $userId = 'invalid';
      $result = 'not logged';
    }
  } else {
     $error = 'mail not registered';
     $userId = 'invalid';
     $result = 'not logged';
  }

  $message = array(
    'error' => $error,
    'result' => $result,
    'userid' => $userId,
    'SESSION ID' => $_SESSION['user_id']
  );

  echo json_encode($message);
}
