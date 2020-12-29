<?php

namespace Modules\Admin\Http\Controllers;

use App\AdminUser;
use App\Http\Controllers\ApiReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Modules\Admin\Models\AdminLogModel;
use Modules\Admin\Models\AdminUsersModel;
use Modules\Admin\Models\systemMenuModel;
use Modules\Admin\Models\SystemSettingModel;

class AdminBaseController extends Controller
{

    protected $systemMenuModel; //后台菜单模型
    protected $adminUsersModel; //管理员用户模型
    protected $adminLogModel; //管理员登录记录模型
    protected $systemSettingModel; //网站设置模型

    public function __construct()
    {
        $this->systemMenuModel = new SystemMenuModel();
        $this->adminUsersModel = new AdminUsersModel();
        $this->adminLogModel = new AdminLogModel();
        $this->systemSettingModel = new SystemSettingModel();
    }


    /**
     * 登录页面
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function login(Request $request)
    {
        //已登录 跳转首页
        if ($request->session()->has('admin')) {
            return redirect('admin');
        }

        //记住密码
        $admin = $request->cookie('admin_remember');

        return view('admin::admin.login')->with([
            'admin' => json_decode($admin, true),
        ]);
    }

    /**
     * 后台登录ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAjax(Request $request): JsonResponse
    {
        $post = $request->post();

        //查询管理员
        $admin = $this->adminUsersModel::whereAccount($post['account'])->first();

        if (empty($admin)) {
            return ApiReturn::jsonApi(ApiReturn::LOGIN_ERROR, '账号不存在');
        }

        //检查密码
        if (!Hash::check($post['password'], $admin->password)) {
            return ApiReturn::jsonApi(ApiReturn::LOGIN_ERROR, '密码输入不正确');
        }

        //登录成功
        $request->session()->put('admin', $admin);

        //记住密码 存入cookie
        if ((bool)$post['rememberMe']) {
            Cookie::queue('admin_remember', json_encode($post), 7 * 24 * 60);
        } else {
            //取消记住密码
            Cookie::queue(Cookie::forget('admin_remember'));
        }

        //记录登录日志
        $this->saveLoginLog($request, $admin);

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '登录成功', $request->post());
    }


    /**
     * 退出登录ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function logoutAjax(Request $request): JsonResponse
    {
        if ($request->session()->has('admin')) {
            $request->session()->forget('admin');
        }

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '退出登录');
    }

    /**
     * 记录管理员登录log
     * @param Request $request
     * @param $admin
     * @return bool
     */
    public function saveLoginLog(Request $request, $admin): bool
    {
        $this->adminLogModel->fill([
            'admin_id' => $admin->id,
            'ip_adress' => $request->getClientIp(),
        ]);

        return $this->adminLogModel->save();
    }

    /**
     * 获取菜单列表fun
     * @param bool $buildMenuChild
     * @return array|object
     */
    protected function getMenuList($buildMenuChild = false)
    {
        $menuList = $this->systemMenuModel
            ->select(['id', 'pid', 'title', 'icon', 'href', 'remark', 'target', 'sort', 'status', 'created_at'])
            ->where('create_id', session('admin.id'))
            //需要构建子菜单 查询状态为1已启用
            ->when($buildMenuChild, function ($query) {
                return $query->where('status', 1);

                //查询所有菜单
            }, function ($query) {
                return $query->whereNotNull('created_at');
            })
            ->orderBy('sort', 'desc')
            ->get();

        //构建子菜单
        if ($buildMenuChild) {
            (array)$menuList = $this->buildMenuChild(0, $menuList);
        }
        return $menuList;
    }

    /**
     * 递归获取子菜单
     * @param int $pid 父级id
     * @param $menuList //父级菜单组
     * @return array
     */
    protected function buildMenuChild(int $pid, $menuList): array
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
        return (array)$treeList;
    }


    /**
     * 多维子菜单展开一维
     * @param $menuList
     * @return array
     */
    protected function openMenuChild($menuList): array
    {
        static $i = 0; //调用次数
        $list = []; //菜单list

        $i++;  //次数加1

        //首次调用push当前菜单id
        if ($i === 1) {
            $list[] = $menuList->id;
        }

        foreach ($menuList->childMenus as $value) {
            //push当前子菜单id
            $list[] = $value['id'];

            //递归获取子菜单id
            $child = $this->openMenuChild($value);

            //合并菜单list
            if (!empty($child)) {
                $list = array_merge($list, $child);
            }
        }

        return (array)$list;
    }




    /**
     * TODO layui分页数据
     * @param $query
     * @param int $current_page
     * @param int $limit
     * @return array
     */
    protected function layuiPage($query, $current_page = 1, $limit = 15)
    {
        $skip = ($current_page - 1) < 0 ? 0 : ($current_page - 1) * $limit;
        $total = $query->count(); //总数据
        $data = $query->skip($skip)->limit($limit)->get();

        return compact('data','current_page','limit' ,'total');
    }
}
