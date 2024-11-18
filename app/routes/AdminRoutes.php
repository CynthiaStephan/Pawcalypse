<?php

namespace App\Routes;

use App\Controllers\AdminController;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Router;

class AdminRoutes
{
    private Router $router;
    private $twig;
    public function __construct(Router $router, $twig) {
        $this->router = $router;
        $this->twig = $twig;
    }

    function setRoutes() {
        $twig = $this->twig;
        // Configurer les routes avec closures
        $this->router->add('/', function () use ($twig) {
            $controller = new LoginController($twig);
            $controller->index();
        });
        $this->router->add('/dashboard', function () use ($twig) {
            $controller = new AdminController($twig);
            $controller->index();
        });
        $this->router->add('/logout', function () use ($twig) {
            $controller = new LoginController($twig);
            $controller->logout();
        });

        $this->router->add('/users/detail', function () use ($twig) {
            $controller = new UserController($twig);
            $controller->detail();
        });
    }
}
