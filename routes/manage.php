<?php
/*
|--------------------------------------------------------------------------
| 手机端出入库相关路由
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'manage'], function (){

    //登录
    Route::get('/check', '\App\Manage\Controllers\LoginController@check');
    Route::post('/login', '\App\Manage\Controllers\LoginController@login');
    Route::get('/login/auth2', '\App\Manage\Controllers\LoginController@auth2');

    Route::group(['middleware' => 'manage'],function(){

        //待取件列表
        Route::get('/notake', '\App\Manage\Controllers\TakeController@noTake');
        //已取件列表
        Route::get('/take', '\App\Manage\Controllers\TakeController@take');
        //详情页面
        Route::post('/take/show', '\App\Manage\Controllers\TakeController@show');
        //修改取件订单
        Route::post('/take/update', '\App\Manage\Controllers\TakeController@update');

        //待入库列表
        Route::get('/nointo', '\App\Manage\Controllers\IntoController@noInto');
        //已入库列表
        Route::get('/into', '\App\Manage\Controllers\IntoController@into');
        //详情页面
        Route::post('/into/show', '\App\Manage\Controllers\IntoController@show');
        //修改入库订单
        Route::post('/into/update', '\App\Manage\Controllers\IntoController@update');

        //待出库列表
        Route::get('/noout', '\App\Manage\Controllers\OutController@noOut');
        //已出库列表
        Route::get('/out', '\App\Manage\Controllers\OutController@out');
        //详情页面
        Route::post('/out/show', '\App\Manage\Controllers\OutController@show');
        //修改出库订单
        Route::post('/out/update', '\App\Manage\Controllers\OutController@update');

        //待发出列表
        Route::get('/nosend', '\App\Manage\Controllers\SendController@noSend');
        //已发出列表
        Route::get('/send', '\App\Manage\Controllers\SendController@send');
        //详情页面
        Route::post('/send/show', '\App\Manage\Controllers\SendController@show');
        //修改发送订单
        Route::post('/send/update', '\App\Manage\Controllers\SendController@update');
    });

});


