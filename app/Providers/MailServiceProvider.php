<?php

namespace App\Providers;

use Framework\ServiceProvider;
use Framework\DeferrableProvider;

/**
 * A deferred provider — only registered when 'mailer' is resolved.
 * Used to prove lazy-loading works.
 */
class MailServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        echo "  [MailServiceProvider] register() called — binding 'mailer'\n";

        $this->app->singleton('mailer', function () {
            return new class {
                public function send(string $to, string $message): void
                {
                    echo "  [Mailer] Sending to {$to}: {$message}\n";
                }
            };
        });
    }

    public function provides(): array
    {
        return ['mailer'];
    }
}