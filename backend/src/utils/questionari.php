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