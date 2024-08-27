<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/global.php');

$dbName = DB_NAME;
$dbHost = DB_HOST;

$dsn = "mysql:host=$dbHost; dbname=$dbName";


try {
    $db = new PDO($dsn, DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    print 'Erreur' . $e->getMessage();
}
