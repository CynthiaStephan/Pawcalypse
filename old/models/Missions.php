<?php 

/**
 * Methode en charge de récupèrer toutes les missions
 * @param string $username
 * @param PDO $pdo
 * @return mixed
 */
function getMissions(PDO $pdo) :mixed {
    try {
        $rows = $pdo->query("SELECT * FROM missions")->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        GenerateErrorDev($e);
    }
    return $rows;
    
}
/**
 * Methode en charge de créer une mission
 * @param string $mission_name
 * @param PDO $pdo
 * @return mixed
 */
function createMission($mission_name, PDO $pdo) :mixed {
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO mission (mission_name) VALUES (:mission_name)');
        $stmt->execute(['mission_name' => $mission_name]);
        $pdo->commit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        GenerateErrorDev($e);
    }
    return $pdo->lastInsertId();
}
/**
 * Methode en charge de mettre à jour une mission
 * @param int $id
 * @param PDO $pdo
 * @return void
 */
function updateMission($id, PDO $pdo) :void {
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE missions SET status = :status WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $pdo->commit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        GenerateErrorDev($e);
    }
}
/**
 * Methode en charge de récupèrer le nombre de toutes les missions
 * @param PDO $pdo
 * @return mixed
 */
function totalMission(PDO $pdo) :mixed {
    try {
        $count = $pdo->query("SELECT COUNT(*) as total FROM missions")->fetch()['total'];

    } catch (PDOException $e) {
        GenerateErrorDev($e);
    }
    return $count;
}
/**
 * Methode en charge de récupèrer le nombre de mission completée
 * @param PDO $pdo
 * @return mixed
 */
function totalMissionCompleted($pdo) :mixed {
    try {
        $count = $pdo->query("SELECT COUNT(*) as completed FROM missions WHERE status = 'terminée'")->fetch()['completed'];

    } catch (PDOException $e) {
        GenerateErrorDev($e);
    }
    return $count;
}