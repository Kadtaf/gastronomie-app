<?php

namespace App\Classes\Core;

class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    public static function getToken(): string
    {
        // La session doit déjà être démarrée dans public/index.php
        if (!isset($_SESSION[self::SESSION_KEY])) {
            self::regenerateToken();
        }

        return $_SESSION[self::SESSION_KEY];
    }

    public static function checkToken(?string $token): bool
    {
        if (empty($_SESSION[self::SESSION_KEY]) || empty($token)) {
            return false;
        }

        $isValid = hash_equals($_SESSION[self::SESSION_KEY], $token);

        // Optionnel : régénérer le token après validation
        // if ($isValid) {
        //     self::regenerateToken();
        // }

        return $isValid;
    }

    public static function regenerateToken(): void
    {
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
    }
}