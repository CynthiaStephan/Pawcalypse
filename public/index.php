<?php

use App\Router;
use App\Routes\AdminRoutes;

require_once __DIR__ . '/../vendor/autoload.php';

// Gestion des erreurs
error_reporting(E_ALL);
set_exception_handler('errorHandler');

/**
 * Methode en charge de gerer l'affichage des erreurs pendant le dev
 * @param mixed $exception
 * @return void
 */
function errorHandler($exception): void {
    $whoops = new \Whoops\Run;
    $whoops->allowQuit(false);
    $whoops->writeToOutput(false);
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $html = $whoops->handleException($exception);
    echo $html;
}

// Initialiser Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/views/');
$twig = new \Twig\Environment($loader);

// Initialiser le routeur
$router = new Router();

$adminRoute = new AdminRoutes($router, $twig);
$adminRoute->setRoutes();

// Dispatch la requête entrante
$router->dispatch($_SERVER['REQUEST_URI']);
