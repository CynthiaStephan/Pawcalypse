<?php

namespace App\Models;
use App\Config\Database;

class Missions {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    
}
