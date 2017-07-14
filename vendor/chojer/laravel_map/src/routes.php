<?php

Route::group(['namespace' => 'Chojer\Laravel\Map\Controllers', 'middleware' => 'auth', 'prefix' => 'map'], function ($router) {
    $router->resource('destination', 'DestinationController');
});