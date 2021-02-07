<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Cache;
use function GuzzleHttp\Psr7\str;

class AdminController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * admin首页
     * @return Factory|View
     */
    public function index()
    {
        //查询缓存中网站设置信息
        if (!Cache::has('site_setting')) {
            $setting = $this->systemSettingModel::whereCreateId(session('admin.id'))->first();
            Cache::add('site_setting', $setting);
        }

        $setting = Cache::get('site_setting');

        return view('admin::admin.index')->with('setting', $setting);
    }

    /**
     * admin默认主页
     * @return Factory|View
     */
    public function home()
    {
        return view('admin::admin.home');
    }

    /**
     * 获取初始化菜单
     * @return JsonResponse
     */
    public function getSystemInit(): JsonResponse
    {
        $homeInfo = [
            'title' => '首页',
            'href' => 'admin/home',
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
     * 管理员信息修改
     * @return Factory|View
     */
    public function editAdmin()
    {
        return view('admin::admin.editAdmin');
    }


    /**
     * 修改管理员信息ajax
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function editAdminAjax(int $id, Request $request): JsonResponse
    {
        $post = $request->post();

        //修改信息
        $data = array(
            'nickname' => $post['nickname'],
            'phone' => $post['phone'],
        );

        //修改密码
        if (!empty($post['password'])) {
            //检查密码
            if (!Hash::check($post['old_password'], session('admin.password'))) {
                return ApiReturn::jsonApi(ApiReturn::LOGIN_ERROR, '密码输入不正确');
            }

            $data['password'] = Hash::make($post['password']);
        }

        //更新
        $this->adminUsersModel::whereId($id)->update($data);

        //刷新session
        $admin = $this->adminUsersModel::whereId($id)->first();
        $request->session()->put('admin', $admin);

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $data);

    }

    /**
     * 菜单管理列表页面
     * @return Factory|View
     */
    public function menuList()
    {
        return view('admin::admin.menuList');
    }

    /**
     * 获取菜单列表ajax
     * @return JsonResponse
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
        $openMenuIds = $this->getChildMenusById($id);

        //修改状态
        $res = $this->systemMenuModel->whereIn('id', $openMenuIds)->update($data);

        if ($res > 0) {
            return ApiReturn::jsonApi(ApiReturn::SUCCESS, '修改成功', $res);
        } else {
            return ApiReturn::jsonApi(ApiReturn::DB_SAVE_ERROR, '修改失败', $res);
        }
    }

    /**
     * 删除菜单ajax
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delMenuAjax(int $id): JsonResponse
    {
        //查询包括本身所有子菜单id
        $openMenuIds = $this->getChildMenusById($id);

        //id下所有子菜单都删除
        $res = $this->systemMenuModel->whereIn('id', $openMenuIds)->delete();

        if ($res > 0) {
            return ApiReturn::jsonApi(ApiReturn::SUCCESS, '删除成功', $res);
        } else {
            return ApiReturn::jsonApi(ApiReturn::DB_SAVE_ERROR, '删除失败', $res);
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
            $menu = $this->systemMenuModel
                ::whereId($id)
                ->select(['id', 'pid', 'title', 'icon', 'href', 'target', 'sort', 'remark'])
                ->first();

            //查询父级菜单
            $menu->parent = $this->systemMenuModel
                ::whereId($menu->pid)
                ->select(['title'])
                ->first();
        }

        return view('admin::admin.editMenu')->with('menu', $menu);
    }


    /**
     * 获取菜单目录ajax
     * @return JsonResponse
     */
    public function getMenuDirAjax(): JsonResponse
    {
        //查询目录
        $menu = $this->systemMenuModel
            ::whereHref('')
            ->where('create_id', session('admin.id'))
            ->select(['id', 'pid', 'title'])
            ->get();

        //构建子菜单
        $menuDir = $this->buildMenuChild(0, $menu);

        //菜单开头插入顶级菜单pid为0
        $topMenu = array(
            'id' => 0,
            'pid' => 0,
            'title' => '顶级菜单',
        );
        array_unshift($menuDir, $topMenu);

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
            'icon' => 'fa ' . $post['icon'],
            'href' => (string)$post['href'],
            'target' => $post['target'],
            'sort' => (int)$post['sort'],
            'remark' => $post['remark'],
            'create_id' => session('admin.id'),
        );

        //添加
        if ((int)$post['id'] === 0) {
            $res = $this->systemMenuModel->create($data)->id; //返回创建id
        } else { //修改
            $res = $this->systemMenuModel::whereId($post['id'])->update($data);
        }

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $res);
    }


    /**
     * 系统设置
     * @return Factory|View
     */
    public function setting()
    {
        $setting = $this->systemSettingModel::whereCreateId(session('admin.id'))->first();

        return view('admin::admin.setting')
            ->with('setting', $setting);
    }


    /**
     * 修改系统设置ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function editSettingAjax(Request $request): JsonResponse
    {
        $post = $request->post();

        $data = array(
            'sitename' => $post['sitename'],
            'domain' => $post['domain'],
            'title' => $post['title'],
            'keywords' => $post['keywords'],
            'descript' => $post['descript'],
            'copyright' => $post['copyright'],
            'create_id' => session('admin.id'),
        );

        //添加
        if ((int)$post['id'] === 0) {
            $res = $this->systemSettingModel->create($data)->id; //返回创建id
        } else { //修改
            $res = $this->systemSettingModel::whereId($post['id'])->update($data);
        }

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $res);
    }


    /**
     * 登录日志列表
     * @return Factory|View
     */
    public function adminLog()
    {
        return view('admin::admin.adminLog');
    }

    /**
     * 获取登录日志列表ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function getAdminLogAjax(Request $request): JsonResponse
    {
        $get = $request->all('page','limit');

        //登录日志
        $adminLog = $this->adminLogModel::with('adminUser')->orderBy('created_at','desc');

        $page = $this->layuiPage($adminLog,$get['page'],$get['limit']);

        //加入管理员信息
        foreach ((array)$page['data'] as $key=>$value) {
            $page['data'][$key]['nickname'] = $value['admin_user']['nickname'];
            $page['data'][$key]['phone'] = $value['admin_user']['phone'];
            $page['data'][$key]['account'] = $value['admin_user']['account'];

            unset($page['data'][$key]['admin_user']);
        }

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $page);;
    }


/////////////////////////////////////////////////////////////////////
/// 私有方法

    /**
     * 通过id查询包括本身所有子菜单id
     * @param int $id 菜单id
     * @return array|object 包括本身所有子菜单id list
     */
    private function getChildMenusById(int $id)
    {
        $menuList = $this->systemMenuModel
            ::whereId($id)
            ->select(['id'])
            ->with(['childMenus' => function ($query) {
                return $query->select(['pid', 'id']);
            }])->first();

        //展开子菜单id构建list
        (array)$openMenuIds = $this->openMenuChild($menuList);

        return $openMenuIds;
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

            $id = $this->systemMenuModel->create($data)->id;

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

                $id2 = $this->systemMenuModel->create($data2)->id;

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

                    $id3 = $this->systemMenuModel->create($data3)->id;
                }
            }
        }

        dump($add_data);
    }

}
