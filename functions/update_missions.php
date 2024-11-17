<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mission_id = intval($_POST['mission_id']);
    $new_status = $_POST['new_status'];

    if (!in_array($new_status, ['planifiée', 'en cours', 'terminée'])) {
        die("Statut invalide.");
    }

    $stmt = $pdo->prepare("UPDATE missions SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $new_status, 'id' => $mission_id]);
}

header('Location: /dashboard.php');
exit();
?>
