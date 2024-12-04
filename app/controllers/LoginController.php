<?php

namespace App\Controllers;

class LoginController
{
    private $twig;

    public function __construct($twig) {
        $this->twig = $twig;
    }
    public function index() {

        // TODO: Faire ma logique de récupération des info utilisateur. 
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            header('Location: /dashboard');
        }
        echo $this->twig->render('auth/login.html.twig');
        
    }
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /');
    }
}
