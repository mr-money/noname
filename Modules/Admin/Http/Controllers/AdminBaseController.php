<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Models\SystemMenuModel;

class AdminBaseController extends Controller
{

    protected $SystemMenuModel; //后台菜单模型

    public function __construct()
    {
        $this->SystemMenuModel = new SystemMenuModel();
    }

    //登录页面
    public function login()
    {
        return view('admin::admin.login');
    }

    /**
     * 后台登录ajax
     * @param Request $request
     */
    //TODO 404
    public function loginAjax(Request $request)
    {
        ApiReturn::ApiReturn($request->post());
    }

}