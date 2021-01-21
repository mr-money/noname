<?php
error_reporting(1);

// 生产环境web目录
$web_path = '/www/wwwroot/noname';
$user = 'root';
$group = 'root';

//作为接口传输的时候认证的密钥
$valid_token = 'noName@0625';

$json = file_get_contents('php://input');
$content = json_decode($json, true);

//github发送过来的签名
return $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
if (!$signature) {
    return http_response_code(404);
}

list($algo, $hash) = explode('=', $signature, 2);

//计算签名
$payloadHash = hash_hmac($algo, $json, $valid_token);
if ($hash !== $payloadHash){
    return http_response_code(404);
}

//调用接口被允许的ip地址
$client_ip = $_SERVER['REMOTE_ADDR'];

$fs = fopen('./auto_hook.log', 'a');
fwrite($fs, 'Request on ['.date("Y-m-d H:i:s").'] from ['.$client_ip.']'.PHP_EOL);

$json_content = file_get_contents('php://input');
$data = json_decode($json_content, true);

fwrite($fs, 'Data: '.json_encode($data).PHP_EOL);
fwrite($fs, '======================================================================='.PHP_EOL);
$fs and fclose($fs);

if (empty($data['token']) || $data['token'] !== $valid_token) {
    exit('aInvalid token request');
}

$repo = $data['repository']['name'];

$cmd = "cd $web_path && git checkout  master && git pull origin master";
shell_exec($cmd);
