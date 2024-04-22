<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/questionari.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');
  
  $error = '';
  $result = '';

  $AllQuestionari = $dbh->getAllQuestionariCompilati();
  $QuestionarioSingolo = estraiCodiciETitoli($AllQuestionari);

  foreach ($AllQuestionari as &$questionario) {
    $codQuestionarioCompilato = $questionario['codQuestionarioCompilato'];
    $codAzienda = $questionario['aziende_codAzienda'];
    $rispostePunteggio = $dbh->getRisposteByCodQuestionario($codQuestionarioCompilato);
    $punteggioMax = 0;
    $punteggioOttenuto = 0;
    foreach ($rispostePunteggio as &$rispostaPunteggio) {
      $peso = $dbh->getDomandaQuestionarioByCodDomandaQuestionario($rispostaPunteggio['codDomandaQuestionario']);
      $rispostaPunteggio['peso'] = $peso[0]['peso'];
      $punteggioOttenuto = $punteggioOttenuto + $rispostaPunteggio['peso'] * $rispostaPunteggio['punteggio'];
      $punteggioMax = $punteggioMax + $peso[0]['peso'];
    }
    $nomeAzienda = $dbh->getNomeAziendaByCodAzienda($codAzienda);
    $punteggiofinale = calcolaPunteggio($punteggioMax, $punteggioOttenuto);
    $questionario['nomeAzienda'] = $nomeAzienda[0]['username'];
    $questionario['punteggio'] = $punteggiofinale;
  }

  rimuoviColonna($AllQuestionari, 'titolo');
  rimuoviColonna($AllQuestionari, 'codQuestionarioCompilato');
  rimuoviColonna($AllQuestionari, 'QUESTIONARI_codQuestionario');

  $message = array(
   'error' => $error,
   'surveys' => $QuestionarioSingolo,
   'scores' => $AllQuestionari
  );

  echo json_encode($message);
}