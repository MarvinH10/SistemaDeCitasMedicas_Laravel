<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\HorarioServiceInterface;
use App\Services\HorarioService;

class HorarioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(HorarioServiceInterface::class, HorarioService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
