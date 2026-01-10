<?php

namespace App\Classes\Controllers;

class AdminController extends AbstractController
{
    public function dashboard(): void
    {
        $this->renderView('Admin/dashboard', [], layout: 'main');
    }
}