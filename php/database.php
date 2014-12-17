<?php

$my_credentials = [
    // TODO: CIT CREDENTIALS HERE!
    // mysql -h127.0.0.1 -uhomestead -P33060 -psecret
    "host"     => "127.0.0.1",
    "username" => "homestead",
    "password" => "secret",
    "database" => "cs4000_fun",
    "port"     => 33060
];

$cit_credentials = [
    "host"     => "mysql.cs.dixie.edu",
    "username" => "eaybar",
    "password" => "MYBIGSECRET!!!!",
    "database" => "eaybar",
    "port"     => 3306
];

$credentials = $cit_credentials;

$DB = new \App\MyPdo(
    $credentials["host"],
    $credentials["username"],
    $credentials["password"],
    $credentials["database"],
    $credentials["port"]
);