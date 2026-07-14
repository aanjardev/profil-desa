<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS di environment production (Railway)
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Daftarkan namespace komponen anonymous 'panel' agar x-panel::* dapat ditemukan
        // Ini memetakan x-panel::page-header ke resources/views/components/panel/page-header.blade.php
        Blade::anonymousComponentNamespace('components.panel', 'panel');
    }
}
