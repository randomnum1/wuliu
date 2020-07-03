<?php

namespace App\Http\Middleware;

use Closure;

class WeChat
{
    /**
     * 验证微信授权存储在session中的openid
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('user')) {
            $path = str_replace('/','-', $request->path());
            return redirect()->action(
                'WeChatController@auth2', ["path" => $path]
            );
        }
        return $next($request);
    }

}
