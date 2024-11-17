<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mission_name = $_POST['mission_name'];
    $resource_id = intval($_POST['resource_id']);
    $resource_quantity = intval($_POST['resource_quantity']);

    // Vérifier si la ressource est disponible en quantité suffisante
    $stmt = $pdo->prepare("SELECT quantity FROM resources WHERE id = :resource_id");
    $stmt->execute(['resource_id' => $resource_id]);
    $resource = $stmt->fetch();

    if ($resource && $resource['quantity'] >= $resource_quantity) {
        // Déduire les ressources
        $stmt = $pdo->prepare("UPDATE resources SET quantity = quantity - :quantity WHERE id = :resource_id");
        $stmt->execute(['quantity' => $resource_quantity, 'resource_id' => $resource_id]);

        // Ajouter la mission
        $stmt = $pdo->prepare("INSERT INTO missions (mission_name, status) VALUES (:mission_name, 'planifiée')");
        $stmt->execute(['mission_name' => $mission_name]);

        // Associer les ressources utilisées à la mission
        $mission_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO resource_usage (mission_id, resource_id, quantity_used) VALUES (:mission_id, :resource_id, :quantity)");
        $stmt->execute([
            'mission_id' => $mission_id,
            'resource_id' => $resource_id,
            'quantity' => $resource_quantity
        ]);

        header('Location: /dashboard.php');
        exit();
    } else {
        echo "Quantité insuffisante pour allouer cette ressource.";
    }
}
?>
