<?php

namespace App\Models;
use App\Config\Database;

class Missions {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    function getMissions() :mixed {
        $sql = "SELECT * FROM missions";
        $params = [];
        return $this->db->executeQuery($sql, $params);        
    }

    function createMission($mission_name) :void {
        $sql = "INSERT INTO mission (mission_name) VALUES (:mission_name)";
        $params = ['mission_name' => $mission_name];
        $this->db->executeQuery($sql, $params);
    }

    function updateMission($id) :void {
        $sql = "UPDATE missions SET status = :status WHERE id = :id";
        $params = ['id' => $id];
        $this->db->executeQuery($sql, $params);
    }

    function totalMission() :void {
        $sql = "SELECT COUNT(*) as total FROM missions";
        $params = [];
        $this->db->executeQuery($sql, $params);
    }

    function totalMissionCompleted() :void {
        $sql = "SELECT COUNT(*) as completed FROM missions WHERE status = 'terminée'";
        $params = [];
        $this->db->executeQuery($sql, $params);
    }
}
