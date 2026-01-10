<?php

namespace App\Classes\Core;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = require __DIR__ . '/../../../routes/web.php';
    }

    public function run(): void
    {
        $request = new Request();

        foreach ($this->expandRoutes($this->routes) as $route) {

            // Gestion GET/POST ou tableau de méthodes
            if (is_array($route->method)) {
                if (!in_array($request->method, $route->method)) {
                    continue;
                }
            } else {
                if ($route->method !== $request->method) {
                    continue;
                }
            }

            // Paramètres dynamiques
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route->uri);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $request->uri, $matches)) {

                array_shift($matches);

                // Middlewares
                foreach ($route->middlewares as $middlewareName) {
                    $middlewareClass = "\\App\\Classes\\Core\\Middleware\\" . ucfirst($middlewareName) . "Middleware";

                    if (!class_exists($middlewareClass)) {
                        throw new \Exception("Middleware introuvable : $middlewareClass");
                    }

                    $middleware = new $middlewareClass();

                    if (!$middleware->handle($request)) {
                        return;
                    }
                }

                // Controller
                $controllerClass = "\\App\\Classes\\Controllers\\" . $route->controller;

                if (!class_exists($controllerClass)) {
                    $this->render404("Controller introuvable : {$route->controller}");
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $route->action)) {
                    $this->render404("Méthode introuvable : {$route->action}");
                }

                call_user_func_array([$controller, $route->action], $matches);
                return;
            }
        }

        $this->render404("Aucune route ne correspond à l’URL : {$request->uri}");
    }

    private function expandRoutes(array $routes): array
    {
        $expanded = [];

        foreach ($routes as $route) {

            if ($route instanceof Route) {
                $expanded[] = $route;
                continue;
            }

            // Groupe de routes
            $prefix = $route['prefix'] ?? '';
            $middlewares = $route['middleware'] ?? [];
            $subRoutes = $route['routes'];

            foreach ($subRoutes as $subRoute) {

                // Cloner pour éviter les modifications multiples
                $clone = clone $subRoute;

                $clone->uri = $prefix . $clone->uri;
                $clone->middlewares = array_merge($clone->middlewares, (array) $middlewares);

                $expanded[] = $clone;
            }
        }

        return $expanded;
    }

    private function render404(string $message): void
    {
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        echo "<p>$message</p>";
        exit;
    }
}