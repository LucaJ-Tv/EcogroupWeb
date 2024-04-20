<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $titolo = isset($_POST['titolo']) ? $_POST['titolo'] : '';
  // bisogna creare un file con tutte le domande del questionario con titolo obbligatorio

  $questionario = $dbh->getQuestionarioByTitolo($titolo);
  var_dump($questionario);
  $codQuestionario = $questionario['codQuestionario'];

  $message = $dbh->getDomandaQuestionarioByQuestionarioID($codQuestionario);
  
  echo json_encode($message);
}