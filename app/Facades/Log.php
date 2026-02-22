<?php
namespace App\Facades;

use App\Services\Logger;
use Framework\Facade;

class Log extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return Logger::class;
    }
}