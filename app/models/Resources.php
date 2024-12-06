<?php 
namespace App\Models;

use App\Config\Database;

class Resources{
    
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Fetches all resources from the database.
     *
     * @return array The list of resources.
     */
    public function getResources() :array {
        $sql = "SELECT * FROM resources";
        $params = [];
        return $this->db->executeQuery($sql, $params);
        
    }
 
    /**
     * Fetch the resource quantity by resource id
     * @param int $resource_id
     * @return mixed
     */
    public function getResource($resource_id) :mixed {

        $sql = "SELECT quantity FROM resources WHERE id = :resource_id";
        $params = ['resource_id' => $resource_id];
        return $this->db->executeQuery($sql, $params);
    }

    /**
     * Update the resource quantity
     * @param mixed $resource_id
     * @param mixed $resource_quantity
     * @return void
     */
    public function updateResource($resource_id, $resource_quantity) :void {
        $sql = "UPDATE resources SET quantity = quantity - :quantity WHERE id = :resource_id";
        $params = ['resource_id' => $resource_id, 'resource_quantity' => $resource_quantity];
        $this->db->executeQuery($sql, $params);
    }

    /**
     * Summary of createResourceUsage
     * @param mixed $mission_id
     * @param mixed $resource_id
     * @param mixed $resource_quantity
     * @return void
     */
    public function createResourceUsage($mission_id, $resource_id, $resource_quantity) :void {

        $sql = "INSERT INTO resource_usage (mission_id, resource_id, quantity_used) VALUES (:mission_id, :resource_id, :quantity_used)";
        $params = ['mission_id' => $mission_id, 'resource_id' => $resource_id,'resource_quantity'=> $resource_quantity];
        $this->db->executeQuery($sql, $params);
    }

}