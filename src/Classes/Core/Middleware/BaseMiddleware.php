<?php

namespace App\Classes\Core\Middleware;

use App\Classes\Controllers\AbstractController;

abstract class BaseMiddleware extends AbstractController implements Middleware
{
    // Rien à ajouter ici, on hérite juste des méthodes utiles
}