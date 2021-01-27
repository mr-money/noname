<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }


    //用户列表

    /**
     * @return Application|Factory|View
     */
    public function userList()
    {
        return view('admin::user.userList');
    }


    //获取用户列表ajax
    public function getUserListAjax(Request $request): JsonResponse
    {
        $get = $request->all('page','limit');

        $where = array();

        //查询用户列表
        $userList = $this->faceUserModel->where($where)->orderBy('created_at','desc');
        $page = $this->layuiPage($userList,$get['page'],$get['limit']);

        return ApiReturn::jsonApi(ApiReturn::SUCCESS,'',$page);
    }
}
