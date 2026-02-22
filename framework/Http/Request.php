<?php

namespace Framework\Http;

class Request
{
    protected array $server;
    protected array $query;
    protected array $post;

    public function __construct(array $server, array $query, array $post)
    {
        $this->server = $server;
        $this->query = $query;
        $this->post = $post;
    }

    public static function capture(): static
    {
        return new static($_SERVER, $_GET, $_POST);
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function path(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';

        $path = strtok($uri, '?');

        return '/' . trim($path, '/');
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->query[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->post);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->post)
            || array_key_exists($key, $this->query);
    }

}