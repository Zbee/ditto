<?php
#Secret keys, passwords, connections
#require_once(__DIR__ . "/_secret_keys.php");

echo getenv("db-host");
die();

#Connect to MySQL
try {
  $db = new PDO(
    "mysql:host=" . getenv("db-host") . ";dbname=" . getenv("db-base") . ";charset=utf8",
    getenv("db-user"),
    getenv("db-pass")
  );
} catch (Exception $e) {
  die("MySQL could not connect<br>$e");
}

#Include ditto library
try {
  require_once(__DIR__ . "/ditto.php");
  $ditto = new ditto;
} catch (Exception $e) {
  die("Ditto exception<br>" . $e);
}
