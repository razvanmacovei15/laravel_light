<?php

namespace Framework;

class Application extends Container {
    protected string $basePath;

    protected static ?Application $instance = null;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;

        $this->instances['app'] = $this;

        static::$instance = $this;
    }

    public function basePath(string $path = ''): string
    {
        return $this->basePath . ($path ? '/' . $path : '');
    }

    public function appPath(string $path = ''): string
    {
        return $this->basePath('app' . ($path ? '/' . $path : ''));
    }

    public static function getInstance(): ?Application
    {
        return static::$instance;
    }

}
