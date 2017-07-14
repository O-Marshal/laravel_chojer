<?php

namespace Ckryo\Laravel\Auth;

use Ckryo\Laravel\Handler\ErrorCode;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot(ErrorCode $errorCode)
    {
        $errCodes = require __DIR__.'/../config/errCode.php';
        foreach ($errCodes as $model => $codes) {
            $errorCode->regist($model, $codes);
        }
    }

    public function regist()
    {
        $this->app->singleton('admin_auth', function ($app) {
            return new Auth($app['request']);
        });

        $this->app->bind(Auth::class, function ($app) {
            return $app->make('admin_auth');
        });

        $this->app->bind('auth', function ($app) {
            return $app->make('admin_auth');
        });
    }

}
