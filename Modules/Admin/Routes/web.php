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



/*******************************
 * 后台管理页面
 */

Route::get('admin/login', 'AdminController@login'); //登录页面


//验证登录组
Route::group(
    [
        'middleware' => ['web','admin.checkLogin'],
        'prefix' => 'admin',
    ],
    function ($route) {
        $route->get('/', 'AdminController@index'); //首页
        $route->get('/menuList', 'AdminController@menuList'); //菜单列表
    }
);

