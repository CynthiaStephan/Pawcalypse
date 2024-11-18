<?php

namespace App\Controllers;

class AdminController
{
    private $twig;

    public function __construct($twig) {
        $this->twig = $twig;
    }

    function index() {
        echo $this->twig->render('admin/dashboard.html.twig');
    }
}
