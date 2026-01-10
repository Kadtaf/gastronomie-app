<?php

// Mode développement : afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Session
session_start();

// Router
$router = new App\Classes\Core\Router();

try {
    $router->run();
} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Erreur interne</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}