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

    public static function get(): array
    {
        $messages = $_SESSION[self::SESSION_KEY] ?? [];
        unset($_SESSION[self::SESSION_KEY]); // auto-clear
        return $messages;
    }
}