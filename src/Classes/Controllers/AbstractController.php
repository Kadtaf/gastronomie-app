<?php
namespace App\Classes\Controllers;

abstract class AbstractController
{
    /**
     * Affiche une vue avec des paramètres
     */
    public function renderView(string $path, array $params = [], array $assets = []): void
    {
        // On extrait les paramètres pour les rendre disponibles dans la vue
        extract($params);

        // On construit le chemin absolu vers la vue
        $fullPath = dirname(__DIR__, 2) . "/Views/" . $path . ".php";

        if (!file_exists($fullPath)) {
            throw new \Exception("Vue introuvable : " . $fullPath);
        }

        // On inclut la vue
        require $fullPath;
    }

    /**
     * Redirection simple
     */
    public function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}