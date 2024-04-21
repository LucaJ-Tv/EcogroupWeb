<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/validators.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/utils/questionari.php");
  require_once($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php");
  global $dbh;

  header('Content-Type: application/json');

  $titolo = isset($_POST['titolo']) ? $_POST['titolo'] : '';
  // bisogna creare un file con tutte le domande del questionario con titolo obbligatorio
  $error = '';
  $result = '';

  $questionario = $dbh->getQuestionarioByTitolo($titolo);
  if (count($questionario) > 0){
    $codQuestionario = $questionario[0]['codQuestionario'];
    $domandeQuestionario = $dbh->getDomandaQuestionarioByQuestionarioID($codQuestionario);
    foreach ($domandeQuestionario as &$domanda) {
      $infoDomanda = $dbh->getDomandaByCodDomanda($domanda['DOMANDE_codDomanda']);
      $domanda['testo'] = $infoDomanda[0]['testo'];
      $scelte = $dbh->getScelteByCodDomanda($domanda['DOMANDE_codDomanda']);
      $domanda['scelteValori'] = array_column($scelte, 'valore');
      $domanda['sceltePesi'] = array_column($scelte, 'peso');
    }
    $result = $domandeQuestionario;
  } else {
    $error = 'questionario non presente';
  }

  $message = array(
    'titolo' => $titolo,
    'result' => $result,
    'error' => $error
  );

  echo json_encode($message);
}