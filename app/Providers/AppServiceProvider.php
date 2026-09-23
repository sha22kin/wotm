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

        // Dynamically override mail configuration from admin settings
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailHost = \App\Models\Setting::get('mail_host');
                if ($mailHost) {
                    $mailer = \App\Models\Setting::get('mail_mailer', 'smtp');
                    config(['mail.default' => $mailer]);
                    config(["mail.mailers.{$mailer}.transport" => $mailer]);
                    config(["mail.mailers.{$mailer}.host" => $mailHost]);
                    config(["mail.mailers.{$mailer}.port" => \App\Models\Setting::get('mail_port', 465)]);
                    config(["mail.mailers.{$mailer}.username" => \App\Models\Setting::get('mail_username')]);
                    config(["mail.mailers.{$mailer}.password" => \App\Models\Setting::get('mail_password')]);
                    
                    $encryption = \App\Models\Setting::get('mail_encryption');
                    config(["mail.mailers.{$mailer}.encryption" => empty($encryption) ? null : $encryption]);
                    
                    $fromAddress = \App\Models\Setting::get('mail_from_address');
                    if ($fromAddress) {
                        config(['mail.from.address' => $fromAddress]);
                    }
                    
                    $fromName = \App\Models\Setting::get('mail_from_name');
                    if ($fromName) {
                        config(['mail.from.name' => $fromName]);
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently ignore DB errors during setup/migration
        }
    }
}
