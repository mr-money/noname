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
        Route::post('admin/loginAjax', 'AdminBaseController@loginAjax'); //后台登录ajax
        Route::post('admin/logoutAjax', 'AdminBaseController@logoutAjax'); //后台退出登录ajax

        Route::get('admin/getMenuListAjax', 'AdminController@getMenuListAjax'); //后台退出登录ajax
        Route::post('admin/changeMenuStateAjax/{id}/{status}', 'AdminController@changeMenuStateAjax'); //修改菜单状态ajax
    }
);
