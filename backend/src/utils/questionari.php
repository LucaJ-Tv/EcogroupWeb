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

function rimuoviColonna(&$array, $colonnaDaRimuovere) {
    foreach ($array as &$row) {
        unset($row[$colonnaDaRimuovere]);
    }
}

function estraiCodiciETitoli($array) {
    $numero = 1;
    $risultato = array();
    $codiciPresenti = array();
    foreach ($array as $elemento) {
        $codice = $elemento['codQuestionario'];
        if(!in_array($codice, $codiciPresenti)){
            $titolo = $elemento['titolo'];
            $risultato[] = array(
                'ordine' => $numero,
                'codQuestionario' => $codice,
                'titolo' => $titolo);
            $codiciPresenti[] = $codice;
            $numero++;
        }
    }
    return $risultato;
}