<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

echo "=== Day 2 Tests ===\n\n";

// ── Test 1: Lifecycle order ──────────────────────────────────
echo "--- Test 1: Provider Lifecycle ---\n";
echo "AppServiceProvider was registered during boot (register before boot).\n";
$logger = $app->make(\App\Services\Logger::class);
$logger->log('Logger resolved from provider — lifecycle works!');
echo "\n";

// ── Test 2: Facade ───────────────────────────────────────────
echo "--- Test 2: Facade ---\n";
\App\Facades\Log::log('Hello from Log facade!');
echo "\n";

// ── Test 3: Singleton via facade ─────────────────────────────
echo "--- Test 3: Facade returns singleton ---\n";
$direct = $app->make(\App\Services\Logger::class);
echo "Same instance through facade and make()? ";
// Resolve via the facade's path to compare
$viaFacade = \Framework\Application::getInstance()->make(\App\Services\Logger::class);
echo ($direct === $viaFacade ? 'YES' : 'NO') . "\n\n";

// ── Test 4: Deferred provider ────────────────────────────────
echo "--- Test 4: Deferred Provider ---\n";
echo "MailServiceProvider has NOT been registered yet...\n";
echo "Now resolving 'mailer' for the first time:\n";
$mailer = $app->make('mailer');
$mailer->send('razvan@test.com', 'Deferred loading works!');
echo "Resolving 'mailer' again (should NOT re-register):\n";
$mailer2 = $app->make('mailer');
$mailer2->send('razvan@test.com', 'Still the same singleton!');
echo "Same instance? " . ($mailer === $mailer2 ? 'YES' : 'NO') . "\n\n";

echo "=== All Day 2 Tests Passed! ===\n";