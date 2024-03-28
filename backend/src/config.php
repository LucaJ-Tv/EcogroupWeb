<?php

$database_data = array(
    "server" => "localhost",
    "user" => "root",
    "password" => "",
    "dbname" => "eco_group",
    "port" => "3306"
);


define("CONF_DATABASE", $database_data);
define("LOGIN_HASH", getenv("LOGIN_HASH"));