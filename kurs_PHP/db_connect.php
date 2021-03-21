<?php
$dbServer = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'kurs_php';

$mysqli = new mysqli($dbServer, $dbUser, $dbPassword, $dbName);
$mysqli->set_charset("utf8");

if (mysqli_connect_error()) {
    echo 'Błąd bazy';
}
