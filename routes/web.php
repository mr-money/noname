<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    echo '不知名APP';
//    return view('welcome');
});


//自定义404页面
Route::get('/404', function () {
    abort(404, '抱歉，未找到数据！');
});


Route::group([
    'middleware' => ['cors'],
//    'prefix' => '',
    ],
    function ($route) {
        $route->any('index', 'IndexController@index');
        $route->any('createOrder', 'IndexController@createOrder'); //mysql查询锁
        $route->any('createOrder4Cache', 'IndexController@createOrder4Cache'); //laravel缓存
        $route->any('createOrder4Redis', 'IndexController@createOrder4Redis'); //redis队列
        $route->any('addUserToRedis', 'IndexController@addUserToRedis'); //redis队列

    }
);

Route::post('/webhook', 'Webhook@index');

