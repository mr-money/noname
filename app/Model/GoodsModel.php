<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\GoodsModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GoodsModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoodsModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoodsModel query()
 * @mixin \Eloquent
 */
class GoodsModel extends Model
{
    //
    protected $table = 'goods'; // 指定表名
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
}
