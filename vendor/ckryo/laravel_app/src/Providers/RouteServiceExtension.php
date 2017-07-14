<?php

namespace Ckryo\Laravel\App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route;

trait RouteServiceExtension
{

    /**
     * 执行路由加载方法
     * @return mixed
     */
    abstract function mapRoutes (Router $router);

    /**
     * 获取 app 实例
     * @return Application
     */
    function get_app () {
        return $this->app;
    }

    /**
     * 执行路由初始化函数
     *
     * @return void
     */
    public function initialRoute()
    {
        $this->setRootControllerNamespace();

        if ($this->get_app()->routesAreCached()) {
            $this->loadCachedRoutes();
        } else {
            $namespace = $this->namespace ?: '';
            Route::namespace($namespace)->group(function ($router) {
                return $this->mapRoutes($router);
            });

            $this->get_app()->booted(function () {
                $this->get_app()['router']->getRoutes()->refreshNameLookups();
                $this->get_app()['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    /**
     * Set the root controller namespace for the application.
     *
     * @return void
     */
    protected function setRootControllerNamespace()
    {
        if (property_exists($this, 'namespace')) {
            $this->get_app()[UrlGenerator::class]->setRootControllerNamespace($this->namespace);
        }
    }

    /**
     * Load the cached routes for the application.
     *
     * @return void
     */
    protected function loadCachedRoutes()
    {
        $this->get_app()->booted(function () {
            require $this->get_app()->getCachedRoutesPath();
        });
    }

}