<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database.php"); //database directory
$dbh = new Database();
echo $dbh->getErrorString();