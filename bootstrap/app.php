<?php

use App\Providers\AppServiceProvider;
use App\Providers\MailServiceProvider;
use Framework\Application;

$app = new Application(dirname(__DIR__));

$app->registerMultipleProviders([
    AppServiceProvider::class,
]);

$app->registerDeferredProviders([
    MailServiceProvider::class,
]);

$app->bootProviders();

return $app;


