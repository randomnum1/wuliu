<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Address;
use \App\User;

class AddressController extends Controller
{

    //地址列表
    public function index(Request $request)
    {
        //逻辑
        $openid = $request->session()->get('user.openid');
        $address = User::where('openid',$openid)->first()->addresses;

        //返回
        return response()->json(
            $data = $address,
            $status = 200
        );
    }


    //地址详情
    public function show(Request $request)
    {
        //验证
        $user_id = $request->session()->get('user.id');
        $id = request('id');
        $address = Address::where([
            ['user_id','=',$user_id],
            ['id','=',$id]
        ])->get();

        //返回
        if( count($address) <= 0 ) {
            return response()->json(
                $data = ['message'=>'地址不存在'],
                $status = 422
            );
        }else{
            return response()->json(
                $data = $address,
                $status = 200
            );
        }
    }


    //新增地址
    public function create(Request $request)
    {
        //验证
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
        $user_id = $request->session()->get('user.id');
        if(request('state') == 1) {
            Address::where('user_id',$user_id)->update(['state'=>0]);
        }
        $params = array_merge(request(['country','en_name','cn_name','phone','email','province','city','area','detail','postcode','state']),compact('user_id'));
        Address::create($params);

        //返回
        return response()->json(
            $data = ['message'=>'ok'],
            $status = 200
        );
    }


    //修改地址
    public function update(Request $request)
    {
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


    //删除地址
    public function delete(Request $request)
    {
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

        //逻辑
        Address::destroy($id);

        //返回
        return response()->json(
            $data = ['message'=>'ok'],
            $status = 200
        );
    }


    //设为默认地址
    public function setting(Request $request)
    {
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

        //逻辑
        Address::where('user_id',$user_id)->update(['state'=>0]);
        $address = Address::where([
            ['user_id','=',$user_id],
            ['id','=',$id]
        ])->first();
        $address->state = 1;
        $address->save();

        //返回
        return response()->json(
            $data = ['message'=>'ok'],
            $status = 200
        );
    }


    //省市区接口
    public function china()
    {
        $json = file_get_contents('china.json');
        return response($json);
    }

}
