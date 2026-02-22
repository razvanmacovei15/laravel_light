<?php

namespace Framework;

abstract class ServiceProvider
{
    protected Application $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    abstract public function register(): void;
    public function boot() : void
    {
        // implement if needed
    }
}