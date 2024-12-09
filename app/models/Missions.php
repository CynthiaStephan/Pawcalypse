<?php

namespace App\Models;
use App\Config\Database;

class Missions {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    function getMissions() : mixed {
        $sql = "SELECT * FROM missions";
        $params = [];
        return $this->db->executeQuery($sql, $params);        
    }

    function createMission($mission_name) : int {
        $sql = "INSERT INTO missions (mission_name) VALUES (:mission_name)";
        $params = ['mission_name' => $mission_name];
        $this->db->executeQuery($sql, $params);
        $lastId = $this->db->getLastInsertId();
        return $lastId;
    }

    function updateMission($id, $new_status) : void {
        $sql = "UPDATE missions SET status = :status WHERE id = :id";
        $params = ['id' => $id, 'status'=> $new_status];
        $this->db->executeQuery($sql, $params);
    }

    function totalMission() : mixed {
        $sql = "SELECT COUNT(*) as total FROM missions";
        $params = [];
        $result = $this->db->executeQuery($sql, $params);
        return $result[0]['total'] ?? 0;
    }

    function totalMissionCompleted() : mixed {
        $sql = "SELECT COUNT(*) as completed FROM missions WHERE status = 'terminée'";
        $params = [];
        $result = $this->db->executeQuery($sql, $params);
        return $result[0]['completed'] ?? 0;
    }
}
