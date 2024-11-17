<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_resource'])) {
    foreach ($_POST['new_quantity'] as $id => $quantity) {
        if (is_numeric($quantity)) {
            $stmt = $pdo->prepare("UPDATE resources SET quantity = :quantity WHERE id = :id");
            $stmt->execute(['quantity' => $quantity, 'id' => $id]);
        }
    }
}

header('Location: /dashboard.php');
exit();
?>
