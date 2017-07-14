<?php

Route::group(['namespace' => 'Ckryo\Laravel\Cms\Controllers', 'prefix' => 'cms'], function ($router) {


    $router->get('index', 'IndexController@index');
    $router->get('news', 'NewsController@index');
    $router->get('notice', 'NoticeController@index');
    $router->get('faq', 'FaqController@index');


    $router->group(['middleware' => 'auth'], function ($router) {
        // 头像上传
        $router->resource('push', 'PushController');

        $router->delete('news/{item_str}', 'NewsController@destroy');
        $router->delete('notice/{item_str}', 'NoticeController@destroy');
        $router->delete('faq/{item_str}', 'FaqController@destroy');
    });
});