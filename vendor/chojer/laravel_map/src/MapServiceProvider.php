<?php

namespace Chojer\Laravel\Map;

use Illuminate\Support\ServiceProvider;

class MapServiceProvider extends ServiceProvider
{

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

}