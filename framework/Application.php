<?php

namespace Framework;

class Application extends Container {
    protected string $basePath;

    protected static ?Application $instance = null;
    protected array $serviceProviders = [];
    protected array $deferredProviders = [];

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;

        $this->instances['app'] = $this;

        static::$instance = $this;

        // ── Proof: a new app is born on every request ────────────
        $id = substr(uniqid(), -5);
        echo "[App:{$id}] NEW Application instance created\n";
    }

    public function make(string $abstract): mixed
    {
        if (isset($this->deferredProviders[$abstract])) {
            $this->registerProvider($this->deferredProviders[$abstract]);

            unset($this->deferredProviders[$abstract]);
        }

        return parent::make($abstract);
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

    public function registerProvider(string $providerClass): ServiceProvider
    {
        $provider = new $providerClass($this);

        $provider->register();

        $this->serviceProviders[] = $provider;

        return $provider;
    }

    public function registerMultipleProviders(array $providerClasses): void
    {
        foreach ($providerClasses as $providerClass) {
            $this->registerProvider($providerClass);
        }
    }

    public function registerDeferredProviders(array $providerClasses): void
    {
        foreach ($providerClasses as $providerClass) {
            // Create a temporary instance just to ask what it provides
            $provider = new $providerClass($this);

            foreach ($provider->provides() as $key) {
                $this->deferredProviders[$key] = $providerClass;
            }
        }
    }

        public function bootProviders(): void
    {
        foreach ($this->serviceProviders as $provider) {
            $provider->boot();
        }
    }
}
