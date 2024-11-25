<?php
try {
    $pdo = new PDO('mysql:host=db;dbname=catworlddb', 'devuser', 'devpass');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    die("Erreur de connexion : " . $error->getMessage());
}