<?php

namespace Ckryo\Laravel\Logi;

use Illuminate\Support\ServiceProvider;

class LogiServiceProvider extends ServiceProvider
{

    public function boot () {
        /// 部署配置
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    public function register()
    {
        $this->app->singleton('logi', function ($app) {
            return new Logi($app);
        });

        $this->app->bind(Logi::class, function ($app) {
            return $app->make('logi');
        });
    }

}