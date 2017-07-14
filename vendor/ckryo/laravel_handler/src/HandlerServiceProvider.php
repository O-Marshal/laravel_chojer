<?php

namespace Ckryo\Laravel\Handler;

use Illuminate\Support\ServiceProvider;

class HandlerServiceProvider extends ServiceProvider
{

    public function boot (ErrorCode $errorCode) {
        /// 部署配置
        $this->mergeConfigFrom(__DIR__.'/../config/errorCode.php', config_path('errorCode.php'));

        /**
         * 注册配置文件中的错误码
         */
        if (file_exists(config_path('errorCode.php'))) {
            foreach (config('errorCode') as $model => $codes) {
                $errorCode->regist($model, $codes);
            }
        }
    }

    public function register()
    {
        $this->app->singleton('errorcode', function () {
            return new ErrorCode();
        });

        $this->app->bind(ErrorCode::class, function ($app) {
            return $app->make('errorcode');
        });
    }

}