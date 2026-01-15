<?php

namespace App\Classes\Controllers;

class HomeController extends AbstractController
{
    public function index(): void
    {
        $user = $_SESSION['user'] ?? null;

        $this->renderView('Home/index', [
            'title' => 'Bienvenue sur mon site',
            'user' => $user
        ], layout: 'main');
    }
}