<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Statamic\Facades\GlobalSet;
use Studio1902\PeakSeo\Handlers\ErrorPage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Statamic::script('app', 'cp');
        // Statamic::style('app', 'cp');

        if (App::environment() !== 'local') {
            URL::forceScheme('https');
        }

        ErrorPage::handle404AsEntry();

        View::composer('*', function ($view) {
            GlobalSet::all()->each(fn ($set) => $view->with($set->handle(), $set->inCurrentSite()));
        });
    }
}
