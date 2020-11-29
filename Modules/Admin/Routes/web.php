<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index'); //首页

//    Route::get('/addMenu', 'AdminController@addMenu');

    Route::get('/login', 'AdminController@login'); //登录页面
    Route::get('/menuList', 'AdminController@menuList')->middleware('admin.checkLogin'); //菜单列表
});
