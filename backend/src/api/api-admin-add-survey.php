<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $adminID = isset($_POST['adminID']) ? $_POST['adminID'] : '';
  $title = isset($_POST['titolo']) ? $_POST['titolo'] : '';
  $Questions = isset($_POST['domande']) ? $_POST['domande'] : '';

  
  $message = array(
    'admin' => $adminID,
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}