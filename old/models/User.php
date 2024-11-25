<?php 

/**
 * Methode en charge de récupèrer un utilisateur
 * @param string $username
 * @param PDO $pdo
 * @return mixed
 */
function getUser(string $username, PDO $pdo) :mixed {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        GenerateErrorDev($e);
    }
    return $stmt->fetch(PDO::FETCH_BOTH);
    
}