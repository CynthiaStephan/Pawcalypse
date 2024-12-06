<?php

namespace App\Controllers;

use App\Models\User;
use Exception;




class LoginController
{
    private $twig;
    private $user;

    public function __construct($twig) {
        $this->twig = $twig;
        $this->user = new User();
    }
    public function index() {

        session_start();
        $error_message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
        
            // Vérifie que les champs ne sont pas vides
            if (empty($username) || empty($password)) {
                $message = [
                    'message' => "Veuillez remplir tous les champs.",
                    'status' => "error",
                ];
            } else {
                try {
                    // Prépare la requête pour récupérer l'utilisateur
                    $user = $this->user->getUser($username)[0];

                    if ($user && password_verify($password, $user['password'])) {
                        // Authentification réussie
                        $_SESSION['user'] = [
                            'id' => $user['id'],
                        ];
                        header('Location: /dashboard');
                    } else {
                        // Authentification échouée
                        $message = [
                            'message' => "Identifiant ou mot de passe incorrect.",
                            'status' => "error",
                        ];
                    }
                } catch (Exception $e) {
                    // Log l'erreur pour analyse (sans afficher au client)
                    error_log($e->getMessage());
                    $message = [
                        'message' => "Une erreur est survenue. Veuillez réessayer plus tard.",
                        'status' => "error",
                    ];
                }
            }
        }
        echo $this->twig->render('auth/login.html.twig');
        
    }
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /');
    }
}
