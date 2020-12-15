<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ApiReturn extends BaseController
{
    static private $debugInfo = null;
    static private $dataType;

    const SUCCESS = 200;
    const DB_SAVE_ERROR = 4002;
    const DB_READ_ERROR = 4003;
    const LOGIN_ERROR = 4007;
    const NOT_EXISTS = 4008;
    const TYPE_ERROR = 4010;
    const EMPTY_PARAMS = 4012;
    const DATA_EXISTS = 4013;
    const AUTH_ERROR = 4014;

    const EMPTY_USER = 994;
    const PARAM_INVALID = 995;
    const UNKNOWN = 998;

    public function __construct()
    {
    }

    /**
     * 设置Debug信息
     * @param $info
     */
    static public function debug($info)
    {
        if (APP_DEBUG) {
            //array_push(self::$debugInfo, $info);
            self::$debugInfo = $info;
        }
    }

    /**
     * api返回
     * @param null $code
     * @param string $msg
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    static public function jsonApi($code = null, $msg = '操作成功', $data = []): \Illuminate\Http\JsonResponse
    {
        $returnData = array(
            'code' => is_null($code) ? Self::SUCCESS : $code,
            'msg' => empty($msg) ? '操作成功' : trim($msg),
            'data' => $data,
        );
        if (!empty(self::$debugInfo)) {
            $returnData['debug'] = self::$debugInfo;
        }

        return response()->json($returnData)->header('Content-Type', 'application/json; charset=UTF-8');
    }
}
