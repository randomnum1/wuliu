<?php

Route::group(['prefix' => 'admin'], function (){
    //登陆页面
    Route::get('/login', '\App\Admin\Controllers\LoginController@index')->name('login');
    //登陆行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    //登出行为
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');


    Route::group(['middleware' => 'auth:admin'],function(){
        //首页左侧
        Route::get('/', '\App\Admin\Controllers\HomeController@index');
        Route::get('/index', '\App\Admin\Controllers\HomeController@index');
        //首页右侧
        Route::get('/home', '\App\Admin\Controllers\HomeController@home');

        //管理员列表
        Route::get('/user', '\App\Admin\Controllers\UserController@index');
        //管理员新增
        Route::post('/user/create', '\App\Admin\Controllers\UserController@create');
        //管理员删除
        Route::post('/user/delete', '\App\Admin\Controllers\UserController@delete');
        //管理员更新
        Route::post('/user/update', '\App\Admin\Controllers\UserController@update');
        //重置密码
        Route::post('/user/setting', '\App\Admin\Controllers\UserController@setting');
        //管理员权限
        Route::get('/user/auth', '\App\Admin\Controllers\UserController@auth');

        //会员列表
        Route::get('/member', '\App\Admin\Controllers\MemberController@index');
        //会员积分更新
        Route::post('/member/update', '\App\Admin\Controllers\MemberController@update');
        //会员收货地址
        Route::get('/member/address', '\App\Admin\Controllers\MemberController@address');
        //会员导出
        Route::get('/member/export', '\App\Admin\Controllers\MemberController@export');

        //商品类别列表
        Route::get('/sort', '\App\Admin\Controllers\SortController@index');
        //类别新增
        Route::post('/sort/create', '\App\Admin\Controllers\SortController@create');
        //类别修改
        Route::post('/sort/update', '\App\Admin\Controllers\SortController@update');
        //类别删除
        Route::post('/sort/delete', '\App\Admin\Controllers\SortController@delete');

        //商品列表
        Route::get('/goods', '\App\Admin\Controllers\GoodsController@index');
        //商品详情
        Route::get('/goods/{goods}', '\App\Admin\Controllers\GoodsController@show');
        //商品新增
        Route::get('/goods/create', '\App\Admin\Controllers\GoodsController@create');
        //商品新增行为
        Route::post('/goods/store', '\App\Admin\Controllers\GoodsController@store');
        //商品修改
        Route::get('/goods/{goods}/edit', '\App\Admin\Controllers\GoodsController@edit');
        //商品修改行为
        Route::post('/goods/update', '\App\Admin\Controllers\GoodsController@update');
        //商品上下架
        Route::post('/goods/state', '\App\Admin\Controllers\GoodsController@state');
        //商品删除
        Route::post('/goods/delete', '\App\Admin\Controllers\GoodsController@delete');
        //商品导出
        Route::get('/goods/export', '\App\Admin\Controllers\GoodsController@export');


        //日期列表
        Route::get('/date', '\App\Admin\Controllers\DateController@index');
        //上班-休息
        Route::post('/date/state', '\App\Admin\Controllers\DateController@state');
    });

});


