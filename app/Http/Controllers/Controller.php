<?php

namespace App\Http\Controllers;

use App\Model\GoodsModel;
use App\Model\OrderModel;
use App\Model\UserModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $orderModel;
    protected $userModel;
    protected $goodsModel;
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->goodsModel = new GoodsModel();
    }

}
