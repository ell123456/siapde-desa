<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- WAJIB ADA BIAR TIDAK ERROR UNDEFINED CLASS

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
        // JINAKKAN NGROK HTTPS: Memaksa semua request form menggunakan HTTPS jika diakses lewat ngrok-free.dev
        if (str_contains(request()->getHttpHost(), 'ngrok-free.dev') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
