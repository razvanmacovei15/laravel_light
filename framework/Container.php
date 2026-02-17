<?php

namespace Framework;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container
{
    protected array $bindings = [];
    protected array $instances = [];

    public function bind(string $abstract, Closure $factory): void
    {
        $this->bindings[$abstract] = [
            'factory' =>$factory,
            'shared' =>false,
            ];
    }

    public function singleton(string $abstract, Closure $factory): void
    {
        $this->bindings[$abstract] = [
            'factory' => $factory,
            'shared' => true,
        ];
    }


    /**
     * @throws ReflectionException
     */
    public function make(string $abstract): mixed
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $binding = $this-> bindings[$abstract];
            $object = $binding['factory']($this);

            if($binding['shared']) {
                $this->instances[$abstract] = $object;
            }

            return $object;
        }

        return $this->build($abstract);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    protected function build(string $class): object
    {
        try {
            $reflector = new ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new Exception("Class [{$class}] does not exist." . PHP_EOL);
        }

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class [{$class}] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $parameters = $constructor->getParameters();
        $dependencies = array_map(
            fn(ReflectionParameter $param) => $this->resolveParameter($param),
            $parameters
        );

        return $reflector->newInstanceArgs($dependencies);
    }


    /**
     * @throws Exception
     */
    protected function resolveParameter(ReflectionParameter $param)
    {
        $type = $param->getType();

        if($type !== null && !$type->isBuiltin()) {
            return $this->make($type->getName());
        }

        if($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        throw new Exception( "Cannot resolve parameter [\${$param->getName()}] in [{$param->getDeclaringClass()->getName()}]");
    }
}