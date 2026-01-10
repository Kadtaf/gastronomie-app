<?php

namespace App\Classes\Core;

class RateLimiter
{
    private const MAX_ATTEMPTS = 5;
    private const DECAY_SECONDS = 600; // 10 minutes

    public static function hit(string $key): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['rate_limit'][$key]['attempts'] =
            ($_SESSION['rate_limit'][$key]['attempts'] ?? 0) + 1;

        $_SESSION['rate_limit'][$key]['last_attempt'] = time();
    }

    public static function tooManyAttempts(string $key): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $attempts = $_SESSION['rate_limit'][$key]['attempts'] ?? 0;
        $lastAttempt = $_SESSION['rate_limit'][$key]['last_attempt'] ?? 0;

        if ($attempts < self::MAX_ATTEMPTS) {
            return false;
        }

        return (time() - $lastAttempt) < self::DECAY_SECONDS;
    }

    public static function availableIn(string $key): int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $lastAttempt = $_SESSION['rate_limit'][$key]['last_attempt'] ?? 0;

        $remaining = self::DECAY_SECONDS - (time() - $lastAttempt);

        return max(0, $remaining);
    }

    public static function clear(string $key): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['rate_limit'][$key]);
    }
}