<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  //qui ci dovrebbe essere un modo usando session per recuperare l'id delladmin nel dubbio per ora lid è sempre uno
  $id_admin = 1;
  $text = isset($_POST['testo']) ? $_POST['testo'] : '';
  $category = isset($_POST['categoria']) ? $_POST['categoria'] : '';
  $isPositive = isset($_POST['isPositive']) ? $_POST['isPositive'] : '';
  $risposte = isset($_POST['risposte']) ? $_POST['risposte'] : '';

  $rispostepulite = stringToArray($risposte);

  if ($text == '' || $isPositive == '' || $category == '' || $id_admin == '' || count($rispostepulite) < 2 ) {
    $error = 'tutti i campi devono essere compilati';
    if (count($rispostepulite) < 2 ) 
      $error = 'una domanda deve avere almeno due risposte';
    $result = '';
  } else {
    if($isPositive == 'true') {
      $isPositive = 1;
    } else {
      $isPositive = 0;
    }
    $dbh->addDomanda($isPositive, $text, $category, $id_admin);
    $sceltePeso = calcolaPesi($rispostepulite);
    $codDomanda = $dbh->getDomandaID($text);
    foreach ($sceltePeso as $scelta) {
      $dbh->addScelte($scelta['scelta'], $scelta['peso'], $codDomanda);
    }
    $error = '';
    $result = 'domanda aggiunta con successo!';
  }

  $message = array(
    'test' => $isPositive,
    'error' => $error,
    'result' => $result,
  );

  echo json_encode($message);
}