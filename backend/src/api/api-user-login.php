<?php

header('Access-Control-Allow-Origin: *');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;
  // Imposta gli header CORS appropriati per le richieste POST
  header('Content-Type: application/json');

  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $userId = -1;
  $userType = 'unknown';

  $company = $dbh->isMailCompanyPresent($email);
  $moderator = $dbh->isMailModeratorPresent($email);
  if (count($company) > 0) {
    if (password_verify($password, $company['0']['password'])) {
      $error = '';
      $userId = $dbh->getAziendaID($email);
      $userType = 'company';
      $result = 'loggin succesfull';
      $_SESSION['user_id'] = $userId;
      $_SESSION['user_type'] = $userType;
    } else {
      $error = 'invalid mail or password';
      $userId = 'invalid';
      $result = 'not logged';
      $userType = 'company';
    }
  } elseif(count($moderator) > 0) {
    if (password_verify($password, $moderator['0']['password'])) {
      $error = '';
      $userId = $dbh->getModeratorID($email);
      $userType = 'moderator';
      $result = 'loggin succesfull';
      $_SESSION['user_id'] = $userId;
      $_SESSION['user_type'] = $userType;
    } else {
      $error = 'invalid mail or password';
      $userId = 'invalid';
      $result = 'not logged';
      $userType = 'moderator';
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
    'usertype' => $userType
  );

  echo json_encode($message);
}
