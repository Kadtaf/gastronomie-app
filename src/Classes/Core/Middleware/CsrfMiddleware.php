<?php

namespace App\Classes\Core\Middleware;

use App\Classes\Core\Request;
use App\Classes\Core\Csrf;

class CsrfMiddleware extends BaseMiddleware
{
    public function handle(Request $request): bool
    {
        // On ne protège que les requêtes POST (ou PUT/DELETE si tu veux)
        if ($request->method !== 'POST') {
            return true;
        }

        // Récupération du token CSRF envoyé par le formulaire
        $token = $_POST['_csrf'] ?? null;

        // Vérification du token
        if (!$token || !Csrf::checkToken($token)) {
            $this->abort(403, "Requête invalide (CSRF).");
            return false;
        }

        return true;
    }

}