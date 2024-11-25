<?php 

/**
 * Methode en charge de récupèrer des ressources
 * @param string $username
 * @param PDO $pdo
 * @return mixed
 */
function getRessoures(PDO $pdo) :mixed {
    try {
        
        $rows = $pdo->query("SELECT * FROM resources")->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        GenerateErrorDev($e);
    }
    return $rows;
    
}
/**
 * Methode en charge de récupèrer une ressource
 * @param int $ressource_id
 * @param PDO $pdo
 * @return mixed
 */
function getRessource($ressource_id, PDO $pdo) :mixed {
    try {
        
        $stmt = $pdo->prepare("SELECT quantity FROM resources WHERE id = :ressource_id");
        $stmt->execute(['ressource_id' => $ressource_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        GenerateErrorDev($e);
    }
    return $row;
}
/**
 * Methode en charge de mettre à jour une ressource
 * @param int $ressource_id
 * @param PDO $pdo
 * @return void
 */
function updateRessource($ressource_id,$resource_quantity, PDO $pdo) :void {
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("UPDATE resources SET quantity = quantity - :quantity WHERE id = :ressource_id");
        $stmt->execute(['quantity' => $resource_quantity, 'ressource_id' => $ressource_id]);
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        GenerateErrorDev($e);
    }
}
/**
 * Methode en charge de d'inserer l'usage d'une ressource
 * @param int $ressource_id
 * @param PDO $pdo
 * @return void
 */
function createRessourceUsage($mission_id, $ressource_id, $resource_quantity, PDO $pdo) :void {
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO resource_usage (mission_id, resource_id, quantity_used) VALUES (:mission_id, :resource_id, :quantity_used)');
        $stmt->execute([
            'mission_id' => $mission_id,
            'resource_id' => $ressource_id,
            'quantity_used' => $resource_quantity
        ]);
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        GenerateErrorDev($e);
    }
}