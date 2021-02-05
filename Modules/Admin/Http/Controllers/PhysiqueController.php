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


    //身体部位管理列表
    public function physiqueSetList()
    {
        echo 'physiqueSetList';
    }

    //形象库管理列表
    public function physiqueList()
    {
        echo 'physiqueList';
    }
}
