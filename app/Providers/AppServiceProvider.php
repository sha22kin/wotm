<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Automatically bind public_html path if hosted in cPanel with public_html directory
        if (isset($_SERVER['DOCUMENT_ROOT']) && basename($_SERVER['DOCUMENT_ROOT']) === 'public_html') {
            $this->app->usePublicPath($_SERVER['DOCUMENT_ROOT']);
        } elseif (is_dir(base_path('../public_html'))) {
            $this->app->usePublicPath(base_path('../public_html'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS if APP_URL is https or when running under SSL in production
        if (str_starts_with(config('app.url'), 'https://') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
