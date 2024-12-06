<?php 

namespace App\Services;

class SessionManager
{
    public  static function init() : void
    {
        $sessionConfig = [
            'lifetime' => 3600,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Strict'
        ];
        session_set_cookie_params($sessionConfig);
        session_start();
    }
}
 