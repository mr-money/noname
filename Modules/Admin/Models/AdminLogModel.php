<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Admin\Models\AdminLogModel
 *
 * @property int $id
 * @property int|null $admin_id 管理员id
 * @property string|null $ip_adress 登录id地址
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel whereIpAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLogModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
