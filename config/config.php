<?php
try {
    $pdo = new PDO('mysql:host=db;dbname=catworlddb', 'devuser', 'devpass');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
