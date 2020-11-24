<?php
namespace Modules\Admin\Http\Controllers;

use App\AdminUser;
use App\Http\Controllers\ApiReturn;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\AdminLogModel;
use Modules\Admin\Models\AdminUsersModel;
use Modules\Admin\Models\SystemMenuModel;

class AdminBaseController extends Controller
{

    protected $SystemMenuModel; //后台菜单模型
    protected $adminUsersModel; //管理员用户模型
    protected $adminLogModel; //管理员登录记录模型

    public function __construct()
    {
        $this->SystemMenuModel = new SystemMenuModel();
        $this->adminUsersModel = new AdminUsersModel();
        $this->adminLogModel = new AdminLogModel();
    }

    //登录页面
    public function login()
    {
        $admin = session('admin');

        return view('admin::admin.login');
    }


    /**
     * 后台登录ajax
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAjax(Request $request)
    {
        $post = $request->post();

        //查询管理员
        $admin = $this->adminUsersModel::where('account', $post['account'])->first();

        if (empty($admin)) {
            return ApiReturn::jsonApi(ApiReturn::LOGIN_ERROR,'账号不存在');
        }

        //检查密码
        if (!Hash::check($post['password'], $admin->password)) {
            return ApiReturn::jsonApi(ApiReturn::LOGIN_ERROR,'密码输入不正确');
        }

        //登录成功
        $request->session()->put('admin', $admin);

        //TODO 记住密码
        if($post['rememberMe']){

        }

        //记录登录日志
        $this->saveLoginLog($request,$admin);

        return ApiReturn::jsonApi(200,'登录成功',$request->post());
    }

    /**
     * 记录管理员登录log
     * @param Request $request
     * @param $admin
     * @return bool
     */
    public function saveLoginLog(Request $request,$admin)
    {
        $this->adminLogModel->fill([
            'admin_id' => $admin->id,
            'ip_adress' => $request->getClientIp(),
        ]);
        $res = $this->adminLogModel->save();
        return $res;
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