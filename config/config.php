<?php
$dsn = 'mysql:dbname=nekkai;host=localhost';
$user = 'root';
$password = '';

try {
    $connect = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion failed: ' . $e->getMessage();
}

?>