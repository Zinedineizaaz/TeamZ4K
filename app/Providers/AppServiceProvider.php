<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Tambahan buat Bootstrap

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
        // Karena kamu pakai Bootstrap, baris ini penting biar pagination rapi
        Paginator::useBootstrapFive();
        if (config('app.env') !== 'local') {
        \URL::forceScheme('https');
    }
    }
}