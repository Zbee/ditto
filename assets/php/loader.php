<?php

echo getenv("db-host");
echo getenv("db-base");
echo getenv("db-user");
echo getenv("db-pass");
die();
  
#Connect to MySQL
try {
  $db = new PDO(
    "mysql:host=" . getenv("db-host") . ";dbname=" . getenv("db-base") . ";charset=utf8",
    getenv("db-user"),
    getenv("db-pass")
  );
} catch (Exception $e) {
  var_dump($e);
  die();
  die("MySQL could not connect<br>$e");
}

#Include ditto library
try {
  require_once(__DIR__ . "/ditto.php");
  $ditto = new ditto;
} catch (Exception $e) {
  die("Ditto exception<br>" . $e);
}
