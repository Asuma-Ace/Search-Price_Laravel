<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
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
        View::composer('layouts/footer', function($view) {
            if(date('Y') > 2020) {
                $year = '-'.date('Y');
                $view->with('year', $year);
            } else {
                $year = NULL;
                $view->with('year', $year);
            }
        });
    }
}
