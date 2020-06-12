<?php

namespace App\Http\Controllers;

use DemeterChain\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Address;
use \App\User;

class TestController extends Controller
{

    public function index()
    {
        return view('test.index');
    }


    public function test(Request $request)
    {
        //打印sql
//        DB::connection()->enableQueryLog();
//        dd(DB::getQueryLog());

        //验证
        $user_id = $request->session()->get('user.id');
        $id = request('id');
        $address = Address::where([
            ['user_id','=',$user_id],
            ['id','=',$id]
        ])->exists();

        if(!$address) {
            return response()->json(
                $data = ['message'=>'地址不存在'],
                $status = 422
            );
        }

        $messages = [
            'in' => '请重新设置默认地址',
        ];
        $validated = $request->validate([
            'country' => 'required|max:255',
            'en_name' => 'required|max:255',
            'cn_name' => 'required|max:255',
            'phone' => 'required|min:6|max:20',
            'email' => 'required|email|max:255',
            'province' => 'required|max:255',
            'city' => 'present|max:255',
            'area' => 'present|max:255',
            'detail' => 'required|max:255',
            'postcode' => 'required|max:255',
            'state' => 'required|in:0,1',
        ],$messages);

        //逻辑
        if(request('state') == 1) {
            Address::where('user_id',$user_id)->update(['state'=>0]);
        }
        $params = request(['country','en_name','cn_name','phone','email','province','city','area','detail','postcode','state']);
        DB::table('addresses')->where('id', $id)->update($params);

        //返回
        return response()->json(
            $data = ['message'=>'ok'],
            $status = 200
        );

    }

}
