<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;      
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Http;      
use Illuminate\Support\Facades\URL;       

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
        // 1. Pagination Bootstrap
        Paginator::useBootstrapFive();

        // 2. Force HTTPS (Selain Localhost)
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // 3. REGISTRASI VALIDASI RECAPTCHA
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            
            $response = Http::asForm()
                ->withoutVerifying() // Bypass SSL buat Localhost
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    // PERBAIKAN DISINI: Sesuaikan dengan nama di .env kamu
                    'secret' => env('NOCAPTCHA_SECRET'), 
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);

            // Return true kalau sukses, false kalau gagal
            return $response->json('success');
        });
    }
}