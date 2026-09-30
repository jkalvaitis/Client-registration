<?php
$servername = 'localhost';
$username = 'test';
$password = 'password1234';
$dbname = 'klienti';

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

try {
    $db = new PDO("mysql:host=$servername;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $db->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $db->exec("USE `$dbname`");

    $db->exec("CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        surname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL
    ) DEFAULT CHARSET=utf8mb4");
}
catch (PDOException $e) {
    error_log($e->getMessage());
    die("Neizdevās izveidot savienojumu ar datubāzi");
}

?>
