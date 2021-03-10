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
        /////////////////////
        /// 系统管理
        $route->get('/', 'AdminController@index'); //首页
        $route->get('/home', 'AdminController@home'); //主页统计
        $route->get('/menuList', 'AdminController@menuList'); //菜单列表
        $route->get('/editMenu/{id}', 'AdminController@editMenu'); //编辑菜单  添加/修改
        $route->get('/setting', 'AdminController@setting'); //系统设置
        $route->get('/editAdmin', 'AdminController@editAdmin'); //管理员信息修改
        $route->get('/adminLog', 'AdminController@adminLog'); //登录日志列表

        /////////////////////
        /// 用户管理
        $route->get('/user/userList', 'UserController@userList'); //用户列表

        /////////////////////
        /// 形象管理
        $route->get('/physique/physiqueSetList', 'PhysiqueController@physiqueSetList'); //身体部位管理列表
        $route->get('/physique/editPhysiqueSet/{id}', 'PhysiqueController@editPhysiqueSet'); //编辑身体部位管理

        $route->get('/physique/physiqueList', 'PhysiqueController@physiqueList'); //形象库管理列表
        $route->get('/physique/editPhysique/{id}', 'PhysiqueController@editPhysique'); //编辑官方形象库
    }
);

