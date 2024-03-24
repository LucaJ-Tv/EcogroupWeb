<?php

$database_data = array(
    "server" => "mysql-1",
    "user" => "root",
    "password" => "ecogroup1",
    "dbname" => "eco_group",
    "port" => "23306"
);


define("CONF_DATABASE", $database_data);
define("LOGIN_HASH", getenv("LOGIN_HASH"));