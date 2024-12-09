<?php

namespace App\Config;

use Exception;
use \PDO;
use \PDOException;

class Database{
    private string $db_name;
    private string $db_user;
    private string $db_pass;
    private string $db_host;
    private $pdo;
    public function __construct(string $db_name = "catworlddb", string $db_user = "devuser", string $db_pass = "devpass", string $db_host = "db"){
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    private function getPDO(): PDO{
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                http_response_code(500);
                die("Erreur de connexion : " . $error->getMessage());
            }
        }
        return $this->pdo;
    }
    /**
     * Execute the SQL request
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function executeQuery(string $sql, array $params = []): mixed {
        try {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare($sql);
            
            // Utiliser une boucle pour lier les parametres
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            // Si sql contient SELECT -> renvoie les données récupérés
            if (stripos($sql, 'SELECT') === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            http_response_code(200);
            return true; 

        } catch (PDOException $error) {
            http_response_code(500);
            die("Erreur lors de l'exécution de la requête : " . $error);
        }
    }

    /**
     * Return the id of the last insert element
     * @return int
     */
    public function getLastInsertId(): int {
        try {
            $pdo = $this->getPDO();
            return(int)$pdo->lastInsertId();
        } catch (PDOException $error) {
            die("Erreur lors de la récupération de l'id :  " . $error->getMessage());
        }
    }

}
