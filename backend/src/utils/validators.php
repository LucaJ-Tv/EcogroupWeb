<?php 

require($_SERVER["DOCUMENT_ROOT"]."/www/bootstrap.php"); //database directory

function is_valid_email($email) {
    if(empty($email)) {
        return false;
    }
    $filtered_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$filtered_email || $filtered_email === false) {
        return false;
    } else {
        global $dbh;
        if(count($dbh->isMailCompanyPresent($email)) == 0 && count($dbh->isMailModeratorPresent($email)) == 0) {
            return true;
        } else {
            return false;
        }
    }
}

function is_valid_name($nome) {
    if(empty($nome)) {
        return false;
    } else {
        global $dbh;
        if (count($dbh->isNamePresent($nome)) == 0) {
            return true;
        } else {
            return false;
        }
    }
}

function is_valid_username($nome) {
    if(empty($nome)) {
        return false;
    } else {
        global $dbh;
        if (count($dbh->isUsernamePresent($nome)) == 0) {
            return true;
        } else {
            return false;
        }
    }
}

function is_valid_password($password) {
    if(empty($password)) {
        return false;
    } else {
        if(!containsNumber($password)) {
            return false;
        }
        if(strlen($password) < 8) {
            return false;
        }
        return true;
    }
}

function clear_CER($codicicer) {
    $codicipuliti = explode(',', $codicicer);
    $result = array_map('trim',$codicipuliti);
    return $result;
}

function validate_CER($codicicer) {
    foreach ( $codicicer as $codice) {
        if(!is_only_numbers($codice)) {
            return false;
        }
    }
    return true;
}

function is_only_numbers($codice) {
    return preg_match('/^[0-9]+$/', $codice);
}

function containsNumber($value){
    return (preg_match('~[0-9]+~', $value));
}

function stringToArray($inputString) {
    $arraypulito = explode(',', $inputString);
    $arraypulito = array_map('trim', $arraypulito);
    return $arraypulito;
}

function calcolaPesi($scelte) {
    $pesoStep = 1 / (count($scelte) - 1);
    $pesoCorrente = 0;
    $arrayAssociativo = [];

    foreach ($scelte as $scelta) {
        $arrayAssociativo[] = [
            'scelta' => $scelta,
            'peso' => number_format($pesoCorrente, 2)
        ];
        $pesoCorrente += $pesoStep;
    }

    return $arrayAssociativo;
}