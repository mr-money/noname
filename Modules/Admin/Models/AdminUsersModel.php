<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Admin\Models\AdminUsersModel
 *
 * @property int $id
 * @property string|null $avatar
 * @property string $nickname
 * @property string $account
 * @property string|null $phone 手机号（报名通知接收）
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUsersModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminUsersModel extends Model
{

    protected $fillable = [];

    protected $table = 'admin_users'; // 指定表名
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
