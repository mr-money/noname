<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Admin\Models\SystemMenuModel;

class AdminBaseController extends Controller
{

    protected $SystemMenuModel; //后台菜单模型

    public function __construct()
    {
        $this->SystemMenuModel = new SystemMenuModel();
    }


    /**
     * 获取菜单列表
     * @return array
     */
    protected function getMenuList()
    {
        $menuList = $this->SystemMenuModel
            ->select(['id', 'pid', 'title', 'icon', 'href', 'target'])
            ->where('status', 1)
            ->orderBy('sort', 'desc')
            ->get();

        $menuList = $this->buildMenuChild(0, $menuList);
        return (array)$menuList;
    }


    /**
     * 递归获取子菜单
     * @param $pid 父级id
     * @param $menuList 父级菜单组
     * @return array
     */
    protected function buildMenuChild($pid, $menuList)
    {
        $treeList = [];
        foreach ($menuList as $v) {
            if ($pid == $v->pid) {
                $node = $v->toArray();
                $child = $this->buildMenuChild($v->id, $menuList);
                if (!empty($child)) {
                    $node['child'] = $child;
                }
                // todo 后续此处加上用户的权限判断
                $treeList[] = $node;
            }
        }
        return $treeList;
    }
}