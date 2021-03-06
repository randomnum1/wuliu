<?php

/*
|--------------------------------------------------------------------------
| 客户端相关路由
|--------------------------------------------------------------------------
*/

//微信授权接口
Route::get('/auth2', 'WeChatController@auth2');

//微信auth授权后才可访问
Route::group(['middleware' => 'wechat'], function (){
    //测试接口
    Route::get('/test', 'TestController@index');
    Route::post('/test', 'TestController@test');

    //地址列表
    Route::get('/address', 'AddressController@index');
    //地址详情
    Route::post('/address/show', 'AddressController@show');
    //新增地址
    Route::post('/address/create', 'AddressController@create');
    //修改地址
    Route::post('/address/update', 'AddressController@update');
    //删除地址
    Route::post('/address/delete', 'AddressController@delete');
    //设为默认地址
    Route::post('/address/setting', 'AddressController@setting');
    //省市区接口
    Route::get('/address/china', 'AddressController@china');

    //商城首页接口
    Route::get('/goods', 'GoodsController@index');
    //商品详情页
    Route::get('/goods/show', 'GoodsController@show');
    //购物车列表接口
    Route::get('/goods/car', 'GoodsController@car');
    //购物车新增接口
    Route::post('/goods/car/add', 'GoodsController@add');
    //购物车-修改数量接口
    Route::post('/goods/car/update', 'GoodsController@update');

    //个人中心接口
    Route::get('/user/index', 'UserController@index');

    //邮寄首页接口
    Route::get('/mail/index', 'MailsController@index');
    //邮寄新增接口
    Route::post('/mail/create', 'MailsController@create');
    //邮寄查询接口
    Route::post('/mail/search', 'MailsController@search');
    //邮寄详情接口
    Route::post('/mail/show', 'MailsController@show');
    //邮寄付款接口
    Route::post('/mail/pay', 'MailsController@pay');
    //邮寄修改付款凭证接口
    Route::post('/mail/pay_update', 'MailsController@pay_update');
});

include_once('manage.php');
include_once('admin.php');
