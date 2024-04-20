<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $codQuestionario = isset($_POST['codQuestionario']) ? $_POST['codQuestionario'] : '';
  
  $domande = $dbh->getAllDomande();
  $domandeQuestionari = $dbh->getDomandaQuestionarioByQuestionarioID($codQuestionario);
  // var_dump($domandeQuestionari);

  foreach ($domande as &$domanda) {
    $domanda['peso'] = '1';
    $domanda['sezione'] = '';
    $domanda['numero'] = '';
    $domanda['inserire'] = false;
    foreach ($domandeQuestionari as $valoriAggiunti) {
      if ($domanda['codDomanda'] == $valoriAggiunti['DOMANDE_codDomanda']) {
        $domanda['peso'] = $valoriAggiunti['DOMANDE_codDomanda'];
        $domanda['sezione'] = $valoriAggiunti['sezioni_nome'];
        $domanda['numero'] = $valoriAggiunti['DOMANDE_codDomanda'];
        $domanda['inserire'] = true;
      }
    }
  }
  echo json_encode($domande);
}