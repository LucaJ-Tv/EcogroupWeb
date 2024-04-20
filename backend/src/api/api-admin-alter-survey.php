<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $error = '';
  $result = '';
  //questionario
  $titolo = isset($_POST['titolo']) ? $_POST['titolo'] : '';
  $codQuestionario = isset($_POST['codQuestionario']) ? $_POST['codQuestionario'] : '';
  //modifiche
  $codModeratore = isset($_POST['codModeratore']) ? $_POST['codModeratore'] : '';
  $commento = isset($_POST['commento']) ? $_POST['commento'] : '';
  //domande_Questionari
  $numeroDomande = isset($_POST['numeroDomanda']) ? $_POST['numeroDomanda'] : '';
  $pesoDomande = isset($_POST['peso']) ? $_POST['peso'] : '';
  $codDomande = isset($_POST['codDomanda']) ? $_POST['codDomanda'] : '';
  $sezioneDomande = isset($_POST['sezione']) ? $_POST['sezione'] : '';
  $sezioneDomande = stringToArray($sezioneDomande);
  $numeroDomande = stringToArray($numeroDomande);
  $pesoDomande = stringToArray($pesoDomande);
  $codDomande = stringToArray($codDomande);

  $domande = combinaArrayAssociativo($numeroDomande, $pesoDomande, $codDomande, $sezioneDomande);

  if ($titolo == '' || count($dbh->getQuestionarioByTitoloDiverso($titolo, $codQuestionario))) {
    $error = 'il titolo è invalido';
  } else {
    $dbh->modificaTitoloQuestionario($titolo, $codQuestionario);
    if($commento != '' && $codModeratore != '') {
      $dbh->createModifica($codModeratore, $commento, $codQuestionario);
      $dbh->eliminateAllDomandaQuestionarioByQuestionarioId($codQuestionario);
      foreach ($domande as $question){
        $dbh->createDomandaQuestionario($question['numeroDomanda'], $question['peso'], $question['codDomanda'], $question['sezioni_nome'], $codQuestionario);
      }
      $result = 'questionario modificato';
    } else {
      $error = 'commento non valido';
    }
  }

  $message = array(
    'error' => $error,
    'result' => $result
  );
  
  echo json_encode($message);
}