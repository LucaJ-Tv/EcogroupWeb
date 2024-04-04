<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');
  
  $category = isset($_POST['categoria']) ? $_POST['categoria'] : '';

  if (count($dbh->isCategoryPresent($category)) > 0) {
    $error = 'Categoria già presente';
    $result = '';
  } elseif ($category != '') {
    $error = '';
    $dbh->createCategory($category);
    $result = 'Categoria aggiunta';
  } else {
    $error = 'Il campo non può essere nullo';
    $result = '';
  }

  $message = array(
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}