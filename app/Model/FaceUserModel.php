<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\FaceUserModel
 *
 * @property int $id
 * @property string $openid
 * @property string $nickname
 * @property string $username 姓名
 * @property int|null $sex 1男 0女
 * @property int|null $subscribe_time 关注时间
 * @property string $city
 * @property string $province
 * @property string $country
 * @property int $is_subscribe 是否关注 1关注 0未关注
 * @property string $personal_signature 个人签名
 * @property int $user_state 用户状态 1正常 2禁用
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereIsSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel wherePersonalSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereSubscribeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereUserState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaceUserModel whereUsername($value)
 * @mixin \Eloquent
 */
class FaceUserModel extends Model
{
    //
    protected $table = 'face_user'; // 指定表名
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
