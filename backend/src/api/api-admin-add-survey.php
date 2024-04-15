<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $adminID = isset($_POST['adminID']) ? $_POST['adminID'] : '';
  $title = isset($_POST['titolo']) ? $_POST['titolo'] : '';
  $QuestionsNumber = isset($_POST['numeroDomanda']) ? $_POST['numeroDomanda'] : '';
  $QuestionsPeso = isset($_POST['peso']) ? $_POST['peso'] : '';
  $QuestionsId = isset($_POST['codDomanda']) ? $_POST['codDomanda'] : '';
  $QuestionsSection = isset($_POST['sezione']) ? $_POST['sezione'] : '';

  $sectionToAdd = isset($_POST['sezioniDaAggiungere']) ? $_POST['sezioniDaAggiungere'] : '';

  $questionsSection = stringToArray($QuestionsSection);
  $sectionToAdd = stringToArray($sectionToAdd);
  $QuestionsNumber = stringToArray($QuestionsNumber);
  $QuestionsPeso = stringToArray($QuestionsPeso);
  $questionsId = stringToArray($QuestionsId);

  $Questions = combinaArrayAssociativo($QuestionsNumber, $QuestionsPeso, $questionsId, $questionsSection);

  $error = '';
  $result = '';

  if ($adminID == '') {
    $error = 'devi essere un admin per poter creare questionari';
  } elseif ($title == '') {
    $error = 'il questionario non ha titolo';
  } elseif ($QuestionsNumber == '') {
    $error = 'il questionario non ha domande';
  } elseif ($sectionToAdd == '') {
    $error = 'il questionario non ha sezioni'; 
  } else {
    if(count($dbh->getQuestionarioByTitolo($title)) != 0){
      $error = 'il titolo del questionario è già presente';
    } else {
      $dbh->createQuestionario($title);
      $idQuestionario = $dbh->getQuestionarioID($title);
      $dbh->createSezioni($sectionToAdd, $idQuestionario);
      foreach ($Questions as $question){
        $dbh->createDomandaQuestionario($question['numeroDomanda'], $question['peso'], $question['codDomanda'], $question['sezioni_nome'], $idQuestionario);
      }
      $result = 'Questionario aggiunto';
    }
  }

  $message = array(
    'error' => $error,
    'result' => $result
  );

  echo json_encode($message);
}