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

  $codQuestionario = isset($_POST['codQuestionario']) ? $_POST['codQuestionario'] : '';
  $codAzienda = isset($_POST['codAzienda']) ? $_POST['codAzienda'] : '';
  $codDomande = isset($_POST['codDomande']) ? $_POST['codDomande'] : '';
  $valoreRisposte = isset($_POST['risposte']) ? $_POST['risposte'] : '';

  // creo un qeustionario compilato
  // ha dataCompilazione, QUESTIONARI_codQuestionario, aziende_codAzienda
  if($codQuestionario != '' && $codAzienda != '' && $codDomande != '' && $valoreRisposte) {
    if(count($dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario, $codAzienda)) > 0) {
      $error = 'Questionario già stato compilato in precedenza';
    } else {
      $dbh->createQuestionarioCompilato($codQuestionario, $codAzienda);
      $codQuestionarioCompilato = $dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario, $codAzienda);
      $codDomande = stringToArray($codDomande);
      $valoreRisposte = stringToArray($valoreRisposte);
      $risposte = creaScelteAssociativo($valoreRisposte, $codDomande);
      foreach ($risposte as $risposta) {
        $dbh->createRisposta($risposta['valore'], $codQuestionarioCompilato[0]['codQuestionarioCompilato'], $risposta['codDomanda']);
      }
    }
  }
  // creo la risposta
  // ha punteggio, QUESTIONARI_COMPILATI_codQuestionarioCompilato, DOMANDE_QUESTIONARI_codDomandaQuestionario

  // se tutto va bene il risultato è questionario compilato
  //$dbh->getErrorString()
  
  $message = array(
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}