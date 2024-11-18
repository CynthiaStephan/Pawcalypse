<?php

namespace App;

class Router {
    private array $routes = [];

    public function __construct() {
        
    }

    // Ajouter une route
    public function add($path, $callback) {
        $this->routes[$path] = $callback;
    }
    
    // Dispatch la requête vers la bonne méthode
    public function dispatch($uri) {
        $path = parse_url($uri, PHP_URL_PATH);

        if (array_key_exists($path, $this->routes)) {
            $callback = $this->routes[$path];

            // Exécuter la closure associée
            if (is_callable($callback)) {
                call_user_func($callback);
            } else {
                $this->sendNotFound("La route existe, mais la fonction associée est invalide.");
            }
        } else {
            $this->sendNotFound("Route introuvable.");
        }
    }

    // Gestion des erreurs 404
    private function sendNotFound($message) {
        http_response_code(404);
        echo "<h1>404 Not Found</h1><p>$message</p>";
    }
}
