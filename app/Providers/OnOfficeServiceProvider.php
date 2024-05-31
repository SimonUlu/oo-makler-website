<?php

namespace App\Providers;

use App\Services\OnOfficeService;
use Illuminate\Support\ServiceProvider;

class OnOfficeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OnOfficeService::class, function ($app) {
            return new OnOfficeService();
        });
    }
}
