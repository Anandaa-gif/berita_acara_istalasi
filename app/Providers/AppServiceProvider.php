<?php

namespace App\Providers;

use App\Models\BeritaAcara;
use App\Observers\BeritaAcaraObserver;
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
        // Hubungkan model BeritaAcara dengan Observer
        BeritaAcara::observe(BeritaAcaraObserver::class);
    }
}
