<?php
require_once './autoload.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mission_name = $_POST['mission_name'];
    $resource_id = intval($_POST['resource_id']);
    $resource_quantity = intval($_POST['resource_quantity']);

    // Vérifier si la ressource est disponible en quantité suffisante
    $ressource = getRessource($ressource_id, $pdo);

    if ($ressource && $ressource['quantity'] >= $resource_quantity) {

        updateRessource($ressource_id,$resource_quantity, $pdo);

        $mission_id = createMission($mission_name, $pdo);

        createRessourceUsage($mission_id, $ressource_id, $resource_quantity, $pdo);
        
        header('Location: /dashboard.php');
        
    } else {
        header('Location: /dashboard.php?message=Quantité insuffisante pour allouer cette reccource.');
    }
        
} else {
    header('Location: /dashboard.php');
}
