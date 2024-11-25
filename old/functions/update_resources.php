<?php
require_once './autoload.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_resource'])) {
    foreach ($_POST['new_quantity'] as $id => $quantity) {
        if (is_numeric($quantity)) {
            updateRessource($id, $resource_quantity, $pdo);
        }
    }
}

header('Location: /dashboard.php');
