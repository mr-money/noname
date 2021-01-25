<?php

namespace App\Http\Controllers;

use App\Model\FaceUserModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $faceUserModel;
    public function __construct()
    {
        $this->faceUserModel = new FaceUserModel();
    }

}
