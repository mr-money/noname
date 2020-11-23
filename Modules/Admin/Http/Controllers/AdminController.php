<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use App\Http\Controllers\ResponseCtrl;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class AdminController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * admin首页
     * @return Renderable
     */
    public function index()
    {
        return view('admin::admin.index');
    }

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


    public function addMenu()
    {
        $lint = json_decode(file_get_contents(public_path().'/layuimini/api/init.json'),true);

        $menu_info = $lint['menuInfo'];

        $add_data = [];
        foreach ($menu_info as $value){
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

            if(!isset($value['child'])){
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

                if(!isset($val['child'])){
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


    /**
     * 获取初始化菜单
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSystemInit()
    {
        $homeInfo = [
            'title' => '首页',
            'href' => 'page/welcome-1.html?t=1',
        ];
        $logoInfo = [
            'title' => '不知名APP',
            'image' => '/layuimini/images/logo.png',
        ];
        $menuInfo = $this->getMenuList();
        $systemInit = [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
            'menuInfo' => $menuInfo,
        ];
        return response()->json($systemInit);
    }

    public function testOut()
    {
        $homeInfo = [
            'title' => '首页',
            'href' => 'page/welcome-1.html?t=1',
        ];
        $logoInfo = [
            'title' => '不知名APP',
            'image' => '/layuimini/images/logo.png',
        ];
        $systemInit = [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
        ];
        return ApiReturn::ApiReturn($systemInit);
    }
}
