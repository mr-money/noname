<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\FacePhysiqueModel
 *
 * @property int $id
 * @property string $part_name 部位名称
 * @property string $part_value 部位数据
 * @property int $user_id 用户表id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel wherePartName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel wherePartValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueModel whereUserId($value)
 * @mixin \Eloquent
 */
class FacePhysiqueModel extends Model
{
    //
    protected $table = 'face_physique'; // 指定表名
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
