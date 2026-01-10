<?php

namespace App\Classes\Core;

class Request
{
    public string $method;
    public string $uri;
    public array $get;
    public array $post;
    public array $files;
    public array $cookies;
    public array $server;

    public function __construct()
    {
        $this->method  = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri     = $this->normalizeUri($_SERVER['REQUEST_URI'] ?? '/');
        $this->get     = $_GET;
        $this->post    = $_POST;
        $this->files   = $_FILES;
        $this->cookies = $_COOKIE;
        $this->server  = $_SERVER;
    }

    private function normalizeUri(string $uri): string
    {
        $uri = explode('?', $uri)[0];
        $uri = rtrim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function json(): ?array
    {
        $content = file_get_contents('php://input');
        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : null;
    }

    public function header(string $key): ?string
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$key] ?? null;
    }

    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}