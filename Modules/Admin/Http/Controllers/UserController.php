<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\ApiReturn;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function userList()
    {
        $userData = array(
            'openid' => 'oLfzT6HKHJagFJm5GrS7w2WxEXFQ',
            'nickname' => '低调的小香菇😈',
            'avatar' => 'http://thirdwx.qlogo.cn/mmopen/fU6cXgFxgovYcP0sHjfc9ZoxXXfhCxkx8leZiccelWQSibuSCPMicJKmRg7T0EchQYttL7fxUa3ibebwfLNs2WquyHWcMM41fVDR/132',
            'sex' => 1,
            'city' => '',
            'province' => '',
            'country' => '冰岛',
            'is_subscribe' => 1,
            'user_state' => 1,
            'subscribe_time' => 1611646415,
        );

//        $user = $this->faceUserModel::whereOpenid('oLfzT6HKHJagFJm5GrS7w2WxEXFQ')->first();

        $res = $this->faceUserModel::create($userData);

        dump($res);
    }
}
