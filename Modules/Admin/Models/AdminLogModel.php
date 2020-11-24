<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLogModel extends Model
{

    protected $fillable = [];

    protected $table = 'admin_log'; // 指定表名
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
