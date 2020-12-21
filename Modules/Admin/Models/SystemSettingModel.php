<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Admin\Models\SystemSettingModel
 *
 * @property int $id
 * @property int|null $admin_id 管理员id
 * @property string|null $ip_adress 登录id地址
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereIpAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemSettingModel extends Model
{
//    protected $fillable = []; //白名单字段
    protected $guarded = []; //黑名单字段

    protected $table = 'admin_log'; // 指定表名
    protected $primaryKey = 'id'; //指定主键

    /**
     * 自动维护时间戳
     * @param \DateTime|int $value
     * @return false|int
     */
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
