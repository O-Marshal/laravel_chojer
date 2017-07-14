<?php

namespace Ckryo\Laravel\Cms;

use Ckryo\Laravel\Handler\Facades\ErrorCode;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot(ErrorCode $errorCode)
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

}
