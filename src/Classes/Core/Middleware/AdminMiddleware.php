<?php

namespace App\Classes\Core\Middleware;

use App\Classes\Core\Request;

class AdminMiddleware extends BaseMiddleware
{
    public function handle(Request $request): bool
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return false;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            $this->abort(403, "Accès réservé aux administrateurs.");
            return false;
        }

        return true;
    }
}