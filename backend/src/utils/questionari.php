<?php

require($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php"); //database directory

function creaScelteAssociativo($valori, $codDomande) {
    $arrayAssociativo = array_map(function ($valore, $codDomanda) {
        return array(
            'valore' => $valore,
            'codDomanda' => $codDomanda,
        );
    }, $valori, $codDomande);
    return $arrayAssociativo;
}

function calcolaPunteggio($punteggioMassimo, $punteggioOttenuto) {
    $percentuale = ($punteggioOttenuto / $punteggioMassimo) * 100;
    $risultato = max(0, min(100, $percentuale));
    return round($risultato);
}

function creaQuestionarioCompilato($titoli, $punteggi) {
    $arrayAssociativo = array_map(function ($titolo, $punteggio) {
        return array(
            'titolo' => $titolo,
            'punteggio' => $punteggio,
        );
    }, $titoli, $punteggi);
    $id = 1;
    foreach($arrayAssociativo as &$punteggio) {
        $punteggio['id'] = $id;
        $id++;
    }
    return $arrayAssociativo;
}