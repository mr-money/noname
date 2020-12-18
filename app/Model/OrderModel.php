<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\OrderModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderModel query()
 * @mixin \Eloquent
 */
class OrderModel extends Model
{

    protected $table = 'order'; // 指定表名
    protected $primaryKey = 'id'; //指定主键

//    protected $fillable = []; //白名单字段
    protected $guarded = [];//黑名单字段

    /**
     * 自动维护时间戳
     * @param \DateTime|int $value
     * @return false|int
     */
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    /**
     * 监听模型创建事件，在写入数据库之前触发
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // 判断订单号字段order_id是否为空，为空的话调用订单号生成方法
            if (!$model->order_num) {
                $model->order_num = static::findAvailableNo();
                // 如果生成失败，就返回false
                if (!$model->order_num) {
                    return false;
                }
            }
        });
    }

    /**
     * 生成随机订单号
     * @return bool|string
     * @throws \Exception
     */
    public static function findAvailableNo()
    {
        $prefix = date('Ymd');
        for ($i = 0; $i < 18; $i++) {
            // 随机生成 6 位的数字，并创建订单号
            $order_num = $prefix.random_int(100000, 999999).substr(microtime(true),-4);
            // 判断是否已经存在
            if (!static::query()->where('order_num', $order_num)->exists()) {
                return $order_num;
            }
        }
        //写入日志
        \Log::warning('find order no failed');

        return false;
    }

}
