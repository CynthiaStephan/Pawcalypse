<?php

namespace App\Models;
use App\Config\Database;

class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

 /**
 * Retrieves a user by their username.
 *
 * Executes an SQL query to fetch user details based on the provided username.
 * Uses the `executeQuery` method of the `Database` class to run the query.
 *
 * @param string $username The username of the user to fetch.
 *
 * @return array An associative array of user data, or an empty array if not found.
 *
 * @throws \Exception If an error occurs during the query execution.
 * 
 */
    public function getUser(string $username): array {
        //préparer la requête SQL
        $sql = "SELECT * FROM users WHERE username = :username";
        // insérer les params utile pour la requête
        $params = ['username' => $username];
        // exécution de la req via la methode executeQuery de Database
        return $this->db->executeQuery($sql, $params);
    }
}