<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\FacePhysiqueSettingModel
 *
 * @property int $id
 * @property string $part_name 部位名称
 * @property string $default_value 默认值
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel wherePartName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacePhysiqueSettingModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FacePhysiqueSettingModel extends Model
{
    //
    protected $table = 'face_physique_setting'; // 指定表名
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
