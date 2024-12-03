<?php

namespace App\Config;

use \PDO;
use \PDOException;

class Database{
    private string $bd_name;
    private string $db_user;
    private string $db_pass;
    private string $db_host;
    private $pdo;
    public function __construct(string $bd_name = "catworlddb", string $db_user = "devuser", string $db_pass = "devpass", string $db_host = "bd"){
        $this->bd_name = $bd_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    private function getPDO(){
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO("mysql:host={$this->db_host};dbname={$this->bd_name}", $this->db_user, $this->db_pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                http_response_code(500);
                die("Erreur de connexion : " . $error->getMessage());
            }
        }
        return $this->pdo;
    }

    public function query(string $stmt): array {
        try {
            $req = $this->getPDO()->query($stmt);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            http_response_code(500);
            die("Erreur lors de l'exécution de la requette". $error->getMessage());
        }
    }

}