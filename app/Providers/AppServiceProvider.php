<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
   public function boot()
    {
        ini_set('upload_max_filesize', '10M');
        ini_set('post_max_size', '12M');

        if (env('APP_ENV') === 'development') {
            URL::forceScheme('https');
        }
    }
}
