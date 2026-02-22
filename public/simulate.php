<?php

use App\Facades\Log;
use App\Providers\AppServiceProvider;
use App\Providers\MailServiceProvider;
use Framework\Application;

require_once __DIR__ . '/../vendor/autoload.php';

// ── Simulate what PHP-FPM does: fresh app per request ────────
// In real life, each iteration below is a separate HTTP request.
// PHP destroys everything between requests — we simulate that
// by unsetting $app and rebuilding from scratch.

$routes = [
    'GET /home',
    'POST /login',
    'GET /dashboard',
    'GET /api/users',
];

foreach ($routes as $i => $route) {
    echo "╔══════════════════════════════════════╗\n";
    echo "║  REQUEST " . ($i + 1) . ": {$route}\n";
    echo "╠══════════════════════════════════════╣\n";

    // ── Fresh app — require (not require_once!) runs the file every time
    $app = require __DIR__ . '/../bootstrap/app.php';

    // ── Simulate: only the login request sends email ─────────
    if ($route === 'POST /login') {
        echo "  → Login detected, sending welcome email...\n";
        $mailer = $app->make('mailer');
        $mailer->send('razvan@test.com', 'Welcome back!');
    }

    Log::log("  → Handled {$route}");

    // ── App dies — just like end of a real PHP request ────────
    $objectId = spl_object_id($app);
    echo "  → App instance #{$objectId} dying now...\n";
    unset($app);

    echo "╚══════════════════════════════════════╝\n\n";
}