<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\User;

class WechatController extends Controller
{

    //网页授权
    public function auth2($path)
    {
        //微信授权相关接口
//        if ( !isset($_GET["code"]) ) {
//            $redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//            $jumpurl = $this->oauth2_snsapi_userinfo($redirect_url);
//            Header("Location: $jumpurl");
//        }else {
//            $access_token_oauth2 = $this->oauth2_access_token($_GET['code']);
//            $people = $this->oauth2_get_user_info($access_token_oauth2['access_token'],$access_token_oauth2['openid']);
//        }
        $people['nickname'] = '英北物流';
        $people['headimgurl'] = '2.jpg';
        $people['openid'] = 'xnsajkxnsak132456';

        //存储会员信息
        session(['user.nickname' => $people['nickname']]);
        session(['user.head' => $people['headimgurl']]);
        session(['user.openid' => $people['openid']]);

        //逻辑
        $user = User::where('openid',$people['openid'])->first();
        if($user) {
            session(['user.id' => $user->id]);
            $user->nickname = $people['nickname'];
            $user->head = $people['headimgurl'];
            $user->updated_at = date('Y-m-d H:i:s',time());
            $user->save();
        }else {
            $user = User::create(
                ['nickname'=>$people['nickname'],'head'=>$people['headimgurl'],'openid'=>$people['openid']]
            );
            session(['user.id' => $user->id]);
        }

        //渲染
        $path = str_replace('-','/',$path);
        return redirect($path);
    }


    /**
     * 微信获取accesstoken接口
     * 暂时用数据表token存储access_token字段
     * 有效期3600秒
     * @return access_token
     *
     */
    public function get_access_token()
    {
        $token = DB::table('token')->first();
        if( time() - strtotime($token->updated_at) >= 3600) {
            //请求微信接口
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".getenv('AppId')."&secret=".getenv('AppSecret');
            $res = $this->http_request($url);
            $access_token = $res['access_token'];

            //写入数据库
            DB::table('token')->where('id', $token->id)->update(
                ['token' => $access_token,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]
            );

            return $access_token;
        }
        return $token->token;
    }


    /**
    *
    *网页授权相关接口
    *
    */
    //scope参数为snsapi_base，只获取用户openid，静默授权
    public function oauth2_snsapi_base($redirect_url,$state = NULL){
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".getenv('AppId')."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_base&state=".$state."#wechat_redirect";
        return $url;
    }

    //scope参数为snsapi_userinfo，可抓取用户的基本信息，但需要用户授权（如果用户已关注公众号，则无需授权）
    public function oauth2_snsapi_userinfo($redirect_url,$state = NULL){
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".getenv('AppId')."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
        return $url;
    }

    //通过code换取网页授权access_token
    //网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
    public function oauth2_access_token($code){
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".getenv('AppId')."&secret=".getenv('AppSecret')."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_request($url);
        return $res;
    }

    //如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token（网页授权的access_token）和openid拉取用户信息了。
    //可获取未关注用户的基本信息。
    public function oauth2_get_user_info($access_token, $openid){
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_request($url);
        return $res;
    }



    /**
     *
     * 微信jssdk相关接口
     *
     */
    //配置jssdk
    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appid,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            // "url"       => $url,
            "signature" => $signature,
            // "rawString" => $string
        );
        return $signPackage;
    }

    //生成随机数
    public function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function getJsApiTicket() {
        $accessToken = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
        $res = json_decode($this->http_request($url));
        $ticket = $res->ticket;
        return $ticket;
    }


    /**
    *
    *公众号账号管理相关接口设置
    *
    */

    //生成带参数的二维码
    //临时二维码，是有过期时间的，最长可以设置为在二维码生成后的30天（即2592000秒）后过期，但能够生成较多数量。临时二维码主要用于帐号绑定等不要求二维码永久保存的业务场景
    public function qr_scene($data){

        // $data = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}';

        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $res = $this->http_request($url,$data);

        $res = json_decode($res, true);

        return $res['ticket'];
    }

    //永久二维码，是无过期时间的，但数量较少（目前为最多10万个）。永久二维码主要用于适用于帐号绑定、用户来源统计等场景。
    //下载到本地
    public function qr_limit_scene($data){

        // {"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "test"}}}

        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $res = $this->http_request($url,$data);

        $res = json_decode($res, true);

        $qr_code_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$res['ticket'];
        $img = $this->downloadWeixinFile($qr_code_url);

        $filename = 'E:/phpstudy/PHPTutorial/WWW/apily/Public/weixin/'.date('YmdHis',time()).'.jpg';
        $this->saveWeixinFile($filename,$img['body']);
        return true;
    }

    //长链接转短链接接口
    public function shorturl(){
        $data = '{"action": "long2short", "long_url": "http://miyacloud.cn/apily/index.php/Index/test"}';

        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=$access_token";
        $res = $this->http_request($url,$data);
        $res = json_decode($res, true);
        return $res;
    }


    //HTTP请求（支持HTTP/HTTPS，支持GET/POST）
    public function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        $output = json_decode($output,true);
        return $output;
    }

    //下载图片
    function downloadWeixinFile($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
        return $imageAll;
    }

    //保存图片
    function saveWeixinFile($filename, $filecontent)
    {
        $local_file = fopen($filename, 'w');
        if (false !== $local_file){
            if (false !== fwrite($local_file, $filecontent)) {
                fclose($local_file);
            }
        }
    }


    /**
     * @模板消息
     *
     */
    public function send_message($data)
    {
        $access_token = $this->get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        $res = $this->http_request($url,$data);
        return $res;
    }


}
