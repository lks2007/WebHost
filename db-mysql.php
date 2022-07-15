<?php

require_once 'config-mysql.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch (PDOException $pe) {
    die("Could not connect to the database $db :" . $pe->getMessage());
}
?>