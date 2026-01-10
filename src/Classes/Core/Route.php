<?php

namespace App\Classes\Core;

class Route
{
    public string|array $method;
    public string $uri;
    public string $controller;
    public string $action;
    public array $middlewares = [];
    public ?string $name = null;

    public function __construct(string $method, string $uri, string $handler)
    {
        $this->method = strtoupper($method);
        $this->uri = $uri;

        [$this->controller, $this->action] = explode('@', $handler);
    }

    public function middleware(string|array $middlewares): self
    {
        $middlewares = is_array($middlewares) ? $middlewares : [$middlewares];
        $this->middlewares = array_merge($this->middlewares, $middlewares);
        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public static function get(string $uri, string $handler): self
    {
        return new self('GET', $uri, $handler);
    }

    public static function post(string $uri, string $handler): self
    {
        return new self('POST', $uri, $handler);
    }

    public static function put(string $uri, string $handler): self
    {
        return new self('PUT', $uri, $handler);
    }

    public static function delete(string $uri, string $handler): self
    {
        return new self('DELETE', $uri, $handler);
    }

    public static function match(array $methods, string $uri, string $handler): self
    {
        $route = new self($methods[0], $uri, $handler);
        $route->method = array_map('strtoupper', $methods);
        return $route;
    }
}