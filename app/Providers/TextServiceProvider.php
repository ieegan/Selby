<?php

namespace App\Providers;

use App\Texting\MessageOwl;
use Illuminate\Support\ServiceProvider;

class TextServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(MessageOwl::class, function($app) {
            $config = $app->make('config')->get('services.msgowl');

            return new MessageOwl($config);
        });
    }
}
