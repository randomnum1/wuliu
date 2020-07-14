<?php

namespace App\Manage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    //判断是否登陆
    public function check(Request $request)
    {
        if ($request->session()->exists('manage')) {
            return response()->json(
                $data = ['message' => 'ok!'],
                $status = 200
            );
        }else{
            $openid = $request->session()->get('openid');
            $manage = DB::table('admin_users')->where('openid',$openid)->first();
            if($manage){
                session(['manage.id' => $manage->id, 'manage.real_name' => $manage->real_name, 'manage.phone' => $manage->phone]);
                return response()->json(
                    $data = ['message' => 'ok!'],
                    $status = 200
                );
            }else{
                return response()->json(
                    $data = ['message' => 'no login!'],
                    $status = 400
                );
            }
        }
    }


    //登陆接口
    public function login(Request $request)
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|min:1',
            'password' => 'required|min:1'
        ]);

        //逻辑
        $user = request(['name','password']);
        if(\Auth::guard("admin")->attempt($user)){
            $openid = $request->session()->get('openid');
            //初次登陆，写入openid
            $id = \Auth::guard("admin")->user()->id;
            DB::table('admin_users')->where('id',$id)->update(['openid' => $openid]);
            //session中存入用户信息
            $manage = DB::table('admin_users')->where('openid',$openid)->first();
            session(['manage.id' => $manage->id, 'manage.real_name' => $manage->real_name, 'manage.phone' => $manage->phone]);

            return response()->json(
                $data = ['message' => 'ok'],
                $status = 200
            );
        }else{
            return response()->json(
                $data = ['message' => '用户名密码不匹配'],
                $status = 422
            );
        }
    }


    /**
     * 微信网页授权
     * @return openid
     */
    public function auth2(Request $request)
    {
       if ( !isset($_GET["code"]) ) {
           $redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
           $jumpurl = $this->oauth2_snsapi_base($redirect_url);
           Header("Location: $jumpurl");
       }else {
           $access_token_oauth2 = $this->oauth2_access_token($_GET['code']);
           $openid = $access_token_oauth2['openid'];
           session(['openid' => $openid]);
           return redirect()->away('http://wl.miyacloud.cn/workPersonnel/login.html');
            // $openid = 'xnsajkxnsak132456';
            // return $openid;
       }
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
     *scope参数为snsapi_base，只获取用户openid，静默授权
     */
    public function oauth2_snsapi_base($redirect_url,$state = NULL){
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".getenv('AppId')."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_base&state=".$state."#wechat_redirect";
        return $url;
    }

    /**
     *通过code换取网页授权access_token
     *网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
     * return openid
     */
    public function oauth2_access_token($code){
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".getenv('AppId')."&secret=".getenv('AppSecret')."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_request($url);
        return $res;
    }

    /**
     * curl请求
     * 支持get、post请求
     * return 数组
     */
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



}
