<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use \App\Manage\Controllers\LoginController;

class CheckManage
{
    /**
     * 验证管理者是否绑定微信
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('manage')) {
            $login = new LoginController();
            $openid = $login->auth2();
            $manage = DB::table('admin_users')->where('openid',$openid)->first();
            if($manage) {
                session(['manage.id' => $manage->id, 'manage.real_name' => $manage->real_name, 'manage.phone' => $manage->phone]);
            }else {
                return response()->json(
                    $data = ['message' => 'no login!'],
                    $status = 400
                );
            }
        }
        return $next($request);
    }


}
