<?php

namespace App\Providers;

use App\Enums\CmnEnum;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\Notifications\ResetPassword;
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
        App::setLocale(CmnEnum::DEFAULT_LANG);
        
        //ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            //return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        //});
    }
}

