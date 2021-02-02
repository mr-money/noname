<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});

//后台初始化信息
Route::get('/getSystemInit', 'AdminController@getSystemInit');

//后台api接口
Route::group([
//        'middleware' => ['web']
    ],
    function () {
        /////////////////////
        /// 后台管理
        Route::post('admin/loginAjax', 'AdminBaseController@loginAjax'); //后台登录ajax
        Route::post('admin/logoutAjax', 'AdminBaseController@logoutAjax'); //后台退出登录ajax

        Route::get('admin/getMenuListAjax', 'AdminController@getMenuListAjax'); //获取菜单列表ajax
        Route::post('admin/changeMenuStateAjax/{id}/{status}', 'AdminController@changeMenuStateAjax'); //修改菜单状态ajax
        Route::get('admin/getMenuDirAjax', 'AdminController@getMenuDirAjax'); //获取菜单目录ajax
        Route::post('admin/editMenuAjax', 'AdminController@editMenuAjax'); //添加修改菜单ajax
        Route::delete('admin/delMenuAjax/{id}', 'AdminController@delMenuAjax'); //删除菜单ajax

        Route::post('admin/editSettingAjax', 'AdminController@editSettingAjax'); //编辑网站设置ajax
        Route::post('admin/editAdminAjax/{id}', 'AdminController@aditAdminAjax'); //修改管理员信息ajax

        Route::get('admin/getAdminLogAjax', 'AdminController@getAdminLogAjax'); //获取登录日志列表ajax

        /////////////////////
        /// 用户管理
        Route::get('user/getUserListAjax', 'UserController@getUserListAjax'); //获取登录日志列表ajax
    }
);
