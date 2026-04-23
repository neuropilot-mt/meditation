<?php

namespace App\Providers;

use App\AI\AiManager;
use Illuminate\Support\ServiceProvider;

class AiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AiManager::class, fn () => new AiManager(config('ai')));
    }
}
