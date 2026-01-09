<?php
namespace App\Classes\Core;

class Router
{
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Supprimer le slash final
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
            header("Location: $uri", true, 301);
            exit;
        }

        // Supprimer les paramètres GET éventuels
        $uri = explode('?', $uri)[0];

        // Découper l’URL
        $parts = array_values(array_filter(explode('/', $uri)));

        // Si aucune partie → HomeController@index
        if (empty($parts)) {
            $controllerName = "HomeController";
            $action = "index";
            $params = [];
        } else {
            // Controller
            $controllerName = ucfirst($parts[0]) . "Controller";

            // Action
            $action = $parts[1] ?? "index";

            // Paramètres
            $params = array_slice($parts, 2);
        }

        $controllerClass = "\\App\\Classes\\Controllers\\" . $controllerName;

        // Vérifier si le controller existe
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo "Controller introuvable : $controllerName";
            exit;
        }

        $controller = new $controllerClass();

        // Vérifier si l’action existe
        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo "Méthode introuvable : $action";
            exit;
        }

        // Appeler l’action avec les paramètres
        call_user_func_array([$controller, $action], $params);
    }
}