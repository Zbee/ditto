<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  
#Connect to MySQL
try {
  $db = new PDO(
    "mysql:host=" . getenv("db-host") . ";dbname=" . getenv("db-base") . ";charset=utf8",
    getenv("db-user"),
    getenv("db-pass")
  );
} catch (Exception $e) {
  error_log($e);
  die("MySQL could not connect<br>$e");
}

die();

#Include ditto library
try {
  require_once(__DIR__ . "/ditto.php");
  $ditto = new ditto;
} catch (Exception $e) {
  die("Ditto exception<br>" . $e);
}
