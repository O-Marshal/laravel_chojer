<?php

namespace App;

use Ckryo\Laravel\Cms\Models\CmsArticle;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class TestProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        //
        $router->get('test', function () {
            $a = explode('|', '1');
            dd($a);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
