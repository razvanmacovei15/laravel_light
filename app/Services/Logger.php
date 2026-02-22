<?php

namespace App\Services;

class Logger
{
    public function log(string $message): void
    {
        echo "[INFO] {$message}" . PHP_EOL;
    }

    public function error(string $message): void
    {
        echo "[ERROR] {$message}" . PHP_EOL;
    }
}