<?php

namespace Ckryo\Laravel\Upload;

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
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
