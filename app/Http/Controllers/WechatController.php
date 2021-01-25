<?php

namespace App\Http\Controllers;


use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Text;

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

    /**
     * 消息管理
     * @param $message
     * @param $wechat
     * @return Image|Text|string
     */

    private function messageMange($message,$wechat){
        switch ($message['MsgType']) {
            case 'event':

                if ($message['Event']=='subscribe') {

                    return $this->subscribeMange($message,$wechat);

                }else if ($message['Event']=='unsubscribe') {
                    //取消关注时执行的操作，（注意下面返回的信息用户不会收到，因为你已经取消关注，但别的操作还是会执行的<如：取消关注的时候，要把记录该用户从记录微信用户信息的表中删掉>）

                    return $this->unsubscribeManage($message,$wechat);

                }else if($message['Event']=='CLICK'){
                    return $this->clickManage($message,$wechat);
                }



                return '收到事件消息';
                break;
            case 'text':
//                return "收到\n文字消息<a href='http://www.baidu.com'>这是一个链接</a></br><br/>\r\n".$message['MsgType'];
                break;
            case 'image':
//                return '收到图片消息';
                break;
            case 'voice':
//                return '收到语音消息';
                break;
            case 'video':
//                return '收到视频消息';
                break;
            case 'location':
//                return '收到坐标消息';
                break;
            case 'link':
//                return '收到链接消息';
                break;
            case 'file':
//                return '收到文件消息';
                // ... 其它消息
            default:
//                return '收到其它消息';
                break;
        }


    }

    /**
     * 回复图片信息
     * @param $message
     * @param $wechat
     * @return Image
     */
    public function clickManage($message,$wechat){
//        return $message['EventKey'];
        $openid = $message['FromUserName'];
        switch ($message['EventKey']){
            //咨询热线
            case 'clickMenu';
                return new Text('点击事件');
        }
    }



    /**
     * 关注逻辑处理
     * @param $message
     * @param $wechat
     * @return mixed
     */
    public function subscribeMange($message,$wechat){
        //下面是你点击关注时，进行的操作
        $openid = $message['FromUserName'];

        $marketWxuser = $this->marketWxuserModel::whereOpenid($openid)->first();

        if(empty($marketWxuser)){
            $userService = $wechat->user;
            $user = $userService->get($openid);

            $data = array(
                'openid' => $openid,
                'nickname' => $user['nickname'],
                'avatar' => $user['headimgurl'],
                'sex' => $user['sex'],
                'city' => $user['city'],
                'province' => $user['province'],
                'country' => $user['country'],
                'is_subscribe' => 1,
                'subscribe_time' => $user['subscribe_time'],
            );

            $this->marketWxuserModel->create($data);
        }else{
            $marketWxuser->is_subscribe =  1;
            $marketWxuser->save();
        }

        //关注文案
//        $content = "亲，您终于来了，我们在此恭候多时啦！\r\n以下是为您准备的新人福利：\r\n首次关注即可领取新人兑换券一张 \r\n<a href='http://wx.jzhome360.com/market/getCoupon'>【猛戳我领取兑换券，来门店兑换超值好礼】</a>";

        $content = "终于等到你啦~\r\n\r\n想了解家装选材干货？关注极家汇家居生活馆就对了！\r\n\r\n戳《案例集锦》获取往期案例↓↓↓\r\n戳《选材指南》获取更多家装干货分享↓↓↓\r\n\r\n需要装修或设计服务的，可以直接公众号留言回复哦~";
        return new Text($content);
    }

    /**
     * @param $message
     * @param $wechat
     * 取消关注的操作
     */
    public function unsubscribeManage($message,$wechat){
        $wxuser = new Wxuser;
        $result = $wxuser->where(array('openid'=>$message['FromUserName']))->first();
        $result->is_subscribe =  0;
        $result->save();

        return '取消关注';
    }




    /**
     * 添加菜单
     */
    public  function  menu_add(){
        $app = app('wechat.official_account.market');

        $buttons = [
            [
                "name"       => "案例集锦",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "精选案例",
                        "url"  => "https://mp.weixin.qq.com/mp/appmsgalbum?__biz=MzkxNjA0ODQxOA==&action=getalbum&album_id=1668860411212824578#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "设计服务",
                        "url"  => url('market/designServe'),
                    ],
                    /*[
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],*/
                ],
            ],
            [
                "name" => "选材指南",
                "type" => "view",
                "url"  => 'https://mp.weixin.qq.com/mp/appmsgalbum?__biz=MzkxNjA0ODQxOA==&action=getalbum&album_id=1700496940834062337#wechat_redirect',
            ],
            /*[
                "name" => "近期活动",
                "type" => "view",
                "url"  => 'https://jz.gazolife.com/couponList',
            ],*/

        ];
        dump($buttons);
        $res = $app->menu->create($buttons);
        dump($res);
    }

    /**
     * 删除菜单
     */
    public  function  menu_destroy(){
        $app = app('wechat.official_account.market');
        $menu = $app->menu;
        $menu->destroy();
    }

    /**
     * 查看微信公众号当前的菜单
     */
    public  function  menu_current(){
        $app = app('wechat.official_account.market');
        $current = $app->menu->current();
        var_dump($current);
    }

    /**
     * @param $openid
     * @param $template_id
     * 发送模板消息
     */
    public function sendTempleMessage($openid,$template_id,$temple_data)
    {
        $app = app('wechat.official_account.market');

        $app->template_message->send([
            'touser' => $openid,
            'template_id' => $template_id,
            'url' =>route('wxregister'),
            'data' => [
                'first' => [$temple_data['first'],'#173177'],
                'keyword1' => [$temple_data['keyword1'],'#FF0000'],
                'remark' => [$temple_data['remark'],'#173177'],
            ],
        ]);
    }
}
