<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Admin\Models\SystemSettingModel
 *
 * @property int $id
 * @property string $sitename 网站名称
 * @property string $domain 网站域名
 * @property string $title 首页标题
 * @property string|null $keywords META关键词
 * @property string|null $descript META描述
 * @property string $copyright 版权信息
 * @property int $create_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Modules\Admin\Models\AdminUsersModel $createUser
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereCreateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereDescript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereSitename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSettingModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemSettingModel extends Model
{
//    protected $fillable = []; //白名单字段
    protected $guarded = []; //黑名单字段

    protected $table = 'system_setting'; // 指定表名
    protected $primaryKey = 'id'; //指定主键

    /**
     * 自动维护时间戳
     * @param \DateTime|int $value
     * @return false|int
     */
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }


    /**
     * 创建人关联
     * @return BelongsTo
     */
    public function createUser(): BelongsTo
    {
        return $this->belongsTo('Modules\Admin\Models\AdminUsersModel','create_id','id');
    }

}
