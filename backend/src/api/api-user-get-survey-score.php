<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');
  
  $error = '';
  $result = '';

  $codAzienda = isset($_POST['codAzienda']) ? $_POST['codAzienda'] : '';
  
  $codQuestionari = $dbh->getAllQuestionarioCompilatoByCodAzienda($codAzienda); 
  if(count($codQuestionari) > 0) {
    foreach ($codQuestionari as $codQuestionario) {
      $codQuestionarioCompilato = $dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario, $codAzienda);
      $result = $dbh->getRisposteByCodQuestionario($codQuestionarioCompilato[0]['codQuestionarioCompilato']);
    }
  }
  
  $message = array(
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}