<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhysiqueController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 身体部位管理列表
     * @return Application|Factory|View
     */
    public function physiqueSetList()
    {
        return view('admin::physique/physiqueSetList');
    }

    /**
     * 获取身体部位ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function getPhysiqueSetAjax(Request $request): JsonResponse
    {
        $param = $request->post();

        $physique = $this->facePhysiqueSettingModel->orderBy('created_at', 'asc');
        $page = $this->layuiPage($physique, $param['page'], $param['limit']);

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $page);
    }

    //编辑身体部位
    public function editPhysiqueSet(int $id = 0)
    {
        $physique = array();

        //id不为零 查询部位设置
        if($id !== 0){
            $physique = $this->facePhysiqueSettingModel::whereId($id)->first();
        }

        return view('admin::physique/editPhysiqueSet')->with('physique',$physique);
    }

    //编辑身体部位ajax
    public function editphysiqueSetAjax(Request $request)
    {
        $param = $request->post();

        $data = array(
            'part_name' => $param['part_name'],
            'default_value' => $param['default_value'],
            'remark' => $param['remark'],
        );

        //添加
        if ((int)$param['id'] === 0) {
            $res = $this->facePhysiqueSettingModel->create($data)->id; //返回创建id
        } else { //修改
            $res = $this->facePhysiqueSettingModel::whereId($param['id'])->update($data);
        }

        return ApiReturn::jsonApi(ApiReturn::SUCCESS, '', $res);
    }


    //形象库管理列表
    public function physiqueList()
    {
        echo 'physiqueList';
    }
}
