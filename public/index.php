<?php

use App\Router;
use App\Routes\AdminRoutes;

require_once __DIR__ . '/../vendor/autoload.php';

// Initialiser Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/views/');
$twig = new \Twig\Environment($loader);

// Initialiser le routeur
$router = new Router();

$adminRoute = new AdminRoutes($router, $twig);
$adminRoute->setRoutes();

// Dispatch la requête entrante
$router->dispatch($_SERVER['REQUEST_URI']);
