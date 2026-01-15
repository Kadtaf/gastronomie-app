<?php

namespace App\Classes\Core\Middleware;

use App\Classes\Core\Request;

class AuthMiddleware extends BaseMiddleware
{
    public function handle(Request $request): bool
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return false;
        }

        return true;
    }
}