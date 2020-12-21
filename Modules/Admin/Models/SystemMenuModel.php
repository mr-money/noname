<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Admin\Models\systemMenuModel
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
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property string|null $deleted_at 删除时间
 * @property-read \Illuminate\Database\Eloquent\Collection|systemMenuModel[] $childMenus
 * @property-read int|null $child_menus_count
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|systemMenuModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class systemMenuModel extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childMenus()
    {
        return $this->hasMany(self::class, 'pid', 'id')->with('childMenus');
    }
}
