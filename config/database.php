<?php
try {
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $databaseName = 'final_project';
  $conn = new PDO("mysql:host=$server; dbname=$databaseName; charset=utf8", $username, $password);
} catch (PDOException $e) {
  echo  $e->getMessage();
}
function post($key){
  return $_POST[$key] ?? null;
}
