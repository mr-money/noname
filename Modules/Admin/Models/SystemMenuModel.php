<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Modules\Admin\Models\SystemMenuModel
 *
 * @property int $id ID
 * @property int $pid 父ID
 * @property string $title 名称
 * @property string $icon 菜单图标
 * @property string $href 链接
 * @property string $target 链接打开方式
 * @property int|null $sort 菜单排序
 * @property int $status 状态(0:禁用,1:启用)
 * @property string|null $remark 备注信息
 * @property int $create_id 创建人id
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection|SystemMenuModel[] $childMenus
 * @property-read int|null $child_menus_count
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereCreateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Modules\Admin\Models\AdminUsersModel $createUser
 */
class SystemMenuModel extends Model
{

    protected $fillable = [];

    protected $table = 'system_menu'; // 指定表名
    protected $primaryKey = 'id'; //指定主键

//    protected $fillable = []; //白名单字段
    protected $guarded = [];//黑名单字段

    /**
     * 自动维护时间戳
     * @param \DateTime|int $value
     * @return false|int
     */
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }

    /**
     * 子菜单关联
     * @return HasMany
     */
    public function childMenus(): HasMany
    {
        return $this->hasMany(self::class, 'pid', 'id')->with('childMenus');
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
