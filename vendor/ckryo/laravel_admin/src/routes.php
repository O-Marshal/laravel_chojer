<?php

Route::group(['namespace' => 'Ckryo\Laravel\Admin\Controllers'], function ($router) {

    // 登录注册
    $router->group(['prefix' => 'auth'], function ($router) {
        // 登录验证
        $router->get('login', 'LoginController@index')->middleware('auth');

        $router->resource('login', 'LoginController', ['only' => ['store']]);
    });

    $router->group(['middleware' => 'auth'], function ($router) {

        $router->group(['prefix' => 'account'], function ($router) {
            // 角色管理
            $router->resource('role', 'RoleController');
            // 用户管理
            $router->resource('user', 'UserController');

            // 权限管理
            $router->resource('role/permission', 'PermissionRoleController');
            $router->resource('user/permission', 'PermissionUserController');
//            $router->resource('permission', 'PermissionController');
        });

//        $router->group(['prefix' => 'user', 'namespace' => 'User'], function ($router) {
//            // 登录验证
//            $router->get('login', 'LoginController@index')->prefix('auth');
//        });
//        $router->get('login', 'LoginController@index')->prefix('auth');
    });
});