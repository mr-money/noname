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
        $user = $this->faceUserModel::whereOpenid('oLfzT6HKHJagFJm5GrS7w2WxEXFQ')->first();

        dump($user);
    }
}
