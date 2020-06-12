<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    //登陆页面
    public function index()
    {
        if(\Auth::check()) {
            return redirect('/admin/index');
        }
        return view('admin.login.index');
    }


    //登陆行为
    public function login()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|min:1',
            'password' => 'required|min:1'
        ]);

        //逻辑
        $user = request(['name','password']);
        if(\Auth::guard("admin")->attempt($user)){
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


    //登出行为
    public function logout()
    {
        \Auth::logout();
        return redirect('/admin/login');
    }

}
