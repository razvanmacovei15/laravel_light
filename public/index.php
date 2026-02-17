<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

echo '=== Day 1 Final Test ===' . PHP_EOL . PHP_EOL;

// -------------------------------------------------------
// 1. PATHS — the app knows where it lives
// -------------------------------------------------------
echo '--- Paths ---' . PHP_EOL;
echo 'Base: ' . $app->basePath() . PHP_EOL;
echo 'App:  ' . $app->appPath() . PHP_EOL;
echo PHP_EOL;

// -------------------------------------------------------
// 2. MANUAL BINDING — bind a config array
// -------------------------------------------------------
echo '--- Manual Binding ---' . PHP_EOL;
$app->singleton('config', function () {
    return [
        'app_name' => 'Light Laravel',
        'version' => '0.1.0',
    ];
});

$config = app('config');
echo "App: {$config['app_name']} v{$config['version']}" . PHP_EOL;
echo PHP_EOL;

// -------------------------------------------------------
// 3. AUTO-WIRING — resolve classes with zero configuration
// -------------------------------------------------------
echo '--- Auto-Wiring ---' . PHP_EOL;
use App\Services\UserRepository;

// No bind() for Logger or UserRepository!
// Container reads constructors and builds the chain automatically.
$repo = app(UserRepository::class);
$user = $repo->find(1);
echo "Found: {$user['name']} ({$user['email']})" . PHP_EOL;
echo PHP_EOL;

// -------------------------------------------------------
// 4. SINGLETON PROOF — same instance every time
// -------------------------------------------------------
echo '--- Singleton Proof ---' . PHP_EOL;
$config1 = app('config');
$config2 = app('config');
echo 'Config is singleton? ' . ($config1 === $config2 ? 'YES' : 'NO') . PHP_EOL;
echo PHP_EOL;

// -------------------------------------------------------
// 5. APP SELF-REFERENCE — app('app') returns itself
// -------------------------------------------------------
echo '--- Self Reference ---' . PHP_EOL;
echo 'app("app") works? ' . (app('app') === $app ? 'YES' : 'NO') . PHP_EOL;
echo 'app() works? ' . (app() === $app ? 'YES' : 'NO') . PHP_EOL;
echo PHP_EOL;

echo '=== Day 1 Complete ===' . PHP_EOL;



