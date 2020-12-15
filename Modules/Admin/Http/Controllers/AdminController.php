<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends AdminBaseController
{
    protected $adminViewDir = 'admin::admin.'; //admin页面view路径


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * admin首页
     */
    public function index()
    {
        return view($this->adminViewDir . 'index');
    }

    /**
     * 获取初始化菜单
     */
    public function getSystemInit(): JsonResponse
    {
        $homeInfo = [
            'title' => '首页',
            'href' => 'page/welcome-1.html?t=1',
        ];
        $logoInfo = [
            'title' => '不知名APP',
            'image' => '/layuimini/images/logo.png',
        ];
        $menuInfo = $this->getMenuList(true);
        $systemInit = [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
            'menuInfo' => $menuInfo,
        ];
        return response()->json($systemInit);
    }

    /**
     * 菜单管理列表页面
     */
    public function menuList()
    {
        return view($this->adminViewDir . 'menuList');
    }


    /**
     * 获取菜单列表ajax
     */
    public function getMenuListAjax(): JsonResponse
    {
        //获取菜单列表
        $menuList = $this->getMenuList();

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $menuList);
    }


    /**
     * 修改菜单状态ajax
     * @param int $id
     * @param int $status
     * @return JsonResponse
     */
    public function changeMenuStateAjax(int $id, int $status): JsonResponse
    {
        //id下所有子菜单都修改状态
        $data = [
            'status' => $status
        ];

        //查询包括本身所有子菜单id
        $menuList = $this->SystemMenuModel
            ->select(['id'])
            ->where('id', $id)
            ->with(['childMenus' => function ($query) {
                return $query->select(['pid', 'id']);
            }])->first();

        //展开子菜单id构建list
        $openMenuIds = $this->openMenuChild($menuList);


        //修改状态
        $res = $this->SystemMenuModel->whereIn('id', $openMenuIds)->update($data);

        if ($res > 0) {
            return ApiReturn::jsonApi(ApiReturn::SUCCESS, '修改成功', $res);
        } else {
            return ApiReturn::jsonApi(ApiReturn::DB_SAVE_ERROR, '修改失败', $res);
        }
    }


    /**
     * 菜单编辑页面  添加/修改
     * @param int $id
     * @return Factory|View
     */
    public function editMenu(int $id)
    {
        //id不为零  修改菜单  查询菜单
        $menu = array();
        if ($id !== 0) {
            $menu = $this->SystemMenuModel
                ->select(['id', 'pid', 'title', 'icon', 'href', 'target', 'sort', 'remark'])
                ->where(['id' => $id])
                ->first();

            $menu->parent = $this->SystemMenuModel
                ->select(['title'])
                ->where(['id' => $menu->pid])
                ->first();
        }

        return view($this->adminViewDir . 'editMenu')->with('menu', $menu);
    }


    /**
     * 获取菜单目录ajax
     * @return JsonResponse
     */
    public function getMenuDirAjax(): JsonResponse
    {
        //查询目录
        $menu = $this->SystemMenuModel
            ->select(['id', 'pid', 'title'])
            ->where(['href' => ''])
            ->get();

        //构建子菜单
        (array)$menuDir = $this->buildMenuChild(0, $menu);

        //菜单开头插入顶级菜单pid为0
        $topMenu = array(
            'id' => 0,
            'pid' => 0,
            'title' => '顶级菜单',
        );
        array_unshift($menuDir,$topMenu);

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $menuDir);
    }

    /**
     * 添加修改菜单ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function editMenuAjax(Request $request): JsonResponse
    {
        $post = $request->post();

        $data = array(
            'pid' => (int)$post['pid'],
            'title' => $post['title'],
            'icon' => $post['icon'],
            'href' => (string)$post['href'],
            'target' => $post['target'],
            'sort' => (int)$post['sort'],
            'remark' => (string)$post['remark'],
        );

        //添加
        if((int)$post['id'] === 0){

        }else{ //修改

        }


        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $data);
    }



/////////////////////////////////////////////////////////////////////

    /**
     * 循环添加默认菜单
     */
    public function addMenu()
    {
        $lint = json_decode(file_get_contents(public_path() . '/layuimini/api/init.json'), true);

        $menu_info = $lint['menuInfo'];

        $add_data = [];
        foreach ($menu_info as $value) {
            $data = array(
                'pid' => 0,
                'title' => $value['title'],
                'icon' => $value['icon'],
                'href' => $value['href'],
                'target' => $value['target'],
                'sort' => 0,
                'status' => 1,
            );
            $add_data[] = $data;

            $id = $this->SystemMenuModel->create($data)->id;

            if (!isset($value['child'])) {
                continue;
            }
            foreach ($value['child'] as $val) {
                $data2 = array(
                    'pid' => $id,
                    'title' => $val['title'],
                    'icon' => $val['icon'],
                    'href' => $val['href'],
                    'target' => $val['target'],
                    'sort' => 0,
                    'status' => 1,
                );
                $add_data[] = $data2;

                $id2 = $this->SystemMenuModel->create($data2)->id;

                if (!isset($val['child'])) {
                    continue;
                }
                foreach ($val['child'] as $v) {
                    $data3 = array(
                        'pid' => $id2,
                        'title' => $v['title'],
                        'icon' => $v['icon'],
                        'href' => $v['href'],
                        'target' => $v['target'],
                        'sort' => 0,
                        'status' => 1,
                    );
                    $add_data[] = $data3;

                    $id3 = $this->SystemMenuModel->create($data3)->id;
                }
            }
        }

        dump($add_data);

    }

}
