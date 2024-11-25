<?php
require_once './autoload.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mission_id = intval($_POST['mission_id']);
    $new_status = $_POST['new_status'];

    $allowed_status = [
        'planifiée',
        'en cours',
        'terminée'

    ];

    if (!in_array($new_status,$allowed_status)) {
        die('Statut invalide !');
    }

    updateMission($mission_id, $pdo);
}

header('Location: /dashboard.php');
