<?php

namespace App\Classes\Controllers;

abstract class AbstractController
{
    protected function renderView(string $path, array $params = [], ?string $layout = null): void
    {
        $viewPath = dirname(__DIR__, 3) . "/Views/" . $path . ".php";

        if (!file_exists($viewPath)) {
            throw new \Exception("Vue introuvable : " . $viewPath);
        }

        extract($params, EXTR_SKIP);

        if ($layout) {
            $layoutPath = dirname(__DIR__, 3) . "/Views/layouts/" . $layout . ".php";

            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout introuvable : " . $layoutPath);
            }

            $viewFile = $viewPath;
            require $layoutPath;
        } else {
            require $viewPath;
        }
    }

    protected function view(string $path, array $params = [], string $layout = 'main'): void
    {
        $this->renderView($path, $params, $layout);
    }

    protected function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }

    protected function back(): void
    {
        $url = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($url);
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    protected function response(string $content, int $status = 200): void
    {
        http_response_code($status);
        echo $content;
        exit;
    }

    protected function validate(array $data, array $rules): array
    {
        $validator = new \App\Classes\Core\Validator($data, $rules);

        return $validator->fails() ? $validator->errors() : [];
    }

    protected function csrfToken(): string
    {
        return \App\Classes\Core\Csrf::getToken();
    }

    protected function csrfField(): string
    {
        $token = $this->csrfToken();
        return '<input type="hidden" name="_csrf" value="' . $token . '">';
    }

    protected function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    protected function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }

    protected function abort(int $code, string $message = ''): void
    {
        http_response_code($code);
        echo "<h1>$code</h1>";
        echo "<p>$message</p>";
        exit;
    }

    private array $sections = [];
    private ?string $currentSection = null;

    protected function startSection(string $name): void
    {
        $this->currentSection = $name;
        ob_start();
    }

    protected function endSection(): void
    {
        $this->sections[$this->currentSection] = ob_get_clean();
        $this->currentSection = null;
    }

    protected function yield(string $name): void
    {
        echo $this->sections[$name] ?? '';
    }

    protected function flash(string $type, string $message): void
    {
        \App\Classes\Core\Flash::add($type, $message);
    }

    protected function asset(string $path): string
    {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
        if (!file_exists($fullPath)) {
            $version = filemtime($fullPath);
            return $path .= "?v=$version";
        }
        return $path;
    }

    protected function includePartial(string $path, array $params = []): void
    {
        $partialPath = dirname(__DIR__, 3) . "/Views/partials/" . $path . ".php";

        if (!file_exists($partialPath)) {
            throw new \Exception("Partial introuvable : " . $partialPath);
        }

        extract($params, EXTR_SKIP);

        require $partialPath;
    }

    protected function component(string $path, array $params = []): void
    {
        $componentPath = dirname(__DIR__, 3) . "/Views/components/" . $path . ".php";

        if (!file_exists($componentPath)) {
            throw new \Exception("Composant introuvable : " . $componentPath);
        }

        extract($params, EXTR_SKIP);

        require $componentPath;
    }

    protected function old(string $key, $default = ''): string
    {
        $value = $_POST[$key] ?? $default;
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    protected function hasError(array $errors, string $key): bool
    {
        return isset($errors[$key]);
    }

    protected function error(array $errors, string $key): ?string
    {
        return $errors[$key] ?? null;
    }

    protected function isAdmin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

}