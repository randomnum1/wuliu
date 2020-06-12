<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class UserController extends Controller
{

    //个人中心接口
    public function index(Request $request)
    {
        //逻辑
        $id = $request->session()->get('user.id');
        $user = User::where('id',$id)->get();

        //返回
        return response()->json(
            $data = $user,
            $status = 200
        );
    }


}
