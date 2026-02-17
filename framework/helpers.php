<?php

use Framework\Application;

/**
 * @param string|null $abstract
 * @return mixed
 * @throws ReflectionException
 */
function app(?string $abstract = null): mixed
{
    $instance = Application::getInstance();

    if ($abstract === null) {
        return $instance;
    }

    return $instance->make($abstract);
}
