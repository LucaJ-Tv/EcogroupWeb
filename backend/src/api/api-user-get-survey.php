<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $titolo = isset($_POST['titolo']) ? $_POST['titolo'] : '';
  // bisogna creare un file con tutte le domande del questionario con titolo obbligatorio
  $error = '';
  $result = '';

  $questionario = $dbh->getQuestionarioByTitolo($titolo);
  if( count($questionario) > 0){
    $codQuestionario = $questionario['codQuestionario'];
    $result = $dbh->getDomandaQuestionarioByQuestionarioID($codQuestionario);
  } else {
    $error = 'questionario non presente';
  }
  
  $message = array(
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}