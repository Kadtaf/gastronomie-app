<?php

namespace App\Classes\Core;

class Flash
{
    private const SESSION_KEY = '_flash_messages';

    public static function add(string $type, string $message): void
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }

        $_SESSION[self::SESSION_KEY][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // Vérifie s'il y a au moins un message
    public static function has(): bool
    {
        return !empty($_SESSION[self::SESSION_KEY]);
    }

    // Récupère tous les messages et les supprime
    public static function getAll(): array
    {
        $messages = $_SESSION[self::SESSION_KEY] ?? [];
        unset($_SESSION[self::SESSION_KEY]);
        return $messages;
    }
}