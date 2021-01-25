<?php

namespace App\Http\Controllers;


class WechatController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    //
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $wechat = app('wechat.official_account.default');

        $wechat->server->push(function($message) use ($wechat) {
            \Log::info($message);

            //消息事件处理
            ob_clean();
            return $this->messageMange($message,$wechat);
        });

        ob_clean();
        return $wechat->server->serve();
    }
}
