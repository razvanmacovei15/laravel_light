<?php

namespace Framework;

abstract class Facade
{
    abstract protected static function getFacadeAccessor(): string;

    public static function __callStatic(string $method, array $arguments): mixed
    {
        $accessor = static::getFacadeAccessor();

        $instance = Application::getInstance()->make($accessor);

        return $instance->$method(...$arguments);
    }
}