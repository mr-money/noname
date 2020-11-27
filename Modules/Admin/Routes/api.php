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
        'middleware' => ['web']
    ],
    function () {
        Route::post('admin/loginAjax', 'AdminBaseController@loginAjax');
    }
);
