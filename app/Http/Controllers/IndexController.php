<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*$data = array(
            'user_name' => 'qianjing',
            'phone' => '18651984625',
        );
        $this->userModel->create($data);*/

        /*$data = array(
            'goods_name' => '大宝',
            'num' => 1000
        );
        $this->goodsModel->create($data);*/
        Cache::flush();
        Redis::flushdb();
    }

    /**
     * 创建订单
     *
     * -c 100 -n 500
     * Time taken for tests:   38.246 seconds
     * Requests per second:    13.07 [#/sec] (mean)
     *
     * 无超卖现象
     */
    public function createOrder()
    {
        $goods_id = 1;
        $user_id = 1;

        $whereGoods['id'] = $goods_id;

        $goods = $this->goodsModel::where($whereGoods)->first();

        if ($goods->num < 1) {
            die;
        }

        $whereUser['id'] = $user_id;
        $user = $this->userModel::where($whereUser)->first();

        $data = array(
            'user_id' => $user->id,
            'goods_id' => $goods->id,
            'user_name' => $user->user_name,
            'phone' => $user->phone,
            'detail' => json_encode([
//                'num' => rand(1,10),
                'num' => 1,
                'goods_name' => $goods->goods_name,
            ]),
        );


        $this->goodsModel->decrement('num');
        $this->orderModel->create($data);
    }

    /**
     * 创建订单(缓存商品信息)
     *
     *  -c 100 -n 500
     * Time taken for tests:   37.393 seconds
     * Requests per second:    13.37 [#/sec] (mean)
     * RPS有适当提高 运行时间变短
     * 存在并发超卖情况
     */
    public function createOrder4Cache()
    {
//        Cache::flush();
        $goods_id = 1;
        $user_id = 1;

        $whereGoods['id'] = $goods_id;

        $goods = Cache::remember('goods_' . $goods_id, 30, function () use ($whereGoods) {
            $goodsCache = $this->goodsModel::where($whereGoods)->first();

//            Cache::put('goods_num_'.$goodsCache->id,$goodsCache->num);

            return $goodsCache;
        });

        /*if(!Cache::has('goods_'.$goods_id)){
            $goodsCache = $this->goodsModel::where($whereGoods)->first();

            Cache::put('goods_'.$goodsCache->id,$goodsCache);
            Cache::put('goods_num_'.$goodsCache->id,$goodsCache->num);
        }*/

//        Cache::decrement('goods_num_'.$goods_id);
//        $goods_num = Cache::get('goods_num_'.$goods_id);
//        dump($goods_num);

        if ($goods->num < 1) {
            die;
        }

        $whereUser['id'] = $user_id;
        $user = $this->userModel::where($whereUser)->first();

        $data = array(
            'user_id' => $user->id,
            'goods_id' => $goods->id,
            'user_name' => $user->user_name,
            'phone' => $user->phone,
            'detail' => json_encode([
//                'num' => rand(1,10),
                'num' => 1,
                'goods_name' => $goods->goods_name,
            ]),
        );

//        Cache::decrement('goods_num_'.$goods_id);
        $goods->num += -1;
        Cache::put('goods_' . $goods->id, $goods);

//        $dataGoods['num'] = Cache::get('goods_num_'.$goods_id);
        $dataGoods['num'] = $goods->num;
        $this->goodsModel::where($whereGoods)->update($dataGoods);
        $this->orderModel->create($data);
    }


    //异步redis队列
    public function createOrder4Redis()
    {
        $goods_id = 1;

        //取出用户 队列操作
        $user_one = Redis::rpop('user_list');
        if(!is_null($user_one)){
            $whereGoods['id'] = $goods_id;
            $goods = $this->goodsModel::where($whereGoods)->first();

            if ($goods->num < 1) {
                die;
            }

            $whereUser['id'] = $user_one;
            $user = $this->userModel::where($whereUser)->first();

            $data = array(
                'user_id' => $user->id,
                'goods_id' => $goods->id,
                'user_name' => $user->user_name,
                'phone' => $user->phone,
                'detail' => json_encode([
//                'num' => rand(1,10),
                    'num' => 1,
                    'goods_name' => $goods->goods_name,
                ]),
            );

            $this->goodsModel->decrement('num');
            $this->orderModel->create($data);

        }else{
            die;
        }



    }

    /**
     * 用户请求加入redis
     */
    public function addUserToRedis()
    {
        $user_id = 1;

        //放入redis队列
        Redis::lpush('user_list',$user_id);
    }


}
