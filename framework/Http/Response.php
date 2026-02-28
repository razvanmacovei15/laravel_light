<?php

namespace Framework\Http;

class Response
{
    protected string $content;
    protected array $headers = [];
    protected int $statusCode;

    public function __construct(string $content, array $headers = [], int $statusCode = 200)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;
        return $this;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function header(string $key, string $value): static
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }

        echo $this->content;
    }

    public static function json(mixed $data, int $statusCode = 200): static
    {
        return new static(
            json_encode($data),
            ['Content-Type' => 'application/json'],
            $statusCode
        );
    }
}