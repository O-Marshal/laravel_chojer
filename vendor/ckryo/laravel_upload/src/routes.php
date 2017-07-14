<?php

Route::group(['namespace' => 'Ckryo\Laravel\Upload\Controllers', 'prefix' => 'upload'], function ($router) {

    $router->group(['middleware' => 'auth'], function ($router) {
        // 头像上传
        $router->resource('avatar', 'AvatarController');
        // 一般图片
        $router->resource('image', 'ImageController');
    });
    // 百度 Ueditor
    $router->resource('ueditor', 'UeditorController');
});