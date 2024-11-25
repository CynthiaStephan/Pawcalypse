<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
    private $twig;

    public function __construct($twig) {
        $this->twig = $twig;
    }

    public function index() {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        echo $this->twig->render('users/list.twig', ['users' => $users]);
    }
    public function detail() {
        $userId = $_GET['id'] ?? null;

        if ($userId) {
            $userModel = new User();
            $user = $userModel->getUserById($userId);

            if ($user) {
                echo $this->twig->render('users/detail.twig', ['user' => $user]);
            } else {
                echo $this->twig->render('error.twig', ['message' => 'Utilisateur introuvable.']);
            }
        } else {
            echo $this->twig->render('error.twig', ['message' => 'ID utilisateur manquant.']);
        }
    }
}
