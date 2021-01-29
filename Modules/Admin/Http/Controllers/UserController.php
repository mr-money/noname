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
    public function getUserListAjax(Request $request)
    {
        $param =  $request->post();
        $where = array();

        //搜索条件
        !empty($param['phone']) ? $where[] = ['phone', '=', $param['phone']] : '';
        !empty($param['username']) ? $where[] = ['username', 'like', '%'.$param['username'].'%'] : '';

        //时间条件
        //开始时间
        if (!empty($param['start_time'])) {
            $start_time = strtotime($param['start_time']);
            $where[] = array(
                'created_at',
                '>=',
                $start_time,
            );
        }

        //结束时间
        if (!empty($param['start_time'])) {
            $end_time = strtotime($param['end_time'] . '23:59:59');
            $where[] = array(
                'created_at',
                '<=',
                $end_time,
            );
        }

        //查询用户列表
        $userList = $this->faceUserModel->where($where)
            ->select('id','nickname','username','phone','sex','subscribe_time','avatar')
            ->orderBy('created_at','desc');
        $page = $this->layuiPage($userList,$param['page'],$param['limit']);

        return ApiReturn::jsonApi(ApiReturn::SUCCESS,'',$page);
    }
}
