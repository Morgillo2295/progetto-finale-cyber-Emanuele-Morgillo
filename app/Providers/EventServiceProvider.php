<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerAuthLogging();
    }

    protected function registerAuthLogging(): void
    {
        $logContext = fn ($event, string $action) => [
            'action' => $action,
            'user_id' => $event->user->id ?? null,
            'email' => $event->user->email ?? null,
            'ip' => request()->ip(),
        ];

        $this->app['events']->listen(Login::class, function (Login $event) use ($logContext) {
            Log::info('User logged in', $logContext($event, 'user_login'));
        });

        $this->app['events']->listen(Logout::class, function (Logout $event) use ($logContext) {
            Log::info('User logged out', $logContext($event, 'user_logout'));
        });

        $this->app['events']->listen(Registered::class, function (Registered $event) use ($logContext) {
            Log::info('User registered', $logContext($event, 'user_registered'));
        });
    }
}
