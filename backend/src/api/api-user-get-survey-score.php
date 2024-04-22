<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/questionari.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');
  
  $error = '';
  $result = '';
  $titoliQuestionari = [];
  $punteggiOttenuti = [];

  $codAzienda = isset($_POST['codAzienda']) ? $_POST['codAzienda'] : '';
  $codQuestionari = $dbh->getAllQuestionarioCompilatoByCodAzienda($codAzienda);

  if(count($codQuestionari) > 0) {
    foreach ($codQuestionari as $codQuestionario) {
      $titolo = $dbh->getTitoloByCodQuestionario($codQuestionario['QUESTIONARI_codQuestionario']);
      array_push($titoliQuestionari, $titolo[0]['titolo']);
      $codQuestionarioCompilato = $dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario['QUESTIONARI_codQuestionario'], $codAzienda);
      $rispostePunteggio = $dbh->getRisposteByCodQuestionario($codQuestionarioCompilato[0]['codQuestionarioCompilato']);
      $punteggioMax = 0;
      $punteggioOttenuto = 0;
      foreach ($rispostePunteggio as &$rispostaPunteggio) {
        $peso = $dbh->getDomandaQuestionarioByCodDomandaQuesrionario($rispostaPunteggio['codDomandaQuestionario']);
        $rispostaPunteggio['peso'] = $peso[0]['peso'];
        $punteggioOttenuto = $punteggioOttenuto + $rispostaPunteggio['peso'] * $rispostaPunteggio['punteggio'];
        $punteggioMax = $punteggioMax + $peso[0]['peso'];
      }
      $punteggiofinale = calcolaPunteggio($punteggioMax, $punteggioOttenuto);
      array_push($punteggiOttenuti, $punteggiofinale);

    }
  }
  $result = creaQuestionarioCompilato($titoliQuestionari, $punteggiOttenuti);
  
  $message = array(
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}