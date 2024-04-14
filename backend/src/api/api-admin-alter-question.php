<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $text = isset($_POST['testo']) ? $_POST['testo'] : '';
  $category = isset($_POST['categoria']) ? $_POST['categoria'] : '';
  $isPositive = isset($_POST['isPositive']) ? $_POST['isPositive'] : '';
  $codDomanda = isset($_POST['cod']) ? $_POST['cod'] : '';


  if ($text == '' || $isPositive == '' || $category == '') {
    $error = 'tutti i campi devono essere compilati';
    $result = '';
  } else {
    if($isPositive == 'true') {
      $isPositive = 1;
    } else {
      $isPositive = 0;
    }
    $dbh->updateDomanda($codDomanda, $text, $isPositive, $category);
    $error = '';
    $result = 'domanda modificata con successo!';
  }

  $message = array(
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}