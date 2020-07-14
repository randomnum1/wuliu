<?php
/*
|--------------------------------------------------------------------------
| 后端相关路由
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin','middleware' => 'log'], function (){

    //根目录
    Route::get('/', function(){ return redirect('/admin/login');});
    //登陆页面
    Route::get('/login', '\App\Admin\Controllers\LoginController@index')->name('login');
    //登陆行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    //登出行为
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');

    Route::group(['middleware' => 'auth:admin'],function(){

        //首页左侧
        Route::get('/index', '\App\Admin\Controllers\HomeController@index');
        //首页右侧
        Route::get('/home', '\App\Admin\Controllers\HomeController@home');

        Route::group(['middleware' => 'can:users'],function(){
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
            //权限页面
            Route::get('/user/{user}/auth', '\App\Admin\Controllers\UserController@auth');
            //修改权限
            Route::post('/user/auth', '\App\Admin\Controllers\UserController@doauth');
        });

        Route::group(['middleware' => 'can:members'], function(){
            //会员列表
            Route::get('/member', '\App\Admin\Controllers\MemberController@index');
            //会员积分更新
            Route::post('/member/update', '\App\Admin\Controllers\MemberController@update');
            //会员收货地址
            Route::get('/member/address', '\App\Admin\Controllers\MemberController@address');
            //会员导出
            Route::get('/member/export', '\App\Admin\Controllers\MemberController@export');
        });

        Route::group(['middleware' => 'can:goods'], function(){
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
            Route::get('/goods/{goods}/show', '\App\Admin\Controllers\GoodsController@show');
            //商品新增
            Route::get('/goods/create', '\App\Admin\Controllers\GoodsController@create');
            //商品新增行为
            Route::post('/goods/store', '\App\Admin\Controllers\GoodsController@store');
            //商品修改行为
            Route::post('/goods/update', '\App\Admin\Controllers\GoodsController@update');
            //商品上下架
            Route::post('/goods/state', '\App\Admin\Controllers\GoodsController@state');
            //商品删除
            Route::post('/goods/delete', '\App\Admin\Controllers\GoodsController@delete');
            //商品导出
            Route::get('/goods/export', '\App\Admin\Controllers\GoodsController@export');
        });

        Route::group(['middleware' => 'can:system'], function(){
            //仓库列表
            Route::get('/system/warehouse', '\App\Admin\Controllers\SystemController@warehouse');
            Route::post('/system/warehouse/delete', '\App\Admin\Controllers\SystemController@delete');
            Route::post('/system/warehouse/warehouse_add', '\App\Admin\Controllers\SystemController@warehouse_add');
            Route::post('/system/warehouse/location_add', '\App\Admin\Controllers\SystemController@location_add');
            Route::post('/system/warehouse/location_update', '\App\Admin\Controllers\SystemController@location_update');
            //日志列表
            Route::get('/system/log', '\App\Admin\Controllers\SystemController@log');
            //日期列表
            Route::get('/system/date', '\App\Admin\Controllers\SystemController@date');
            //上班-休息
            Route::post('/system/date/state', '\App\Admin\Controllers\SystemController@state');
            //获取日期
            //Route::get('/system/date/add', '\App\Admin\Controllers\SystemController@add');
        });

        Route::group(['middleware' => 'can:mails'], function(){
            //全部邮寄订单页面
            Route::get('/mails/all', '\App\Admin\Controllers\MailsController@all');
            //待核价订单页面
            Route::get('/mails/check', '\App\Admin\Controllers\MailsController@check');
            //待付款订单页面
            Route::get('/mails/pay', '\App\Admin\Controllers\MailsController@pay');
            //待确认订单页面
            Route::get('/mails/confirm', '\App\Admin\Controllers\MailsController@confirm');
            //订单详情页面
            Route::get('/mails/{mails}/show', '\App\Admin\Controllers\MailsController@show');
            //核价详情页面
            Route::get('/mails/{mails}/check_show', '\App\Admin\Controllers\MailsController@check_show');
            //获取物品信息接口
            Route::post('/mails/get_items', '\App\Admin\Controllers\MailsController@get_items');
            //核价详情逻辑
            Route::post('/mails/check_update', '\App\Admin\Controllers\MailsController@check_update');
            //确认详情页面
            Route::get('/mails/{mails}/confirm_show', '\App\Admin\Controllers\MailsController@confirm_show');
            //确认详情逻辑
            Route::post('/mails/confirm_update', '\App\Admin\Controllers\MailsController@confirm_update');
            //订单导出
            Route::get('/mails/export', '\App\Admin\Controllers\MailsController@export');
        });

    });

});


