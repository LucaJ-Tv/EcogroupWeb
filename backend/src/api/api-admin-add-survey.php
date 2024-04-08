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

  $QuestionsNumber = stringToArray($QuestionsNumber);
  $QuestionsPeso = stringToArray($QuestionsPeso);
  $questionsId = stringToArray($QuestionsId);

  $Questions = combinaArrayAssociativo($QuestionsNumber, $QuestionsPeso, $questionsId);

  $error = '';
  $result = '';

  if ($adminID == '') {
    $error = 'devi essere un admin per poter creare questionari';
  } elseif ($title == '') {
    $error = 'il questionario non ha titolo';
  } elseif ($QuestionsNumber == '') {
    $error = 'il questionario non ha domande';
  } else {
    if(count($dbh->getQuestionarioByTitolo($title)) != 0){
      $error = 'il titolo del questionario è già presente';
    } else {
      $dbh->createQuestionario($title);
      $idQuestionario = $dbh->getQuestionarioID($title);
      foreach ($Questions as $question){
        $dbh->createDomandaQuestionario($question['numeroDomanda'], $question['peso'], $question['codDomanda'], $idQuestionario);
      }
      $result = 'Questionario aggiunto';
    }
  }

  $message = array(
    'questionarioId' => $QuestionsId,
    'questionario peso' => $QuestionsPeso,
    'questionario numero' => $QuestionsNumber,
    'error' => $error,
    'result' => $result
  );

  echo json_encode($message);
}