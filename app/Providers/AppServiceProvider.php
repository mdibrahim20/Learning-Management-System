<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\IntegrationSetting;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Config;

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
       // SMTP Settings Configuration
       if (\Schema::hasTable('smtp_settings')) {
           $smtpsetting = SmtpSetting::first();

           if ($smtpsetting) {
               Config::set('mail.default', $smtpsetting->mailer ?: config('mail.default'));
               Config::set('mail.mailers.smtp.host', $smtpsetting->host);
               Config::set('mail.mailers.smtp.port', $smtpsetting->port);
               Config::set('mail.mailers.smtp.username', $smtpsetting->username);
               Config::set('mail.mailers.smtp.password', $smtpsetting->password);
               Config::set('mail.mailers.smtp.encryption', $smtpsetting->encryption);
               Config::set('mail.from.address', $smtpsetting->from_address);
               Config::set('mail.from.name', config('app.name', 'Nuvetic'));
           }
       } // end if

       // Integration Settings Configuration
       if (\Schema::hasTable('integration_settings')) {
           $integration = IntegrationSetting::first();
           if ($integration) {
               Config::set('services.google.client_id', $integration->google_client_id);
               Config::set('services.google.client_secret', $integration->google_client_secret);
               Config::set('services.google.redirect', $integration->google_redirect_uri);
               Config::set('services.stripe.key', $integration->stripe_key);
               Config::set('services.stripe.secret', $integration->stripe_secret);
           }
       }

       // Share Site Settings with all views
       if (\Schema::hasTable('site_settings')) {
           $siteSetting = SiteSetting::first();
           
           // If no site setting exists, create default one
           if (!$siteSetting) {
               $siteSetting = SiteSetting::create([
                   'logo' => null,
                   'phone' => '+1 234 567 8900',
                   'email' => 'support@lms.com',
                   'address' => '123 Learning Street',
                   'copyright' => '© 2026 LMS. All Rights Reserved.',
               ]);
           }
           
           View::share('siteSetting', $siteSetting);
       }
    }
}
