<?php

require($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php"); //database directory

function creaScelteAssociativo($scelte) {
    $valori = array_column($scelte, 'valore');
    $pesi = array_column($scelte, 'peso');
    $arrayAssociativo = array_map(function ($valore, $peso){
        return array(
            'valore' => $valore,
            'peso' => $peso,
        );
    }, $valori, $pesi);
    return $arrayAssociativo;
}