<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Webhook extends BaseController
{
    //生产环境web目录
    private $web_path = '/www/wwwroot/noname';

    //作为接口传输的时候认证的密钥
    private $valid_token = 'noName@0625';


    public function __construct()
    {

    }

    public function index(): int
    {
        // 从请求头中获取签名
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        $content = file_get_contents('php://input');

        $signature = "sha1=" . hash_hmac('sha1', $content, $this->valid_token);

        if (empty($headers['X-Hub-Signature']) || $headers['X-Hub-Signature'] !== $signature) {
            header('HTTP/1.1 403 Forbidden');
            exit('error request ' . $signature);
        }

        $json = json_decode($content, true);
        $repo = $json['commits'];

        $cmd = "cd ".$this->web_path." && git checkout  master && git reset --hard && git pull origin master";

        $res = shell_exec($cmd);
        print_r($res);
        file_put_contents('webhook/gitWebhook.log', json_encode($repo)."\r\n", FILE_APPEND);

    }
}
