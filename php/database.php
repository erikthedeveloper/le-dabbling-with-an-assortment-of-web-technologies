<?php

$credentials = [
  // TODO: CIT CREDENTIALS HERE!
  // mysql -h127.0.0.1 -uhomestead -P33060 -psecret
  "host"     => "127.0.0.1",
  "username" => "homestead",
  "password" => "secret",
  "database" => "cs4000_fun"
];

$DB = new \App\MyPdo(
  $credentials["host"],
  $credentials["username"],
  $credentials["password"],
  $credentials["database"],
  33060
);