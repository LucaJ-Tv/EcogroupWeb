<?php 

require($_SERVER["DOCUMENT_ROOT"]."/bootstrap.php"); //database directory

function is_valid_email($email) {
    if(empty($email)) {
        return false;
    }
    $filtered_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$filtered_email || $filtered_email === false) {
        return false;
    } else {
        global $dbh;
        if(count($dbh->isMailPresent($email)) == 0)
            return true;
        else
            return false;
    }
}

function is_valid_name($nome){
    if(empty($nome)) {
        return false;
    }
    else {
        global $dbh;
        if(count($dbh->isNamePresent($nome)) == 0)
            return true;
        else
            return false;
    }
}

function is_only_numbers($codice) {
    return preg_match('/^[0-9]+$/', $codice);
}