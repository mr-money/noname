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

    public function index()
    {
        $json_content = file_get_contents('php://input');
        $data = json_decode($json_content, true);

        //github发送过来的签名
        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
        echo $signature;
        if (!$signature) {
            return http_response_code(404);
        }

        list($algo, $hash) = explode('=', $signature, 2);

        //计算签名
        $payloadHash = hash_hmac($algo, $json_content, $this->valid_token);
        if ($hash !== $payloadHash){
            return http_response_code(404);
        }

        //调用接口被允许的ip地址
        $client_ip = $_SERVER['REMOTE_ADDR'];

        $fs = fopen('./auto_hook.log', 'a');
        fwrite($fs, 'Request on ['.date("Y-m-d H:i:s").'] from ['.$client_ip.']'.PHP_EOL);

        fwrite($fs, 'Data: '.json_encode($data).PHP_EOL);
        fwrite($fs, '======================================================================='.PHP_EOL);
        $fs and fclose($fs);

        $cmd = "cd ".$this->web_path." && git checkout  master && git reset --hard && git pull origin master";
        echo shell_exec($cmd);


    }
}