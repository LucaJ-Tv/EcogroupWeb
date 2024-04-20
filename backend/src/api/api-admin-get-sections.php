<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $codQuestionario = isset($_POST['codQuestionario']) ? $_POST['codQuestionario'] : '';
  $response = $dbh->getSezioniByCodQuestionario($codQuestionario);
  
  echo json_encode($response);
}