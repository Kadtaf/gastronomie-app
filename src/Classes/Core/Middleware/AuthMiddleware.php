<?php

namespace App\Classes\Core\Middleware;

use App\Classes\Core\Middleware;
use App\Classes\Core\Request;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request): bool
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo "Accès interdit : vous devez être connecté.";
            return false;
        }

        return true;
    }
}