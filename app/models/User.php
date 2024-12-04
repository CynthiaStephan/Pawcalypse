<?php

namespace App\Models;
use App\Config\Database;

// class User {
//     private $users = [
//         ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
//         ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
//     ];

//     public function getAllUsers() {
//         return $this->users;
//     }

//     public function getUserById($id) {
//         foreach ($this->users as $user) {
//             if ($user['id'] == $id) {
//                 return $user;
//             }
//         }
//         return null;
//     }
// }

class User {
    private $db;
    
    // ré
    public function __construct() {
        $this->db = new Database();
    }

    public function getUser(string $username): array {
        $sql = "SELECT * FROM users WHERE username = :username";
        $params = ['username' => $username];
        return $this->db->executeQuery($sql, $params);
    }
}